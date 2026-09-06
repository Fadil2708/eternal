<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Internship;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;

class CertificateService
{
    /**
     * Issue a certificate for a completed internship.
     */
    public function issue(Internship $internship, string $issuedBy): Certificate
    {
        $this->validateInternshipForCertificate($internship);

        return DB::transaction(function () use ($internship, $issuedBy): Certificate {
            /*
             * Generate certificate number based on certificates
             * issued in the current year.
             */
            $certificateNumber = $this->generateCertificateNumber();

            /*
             * Lock evaluation when issuing certificate.
             */
            $evaluation = $internship->evaluation;

            $evaluation->evaluated_at = now();
            $evaluation->save();

            /*
             * Generate cryptographically random verification token.
             */
            $qrToken = Str::random(64);

            /*
             * QR code points to the public human-readable
             * certificate verification page.
             */
            $qrCodeUrl = route('public.verify', [
                'token' => $qrToken,
            ]);

            return Certificate::create([
                'internship_id' => $internship->id,
                'intern_id' => $internship->intern_id,
                'certificate_number' => $certificateNumber,
                'issued_by' => $issuedBy,
                'final_score' => $evaluation->final_score,
                'grade' => $evaluation->grade,
                'qr_code_token' => $qrToken,
                'qr_code_url' => $qrCodeUrl,
                'issued_at' => now(),
            ]);
        });
    }

    /**
     * Verify a certificate using its QR token.
     */
    public function verify(string $token): ?Certificate
    {
        return Certificate::query()
            ->where('qr_code_token', $token)
            ->with([
                'intern.internProfile',
                'internship.vacancy',
            ])
            ->first();
    }

    /**
     * Validate whether an internship is eligible for certificate issuance.
     */
    private function validateInternshipForCertificate(Internship $internship): void
    {
        if ($internship->status !== 'completed') {
            throw new RuntimeException(
                'Sertifikat hanya bisa diterbitkan untuk magang yang sudah selesai.'
            );
        }

        /*
         * Make sure evaluation is available.
         */
        if (! $internship->relationLoaded('evaluation')) {
            $internship->load('evaluation');
        }

        if (! $internship->evaluation) {
            throw new RuntimeException(
                'Penilaian belum diisi oleh pembimbing.'
            );
        }

        /*
         * One internship can only have one certificate.
         */
        if ($internship->certificate()->exists()) {
            throw new RuntimeException(
                'Sertifikat sudah diterbitkan.'
            );
        }
    }

    /**
     * Generate the next certificate number for the current year.
     *
     * Format:
     * CERT/TELKOM-SKB/2026/001
     * CERT/TELKOM-SKB/2026/002
     * ...
     */
    private function generateCertificateNumber(): string
    {
        $year = now()->year;

        $count = Certificate::query()
            ->whereYear('created_at', $year)
            ->lockForUpdate()
            ->count();

        return sprintf(
            'CERT/TELKOM-SKB/%d/%03d',
            $year,
            $count + 1
        );
    }
}
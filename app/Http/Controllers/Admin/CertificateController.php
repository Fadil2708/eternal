<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CertificateResource;
use App\Jobs\GenerateCertificatePdfJob;
use App\Models\Certificate;
use App\Models\Internship;
use App\Notifications\CertificateNotification;
use App\Services\CertificateService;
use App\Traits\ApiResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CertificateController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly CertificateService $certificateService
    ) {}

    public function adminIndex(Request $request): JsonResponse
    {
        $query = Certificate::with([
            'intern.internProfile',
            'issuedBy',
            'internship.vacancy',
        ]);

        if ($request->filled('grade')) {
            $query->where('grade', $request->grade);
        }

        $certificates = $query->latest()->paginate(15);

        return $this->success(
            CertificateResource::collection($certificates),
            'Certificates retrieved successfully.',
            200,
            [
                'current_page' => $certificates->currentPage(),
                'last_page' => $certificates->lastPage(),
                'per_page' => $certificates->perPage(),
                'total' => $certificates->total(),
            ]
        );
    }

    public function store(string $internshipId): JsonResponse
    {
        $internship = Internship::with('evaluation')->findOrFail($internshipId);

        try {
            $certificate = $this->certificateService->issue($internship, auth()->id());
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 422);
        }

        $certificate->intern->notify(new CertificateNotification($certificate));

        dispatch(new GenerateCertificatePdfJob($certificate));

        return $this->success(
            new CertificateResource($certificate->load(['issuedBy', 'intern', 'internship'])),
            'Sertifikat berhasil diterbitkan.',
            201
        );
    }

    public function download(string $id): BinaryFileResponse
    {
        $certificate = Certificate::findOrFail($id);

        try {
            if (! $certificate->certificate_file_url) {
                $this->generatePdf($certificate);
            }

            $path = Storage::disk('private')->path($certificate->certificate_file_url);

            if (! file_exists($path)) {
                Log::warning('[CertificateDownload] File not found on disk, regenerating', [
                    'certificate_id' => $certificate->id,
                    'expected_path' => $path,
                ]);
                $this->generatePdf($certificate);
                $path = Storage::disk('private')->path($certificate->certificate_file_url);
            }

            if (! file_exists($path)) {
                abort(404, 'File sertifikat tidak ditemukan.');
            }

            return response()->download(
                $path,
                'sertifikat_'.str_replace('/', '-', $certificate->certificate_number).'.pdf'
            );
        } catch (\Exception $e) {
            Log::error('[CertificateDownload] Failed to serve certificate', [
                'certificate_id' => $certificate->id,
                'error' => $e->getMessage(),
            ]);
            abort(500, 'Gagal mengunduh sertifikat. Silakan coba lagi.');
        }
    }

    private function generatePdf(Certificate $certificate): void
    {
        $certificate->load(['intern.internProfile', 'internship.vacancy', 'internship.supervisor.supervisorProfile']);

        $qrCodeSvg = QrCode::format('svg')
            ->size(120)
            ->margin(1)
            ->generate($certificate->qr_code_url);

        $pdf = Pdf::loadView('certificates.template', [
            'certificate' => $certificate,
            'qrCode' => $qrCodeSvg,
        ]);

        $path = "certificates/{$certificate->internship_id}/certificate.pdf";
        Storage::disk('private')->put($path, $pdf->output());
        $certificate->update(['certificate_file_url' => $path]);
    }
}

<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Traits\ApiResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CertificateController extends Controller
{
    use ApiResponse;

    public function download(string $id): BinaryFileResponse
    {
        $certificate = Certificate::where('intern_id', auth()->id())
            ->findOrFail($id);

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
                'user_id' => auth()->id(),
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

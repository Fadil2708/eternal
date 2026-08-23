<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Traits\ApiResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CertificateController extends Controller
{
    use ApiResponse;

    public function download(string $id): JsonResponse|BinaryFileResponse
    {
        $certificate = Certificate::where('intern_id', auth()->id())
            ->findOrFail($id);

        if (! $certificate->certificate_file_url) {
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

        $path = Storage::disk('private')->path($certificate->certificate_file_url);

        if (! file_exists($path)) {
            return $this->error('File sertifikat tidak ditemukan.', 404);
        }

        return response()->download($path, 'sertifikat_'.str_replace('/', '-', $certificate->certificate_number).'.pdf');
    }
}

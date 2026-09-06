<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    private const PROFILE_PHOTO_MIMES = [
        'image/jpeg',
        'image/png',
    ];

    private const PROFILE_PHOTO_EXTENSIONS = [
        'jpg',
        'jpeg',
        'png',
    ];

    private const DOCUMENT_MIMES = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ];

    private const DOCUMENT_EXTENSIONS = [
        'pdf',
        'doc',
        'docx',
    ];

    /**
     * Validasi file berdasarkan jenis upload.
     */
    private function validateFile(
        UploadedFile $file,
        array $allowedMimes,
        array $allowedExtensions
    ): void {
        $extension = strtolower(
            $file->getClientOriginalExtension()
        );

        if (! in_array($extension, $allowedExtensions, true)) {
            throw new \InvalidArgumentException(
                "File extension .{$extension} is not allowed."
            );
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        if ($finfo === false) {
            throw new \RuntimeException(
                'Unable to initialize file type detection.'
            );
        }

        $detectedMime = finfo_file(
            $finfo,
            $file->getPathname()
        );

        finfo_close($finfo);

        /*
         * Beberapa environment/container dapat mendeteksi
         * file kosong/unknown sebagai generic MIME.
         */
        $genericMimes = [
            'application/octet-stream',
            'application/x-empty',
            'inode/x-empty',
            '',
        ];

        if (
            $detectedMime === false
            || in_array($detectedMime, $genericMimes, true)
        ) {
            $detectedMime = $file->getMimeType();
        }

        if (! in_array($detectedMime, $allowedMimes, true)) {
            throw new \InvalidArgumentException(
                "File type {$detectedMime} is not allowed."
            );
        }
    }

    /**
     * Simpan file ke private disk.
     */
    private function storeFile(
        UploadedFile $file,
        string $path,
        string $context,
        array $allowedMimes,
        array $allowedExtensions
    ): ?string {
        try {
            $this->validateFile(
                $file,
                $allowedMimes,
                $allowedExtensions
            );

            $disk = Storage::disk('private');

            if (! $disk->exists($path)) {
                $disk->makeDirectory($path);
            }

            $storedPath = $file->store(
                $path,
                'private'
            );

            if (! $storedPath) {
                throw new \RuntimeException(
                    'File::store() returned an empty path.'
                );
            }

            return $storedPath;
        } catch (\Throwable $e) {
            Log::error(
                "[FileUpload] {$context} failed: {$e->getMessage()}",
                [
                    'original_name' => $file->getClientOriginalName(),
                    'extension' => $file->getClientOriginalExtension(),
                    'mime' => $file->getMimeType(),
                    'size' => $file->getSize(),
                ]
            );

            return null;
        }
    }

    /**
     * Upload foto profil intern.
     */
    public function uploadProfilePhoto(
        UploadedFile $file,
        string $userId
    ): ?string {
        return $this->storeFile(
            $file,
            "interns/{$userId}/photo",
            'Profile photo',
            self::PROFILE_PHOTO_MIMES,
            self::PROFILE_PHOTO_EXTENSIONS
        );
    }

    /**
     * Upload CV.
     */
    public function uploadCv(
        UploadedFile $file,
        string $userId
    ): ?string {
        return $this->storeFile(
            $file,
            "interns/{$userId}/cv",
            'CV',
            self::DOCUMENT_MIMES,
            self::DOCUMENT_EXTENSIONS
        );
    }

    /**
     * Upload cover letter.
     */
    public function uploadCoverLetter(
        UploadedFile $file,
        string $userId
    ): ?string {
        return $this->storeFile(
            $file,
            "interns/{$userId}/cover-letter",
            'Cover letter',
            self::DOCUMENT_MIMES,
            self::DOCUMENT_EXTENSIONS
        );
    }

    /**
     * Upload transkrip nilai.
     */
    public function uploadTranscript(
        UploadedFile $file,
        string $userId
    ): ?string {
        return $this->storeFile(
            $file,
            "interns/{$userId}/transcript",
            'Transkrip Nilai',
            self::DOCUMENT_MIMES,
            self::DOCUMENT_EXTENSIONS
        );
    }

    /**
     * Upload laporan akhir.
     */
    public function uploadFinalReport(
        UploadedFile $file,
        string $internshipId
    ): ?string {
        return $this->storeFile(
            $file,
            "reports/{$internshipId}",
            'Final report',
            self::DOCUMENT_MIMES,
            self::DOCUMENT_EXTENSIONS
        );
    }

    /**
     * Upload sertifikat.
     *
     * Sertifikat yang dihasilkan aplikasi umumnya PDF.
     * Namun service tetap menggunakan document validation
     * agar konsisten dengan private file storage.
     */
    public function uploadCertificate(
        UploadedFile $file,
        string $internshipId
    ): ?string {
        return $this->storeFile(
            $file,
            "certificates/{$internshipId}",
            'Certificate',
            self::DOCUMENT_MIMES,
            self::DOCUMENT_EXTENSIONS
        );
    }

    /**
     * Hapus file dari private disk.
     */
    public function delete(string $path): bool
    {
        try {
            if (
                ! $path
                || ! Storage::disk('private')->exists($path)
            ) {
                return false;
            }

            return Storage::disk('private')->delete($path);
        } catch (\Throwable $e) {
            Log::error(
                "[FileUpload] Delete failed for path {$path}: {$e->getMessage()}"
            );

            return false;
        }
    }
}
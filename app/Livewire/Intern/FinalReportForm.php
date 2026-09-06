<?php

namespace App\Livewire\Intern;

use App\Models\FinalReport;
use App\Models\Internship;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

#[Layout('layouts::app', ['title' => 'Laporan Akhir'])]
class FinalReportForm extends Component
{
    use WithFileUploads;

    public $title = '';

    public ?TemporaryUploadedFile $file = null;

    public $existingReport = null;

    public bool $hasActiveInternship = false;

    public bool $canUpload = false;

    protected $rules = [
        'title' => 'required|string|max:500',
        'file' => 'required|file|mimetypes:application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document|max:20480',
    ];

    /**
     * Dipanggil Livewire ketika file selesai diterima.
     *
     * Digunakan untuk memastikan file benar-benar
     * diterima oleh Livewire sebelum proses upload.
     */
    public function updatedFile(): void
    {
        if ($this->file === null) {
            $this->addError(
                'file',
                'File gagal diterima. Pastikan ukuran file di bawah 20MB dan format PDF/DOC/DOCX.'
            );

            return;
        }

        Log::info('FINAL REPORT FILE RECEIVED', [
            'exists' => true,
            'class' => get_class($this->file),
            'name' => $this->file->getClientOriginalName(),
            'mime' => $this->file->getMimeType(),
            'size' => $this->file->getSize(),
            'pathname' => $this->file->getPathname(),
        ]);
    }

    /**
     * Inisialisasi halaman laporan akhir.
     */
    public function mount(): void
    {
        $internId = auth()->id();

        /*
         * Ambil laporan akhir terakhir milik intern.
         */
        $this->existingReport = FinalReport::where(
            'intern_id',
            $internId
        )
            ->latest()
            ->first();

        /*
         * Jika sudah memiliki laporan,
         * tampilkan kembali judul laporan sebelumnya.
         */
        if ($this->existingReport) {
            $this->title = $this->existingReport->title;
        }

        /*
         * Cari internship aktif milik intern.
         */
        $internship = Internship::where(
            'intern_id',
            $internId
        )
            ->where('status', 'active')
            ->latest()
            ->first();

        $this->hasActiveInternship = $internship !== null;

        /*
         * Intern hanya boleh upload jika:
         *
         * 1. Memiliki internship aktif
         * 2. Belum pernah memiliki laporan
         *    ATAU laporan sebelumnya ditolak supervisor.
         */
        $this->canUpload = $this->hasActiveInternship
            && (
                ! $this->existingReport
                || $this->existingReport->supervisor_approval === 'rejected'
            );
    }

    /**
     * Upload laporan akhir.
     */
    public function submitReport(): void
    {
        Log::info('FINAL REPORT SUBMIT METHOD CALLED', [
            'intern_id' => auth()->id(),
            'canUpload' => $this->canUpload,
            'has_file' => $this->file !== null,
            'title' => $this->title,
        ]);

        if (! $this->canUpload) {
            $this->addError(
                'file',
                'Anda tidak memiliki hak untuk mengupload laporan.'
            );

            return;
        }

        $this->validate();

        $internId = auth()->id();

        $internship = Internship::where(
            'intern_id',
            $internId
        )
            ->where('status', 'active')
            ->latest()
            ->first();

        if (! $internship) {
            $this->addError(
                'file',
                'Anda tidak memiliki internship aktif.'
            );

            return;
        }

        if (! $this->file) {
            $this->addError(
                'file',
                'File laporan belum dipilih.'
            );

            return;
        }

        $fileSize = $this->file->getSize();

        if ($fileSize === false || $fileSize <= 0) {
            Log::warning('FINAL REPORT EMPTY FILE', [
                'intern_id' => $internId,
                'name' => $this->file->getClientOriginalName(),
                'pathname' => $this->file->getPathname(),
                'size' => $fileSize,
            ]);

            $this->addError(
                'file',
                'File kosong atau gagal dibaca. Silakan pilih file PDF lain.'
            );

            return;
        }

        $oldFileUrl = $this->existingReport?->file_url;

        if ($oldFileUrl) {
            Storage::disk('private')->delete($oldFileUrl);
        }

        $fileSizeKb = (int) ceil(
            $fileSize / 1024
        );

        try {
            $fileUrl = $this->file->store('reports/' . $internship->id, 'private');
        } catch (\Throwable $e) {
            Log::error('FINAL REPORT FILE UPLOAD FAILED', [
                'intern_id' => $internId,
                'internship_id' => $internship->id,
                'file_name' => $this->file->getClientOriginalName(),
                'file_size' => $fileSize,
                'exception' => $e->getMessage(),
            ]);

            report($e);

            $this->addError(
                'file',
                'Gagal mengupload file. Silakan coba lagi.'
            );

            return;
        }

        if (! $fileUrl) {
            Log::error('FINAL REPORT FILE URL EMPTY', [
                'intern_id' => $internId,
                'internship_id' => $internship->id,
            ]);

            $this->addError(
                'file',
                'Gagal mengupload file. Silakan coba lagi.'
            );

            return;
        }

        /*
         * Simpan data laporan ke database.
         *
         * Menggunakan DB::transaction untuk memastikan
         * data konsisten. Hasil DB disimpan ke variabel
         * lokal terlebih dahulu, baru di-assign ke
         * property component setelah transaksi commit.
         */
        $savedReport = null;

        try {
            $savedReport = DB::transaction(function () use (
                $internship,
                $internId,
                $fileUrl,
                $fileSizeKb
            ) {
                if ($this->existingReport) {
                    $this->existingReport->update([
                        'internship_id' => $internship->id,
                        'intern_id' => $internId,
                        'title' => $this->title,
                        'file_url' => $fileUrl,
                        'file_size_kb' => $fileSizeKb,
                        'submitted_at' => now(),
                        'supervisor_approval' => 'pending',
                        'approved_at' => null,
                    ]);

                    return $this->existingReport->fresh();
                }

                return FinalReport::create([
                    'internship_id' => $internship->id,
                    'intern_id' => $internId,
                    'title' => $this->title,
                    'file_url' => $fileUrl,
                    'file_size_kb' => $fileSizeKb,
                    'submitted_at' => now(),
                    'supervisor_approval' => 'pending',
                    'approved_at' => null,
                ]);
            });
        } catch (\Throwable $e) {
            try {
                Storage::disk('private')->delete($fileUrl);
            } catch (\Throwable $deleteException) {
                Log::error('FINAL REPORT ORPHAN FILE DELETE FAILED', [
                    'file_url' => $fileUrl,
                    'exception' => $deleteException->getMessage(),
                ]);
            }

            Log::error('FINAL REPORT DATABASE SAVE FAILED', [
                'intern_id' => $internId,
                'internship_id' => $internship->id,
                'file_url' => $fileUrl,
                'exception' => $e->getMessage(),
            ]);

            report($e);

            $this->addError(
                'file',
                'Laporan gagal disimpan. Silakan coba lagi.'
            );

            return;
        }

        if (! $savedReport) {
            Log::error('FINAL REPORT NULL RESULT', [
                'intern_id' => $internId,
                'internship_id' => $internship->id,
                'file_url' => $fileUrl,
            ]);

            $this->addError(
                'file',
                'Laporan gagal disimpan. Silakan coba lagi.'
            );

            return;
        }

        /*
         * Assign hasil DB ke property component
         * SETELAH transaksi berhasil commit.
         */
        $this->existingReport = $savedReport;

        /*
         * Hapus file lama jika ada dan berbeda.
         */
        if (
            $oldFileUrl
            && $oldFileUrl !== $fileUrl
        ) {
            try {
                Storage::disk('public')->delete($oldFileUrl);
            } catch (\Throwable $e) {
                Log::warning(
                    'FINAL REPORT OLD FILE DELETE FAILED',
                    [
                        'old_file_url' => $oldFileUrl,
                        'new_file_url' => $fileUrl,
                        'exception' => $e->getMessage(),
                    ]
                );
            }
        }

        Log::info('FINAL REPORT UPLOADED SUCCESSFULLY', [
            'report_id' => $savedReport->id,
            'intern_id' => $internId,
            'internship_id' => $internship->id,
            'file_url' => $fileUrl,
        ]);

        $this->canUpload = false;

        $this->reset('file');

        $this->dispatch(
            'toast',
            message: 'Laporan akhir berhasil diunggah.',
            type: 'success'
        );
    }

    /**
     * Render halaman.
     */
    public function render()
    {
        return view('livewire.intern.final-report-form');
    }
}   
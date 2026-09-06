<?php

namespace App\Exports;

use App\Models\Logbook;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LogbooksExport implements FromQuery, WithChunkReading, WithHeadings, WithMapping
{
    public function query()
    {
        return Logbook::with(['intern.internProfile', 'internship.vacancy']);
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function headings(): array
    {
        return [
            'Peserta',
            'Posisi',
            'Tanggal Aktivitas',
            'Jenis Kehadiran',
            'Kegiatan',
            'Hasil',
            'Status Validasi',
            'Tanggal Review',
        ];
    }

    public function map($logbook): array
    {
        return [
            $logbook->intern?->displayName(),
            $logbook->internship?->vacancy?->title ?? '-',
            $logbook->activity_date?->format('Y-m-d') ?? '-',
            match ($logbook->attendance_type) {
                'sakit' => 'Sakit',
                'izin' => 'Izin',
                default => 'Hadir',
            },
            $logbook->activities,
            $logbook->output,
            $logbook->validation_status,
            $logbook->reviewed_at?->format('Y-m-d H:i') ?? '-',
        ];
    }
}

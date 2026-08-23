<?php

namespace App\Livewire\Intern;

use App\Models\FinalReport;
use App\Models\Internship;
use App\Models\Logbook;
use Illuminate\Support\Carbon;
use Livewire\Component;

class ProgramProgress extends Component
{
    public string $range = '30';

    public function render()
    {
        return view('livewire.intern.program-progress', $this->computeStats());
    }

    private function computeStats(): array
    {
        $userId = auth()->id();
        $internship = Internship::where('intern_id', $userId)->latest()->first();

        $empty = $this->emptyStats();

        if (! $internship) {
            return $empty;
        }

        $startBase = Carbon::parse($internship->actual_start_date ?? $internship->created_at ?? today())->startOfDay();
        $endDate = $internship->actual_end_date !== null
            ? ($internship->actual_end_date->lt(today()) ? $internship->actual_end_date : today())
            : today();

        $periodStart = match ($this->range) {
            '7' => today()->subDays(6)->startOfDay(),
            'all' => $startBase->copy(),
            default => today()->subDays(29)->startOfDay(),
        };

        $from = $periodStart->lt($startBase) ? $startBase->copy() : $periodStart;

        $elapsedDays = max(1, (int) $from->diffInDays($endDate) + 1);

        $logbooks = Logbook::where('intern_id', $userId)
            ->whereBetween('activity_date', [$from, $endDate])
            ->get();

        $sent = $logbooks->whereIn('validation_status', ['submitted', 'approved', 'revision_requested']);
        $reviewed = $logbooks->whereIn('validation_status', ['approved', 'revision_requested']);
        $activeDays = $logbooks->pluck('activity_date')
            ->map(fn ($date) => $date->toDateString())
            ->unique()
            ->count();

        $report = FinalReport::where('intern_id', $userId)->latest()->first();
        [$reportPct, $reportLabel] = match ($report?->supervisor_approval) {
            'approved' => [100, 'Disetujui'],
            'rejected' => [75, 'Perlu revisi'],
            'pending' => [50, 'Menunggu review'],
            default => [0, 'Belum dibuat'],
        };

        return [
            'hasInternship' => true,
            'logbookPct' => min(100, (int) round($sent->count() / $elapsedDays * 100)),
            'logbookLabel' => $sent->count() . '/' . $elapsedDays . ' hari',
            'reportPct' => $reportPct,
            'reportLabel' => $reportLabel,
            'guidancePct' => $sent->count() > 0 ? (int) round($reviewed->count() / $sent->count() * 100) : 0,
            'guidanceLabel' => $reviewed->count() . '/' . $sent->count() . ' logbook',
            'attendancePct' => min(100, (int) round($activeDays / $elapsedDays * 100)),
            'attendanceLabel' => $activeDays . '/' . $elapsedDays . ' hari',
        ];
    }

    private function emptyStats(): array
    {
        return [
            'hasInternship' => false,
            'logbookPct' => 0,
            'logbookLabel' => '0 hari',
            'reportPct' => 0,
            'reportLabel' => 'Belum ada program',
            'guidancePct' => 0,
            'guidanceLabel' => '0 logbook',
            'attendancePct' => 0,
            'attendanceLabel' => '0 hari',
        ];
    }
}
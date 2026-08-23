<?php

namespace Tests\Feature\Livewire\Intern;

use App\Livewire\Intern\ProgramProgress;
use App\Models\FinalReport;
use App\Models\Internship;
use App\Models\Logbook;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class ProgramProgressTest extends TestCase
{
    public function test_mount_without_internship_shows_zero_progress(): void
    {
        $intern = User::factory()->intern()->create();

        Livewire::actingAs($intern)
            ->test(ProgramProgress::class)
            ->assertSet('range', '30')
            ->assertSee('Belum ada program')
            ->assertSee('0%');
    }

    public function test_computes_logbook_and_attendance_progress(): void
    {
        $intern = User::factory()->intern()->create();
        $internship = Internship::factory()->active()->create([
            'intern_id' => $intern->id,
            'actual_start_date' => now()->subDays(9)->toDateString(),
        ]);

        foreach ([0, 1, 2] as $daysAgo) {
            Logbook::factory()->create([
                'internship_id' => $internship->id,
                'intern_id' => $intern->id,
                'activity_date' => now()->subDays($daysAgo)->toDateString(),
                'validation_status' => 'submitted',
            ]);
        }

        Livewire::actingAs($intern)
            ->test(ProgramProgress::class)
            ->assertSee('3/10 hari')
            ->assertSee('30%');
    }

    public function test_report_progress_reflects_approval_stage(): void
    {
        $intern = User::factory()->intern()->create();
        $internship = Internship::factory()->active()->create([
            'intern_id' => $intern->id,
        ]);

        FinalReport::factory()->create([
            'internship_id' => $internship->id,
            'intern_id' => $intern->id,
            'supervisor_approval' => 'approved',
        ]);

        Livewire::actingAs($intern)
            ->test(ProgramProgress::class)
            ->assertSee('Disetujui')
            ->assertSee('100%');
    }

    public function test_guidance_progress_uses_reviewed_logbooks(): void
    {
        $intern = User::factory()->intern()->create();
        $internship = Internship::factory()->active()->create([
            'intern_id' => $intern->id,
            'actual_start_date' => now()->subDays(5)->toDateString(),
        ]);

        foreach ([['submitted', now()->subDays(2)], ['submitted', now()->subDay()], ['approved', now()]] as [$status, $date]) {
            Logbook::factory()->create([
                'internship_id' => $internship->id,
                'intern_id' => $intern->id,
                'activity_date' => $date->toDateString(),
                'validation_status' => $status,
            ]);
        }

        Livewire::actingAs($intern)
            ->test(ProgramProgress::class)
            ->assertSee('1/2 logbook')
            ->assertSee('50%');
    }

    public function test_range_filter_limits_computation_period(): void
    {
        $intern = User::factory()->intern()->create();
        $internship = Internship::factory()->active()->create([
            'intern_id' => $intern->id,
            'actual_start_date' => now()->subDays(14)->toDateString(),
        ]);

        foreach ([14, 10, 5, 1] as $daysAgo) {
            Logbook::factory()->create([
                'internship_id' => $internship->id,
                'intern_id' => $intern->id,
                'activity_date' => now()->subDays($daysAgo)->toDateString(),
                'validation_status' => 'submitted',
            ]);
        }

        Livewire::actingAs($intern)
            ->test(ProgramProgress::class)
            ->assertSee('4/15 hari')
            ->set('range', '7')
            ->assertSee('2/7 hari');
    }
}
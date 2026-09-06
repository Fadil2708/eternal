<?php

namespace Tests\Feature\Livewire\Supervisor;

use App\Livewire\Supervisor\ReportReview;
use App\Models\FinalReport;
use App\Models\InternProfile;
use App\Models\Internship;
use App\Models\User;
use App\Notifications\ReportNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Tests\TestCase;

class ReportReviewTest extends TestCase
{
    private function createReport(
        ?User $supervisor = null,
        string $status = 'pending'
    ): array {
        $supervisor ??= User::factory()->supervisor()->create();

        $intern = User::factory()->intern()->create();

        InternProfile::factory()->create([
            'user_id' => $intern->id,
        ]);

        $internship = Internship::factory()->active()->create([
            'intern_id' => $intern->id,
            'supervisor_id' => $supervisor->id,
        ]);

        $report = FinalReport::factory()->{$status}()->create([
            'internship_id' => $internship->id,
            'intern_id' => $intern->id,
        ]);

        return [
            'supervisor' => $supervisor,
            'intern' => $intern,
            'internship' => $internship,
            'report' => $report,
        ];
    }

    public function test_can_approve_report_and_send_notification(): void
    {
        Notification::fake();

        $data = $this->createReport();

        $supervisor = $data['supervisor'];
        $intern = $data['intern'];
        $report = $data['report'];

        Livewire::actingAs($supervisor)
            ->test(ReportReview::class)
            ->call('approve', $report->id);

        $freshReport = $report->fresh();

        $this->assertEquals(
            'approved',
            $freshReport->supervisor_approval
        );

        $this->assertNotNull(
            $freshReport->approved_at
        );

        Notification::assertSentTo(
            $intern,
            ReportNotification::class,
            fn (ReportNotification $notification) =>
                $notification->report->id === $report->id
                && $notification->type === 'approved'
        );
    }

    public function test_can_reject_report_and_send_notification(): void
    {
        Notification::fake();

        $data = $this->createReport();

        $supervisor = $data['supervisor'];
        $intern = $data['intern'];
        $report = $data['report'];

        Livewire::actingAs($supervisor)
            ->test(ReportReview::class)
            ->call('reject', $report->id);

        $freshReport = $report->fresh();

        $this->assertEquals(
            'rejected',
            $freshReport->supervisor_approval
        );

        $this->assertNull(
            $freshReport->approved_at
        );

        Notification::assertSentTo(
            $intern,
            ReportNotification::class,
            fn (ReportNotification $notification) =>
                $notification->report->id === $report->id
                && $notification->type === 'rejected'
        );
    }

    public function test_cannot_approve_already_reviewed_report(): void
    {
        Notification::fake();

        $data = $this->createReport(
            status: 'approved'
        );

        $supervisor = $data['supervisor'];
        $intern = $data['intern'];
        $report = $data['report'];

        $originalApprovedAt = $report->approved_at;

        Livewire::actingAs($supervisor)
            ->test(ReportReview::class)
            ->call('approve', $report->id);

        $freshReport = $report->fresh();

        $this->assertEquals(
            'approved',
            $freshReport->supervisor_approval
        );

        $this->assertEquals(
            $originalApprovedAt?->timestamp,
            $freshReport->approved_at?->timestamp
        );

        Notification::assertNothingSent();
    }

    public function test_cannot_reject_already_reviewed_report(): void
    {
        Notification::fake();

        $data = $this->createReport(
            status: 'approved'
        );

        $supervisor = $data['supervisor'];
        $intern = $data['intern'];
        $report = $data['report'];

        $originalApprovedAt = $report->approved_at;

        Livewire::actingAs($supervisor)
            ->test(ReportReview::class)
            ->call('reject', $report->id);

        $freshReport = $report->fresh();

        $this->assertEquals(
            'approved',
            $freshReport->supervisor_approval
        );

        $this->assertEquals(
            $originalApprovedAt?->timestamp,
            $freshReport->approved_at?->timestamp
        );

        Notification::assertNothingSent();
    }

    public function test_approve_other_supervisor_report_does_not_change_report(): void
    {
        Notification::fake();

        $supervisor = User::factory()->supervisor()->create();
        $otherSupervisor = User::factory()->supervisor()->create();

        $data = $this->createReport(
            supervisor: $otherSupervisor
        );

        $report = $data['report'];

        Livewire::actingAs($supervisor)
            ->test(ReportReview::class)
            ->call('approve', $report->id);

        $freshReport = $report->fresh();

        $this->assertEquals(
            'pending',
            $freshReport->supervisor_approval
        );

        $this->assertNull(
            $freshReport->approved_at
        );

        Notification::assertNothingSent();
    }

    public function test_reject_other_supervisor_report_does_not_change_report(): void
    {
        Notification::fake();

        $supervisor = User::factory()->supervisor()->create();
        $otherSupervisor = User::factory()->supervisor()->create();

        $data = $this->createReport(
            supervisor: $otherSupervisor
        );

        $report = $data['report'];

        Livewire::actingAs($supervisor)
            ->test(ReportReview::class)
            ->call('reject', $report->id);

        $freshReport = $report->fresh();

        $this->assertEquals(
            'pending',
            $freshReport->supervisor_approval
        );

        $this->assertNull(
            $freshReport->approved_at
        );

        Notification::assertNothingSent();
    }

    public function test_approve_only_updates_pending_report(): void
    {
        $data = $this->createReport();

        $supervisor = $data['supervisor'];
        $report = $data['report'];

        Livewire::actingAs($supervisor)
            ->test(ReportReview::class)
            ->call('approve', $report->id);

        $this->assertDatabaseHas('final_reports', [
            'id' => $report->id,
            'supervisor_approval' => 'approved',
        ]);
    }

    public function test_reject_only_updates_pending_report(): void
    {
        $data = $this->createReport();

        $supervisor = $data['supervisor'];
        $report = $data['report'];

        Livewire::actingAs($supervisor)
            ->test(ReportReview::class)
            ->call('reject', $report->id);

        $this->assertDatabaseHas('final_reports', [
            'id' => $report->id,
            'supervisor_approval' => 'rejected',
        ]);
    }
}
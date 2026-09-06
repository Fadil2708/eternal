<?php

namespace Tests\Feature\Notifications;

use App\Models\FinalReport;
use App\Models\InternProfile;
use App\Models\Internship;
use App\Models\User;
use App\Notifications\ReportNotification;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ReportNotificationTest extends TestCase
{
    private function createReport(): array
    {
        $intern = User::factory()->intern()->create([
            'email' => 'intern@example.com',
        ]);

        InternProfile::factory()->create([
            'user_id' => $intern->id,
            'full_name' => 'Test Intern',
        ]);

        $internship = Internship::factory()->completed()->create([
            'intern_id' => $intern->id,
        ]);

        $report = FinalReport::factory()->create([
            'intern_id' => $intern->id,
            'internship_id' => $internship->id,
            'title' => 'Laporan Akhir Magang',
        ]);

        return [$intern, $report];
    }

    public function test_rejected_notification_can_be_sent(): void
    {
        Notification::fake();

        [$intern, $report] = $this->createReport();

        $intern->notify(
            new ReportNotification($report, 'rejected')
        );

        Notification::assertSentTo(
            $intern,
            ReportNotification::class,
            fn (ReportNotification $notification) =>
                $notification->report->id === $report->id
                && $notification->type === 'rejected'
        );
    }

    public function test_approved_notification_can_be_sent(): void
    {
        Notification::fake();

        [$intern, $report] = $this->createReport();

        $intern->notify(
            new ReportNotification($report, 'approved')
        );

        Notification::assertSentTo(
            $intern,
            ReportNotification::class,
            fn (ReportNotification $notification) =>
                $notification->report->id === $report->id
                && $notification->type === 'approved'
        );
    }

    public function test_rejected_notification_database_data_is_correct(): void
    {
        [$intern, $report] = $this->createReport();

        $notification = new ReportNotification(
            $report,
            'rejected'
        );

        $data = $notification->toDatabase($intern);

        $this->assertSame('report.rejected', $data['type']);
        $this->assertSame('Laporan Ditolak', $data['title']);
        $this->assertSame('final_report', $data['model_type']);
        $this->assertSame($report->id, $data['model_id']);
    }
}
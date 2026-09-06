<?php

namespace Tests\Feature\Notifications;

use App\Models\InternProfile;
use App\Models\Internship;
use App\Models\Logbook;
use App\Models\User;
use App\Notifications\LogbookNotification;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class LogbookNotificationTest extends TestCase
{
    private function createLogbook(): array
    {
        $intern = User::factory()->intern()->create([
            'email' => 'intern@example.com',
        ]);

        InternProfile::factory()->create([
            'user_id' => $intern->id,
            'full_name' => 'Test Intern',
        ]);

        $supervisor = User::factory()->supervisor()->create([
            'email' => 'supervisor@example.com',
        ]);

        \App\Models\SupervisorProfile::factory()->create([
            'user_id' => $supervisor->id,
            'full_name' => 'Test Supervisor',
        ]);

        $internship = Internship::factory()->active()->create([
            'intern_id' => $intern->id,
            'supervisor_id' => $supervisor->id,
        ]);

        $logbook = Logbook::factory()->create([
            'internship_id' => $internship->id,
            'intern_id' => $intern->id,
            'activity_date' => now()->format('Y-m-d'),
            'activities' => 'Mengerjakan fitur aplikasi.',
            'output' => 'Fitur selesai.',
            'validation_status' => 'submitted',
        ]);

        return [$intern, $supervisor, $logbook];
    }

    public function test_new_submission_notification_can_be_sent(): void
    {
        Notification::fake();

        [$intern, $supervisor, $logbook] = $this->createLogbook();

        $supervisor->notify(
            new LogbookNotification($logbook, 'new_submission')
        );

        Notification::assertSentTo(
            $supervisor,
            LogbookNotification::class,
            fn (LogbookNotification $notification) =>
                $notification->logbook->id === $logbook->id
                && $notification->type === 'new_submission'
        );
    }

    public function test_approved_notification_can_be_sent(): void
    {
        Notification::fake();

        [$intern, $supervisor, $logbook] = $this->createLogbook();

        $intern->notify(
            new LogbookNotification($logbook, 'approved')
        );

        Notification::assertSentTo(
            $intern,
            LogbookNotification::class,
            fn (LogbookNotification $notification) =>
                $notification->logbook->id === $logbook->id
                && $notification->type === 'approved'
        );
    }

    public function test_revision_requested_notification_can_be_sent(): void
    {
        Notification::fake();

        [$intern, $supervisor, $logbook] = $this->createLogbook();

        $intern->notify(
            new LogbookNotification($logbook, 'revision_requested')
        );

        Notification::assertSentTo(
            $intern,
            LogbookNotification::class,
            fn (LogbookNotification $notification) =>
                $notification->logbook->id === $logbook->id
                && $notification->type === 'revision_requested'
        );
    }

    public function test_notification_database_data_for_approved(): void
    {
        [$intern, $supervisor, $logbook] = $this->createLogbook();

        $notification = new LogbookNotification(
            $logbook,
            'approved'
        );

        $data = $notification->toDatabase($intern);

        $this->assertSame('logbook.approved', $data['type']);
        $this->assertSame('Logbook Disetujui', $data['title']);
        $this->assertSame('logbook', $data['model_type']);
        $this->assertSame($logbook->id, $data['model_id']);
    }
}
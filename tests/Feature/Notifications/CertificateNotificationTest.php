<?php

namespace Tests\Feature\Notifications;

use App\Models\Certificate;
use App\Models\InternProfile;
use App\Models\Internship;
use App\Models\User;
use App\Notifications\CertificateNotification;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CertificateNotificationTest extends TestCase
{
    public function test_certificate_notification_can_be_sent(): void
    {
        Notification::fake();

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

        $certificate = Certificate::factory()->create([
            'intern_id' => $intern->id,
            'internship_id' => $internship->id,
            'certificate_number' => 'CERT-001',
        ]);

        $intern->notify(new CertificateNotification($certificate));

        Notification::assertSentTo(
            $intern,
            CertificateNotification::class,
            function (CertificateNotification $notification) use ($certificate) {
                return $notification->certificate->id === $certificate->id
                    && $notification->type === 'issued';
            }
        );
    }

    public function test_certificate_notification_contains_correct_database_data(): void
    {
        $intern = User::factory()->intern()->create();

        InternProfile::factory()->create([
            'user_id' => $intern->id,
            'full_name' => 'Test Intern',
        ]);

        $internship = Internship::factory()->completed()->create([
            'intern_id' => $intern->id,
        ]);

        $certificate = Certificate::factory()->create([
            'intern_id' => $intern->id,
            'internship_id' => $internship->id,
            'certificate_number' => 'CERT-001',
        ]);

        $notification = new CertificateNotification($certificate);

        $data = $notification->toDatabase($intern);

        $this->assertSame('certificate.issued', $data['type']);
        $this->assertSame('Sertifikat Diterbitkan', $data['title']);
        $this->assertSame('certificate', $data['model_type']);
        $this->assertSame($certificate->id, $data['model_id']);
    }
}
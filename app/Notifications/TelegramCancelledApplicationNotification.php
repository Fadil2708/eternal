<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramCancelledApplicationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Application $application,
    ) {}

    public function via(object $notifiable): array
    {
        return ['telegram'];
    }

    public function toTelegram(object $notifiable): TelegramMessage
    {
        $intern = $this->application->intern;
        $profile = $intern->internProfile;
        $vacancy = $this->application->vacancy;

        $name = $profile?->full_name ?? '-';
        $institution = $profile?->institution_name ?? '-';

        $message = "❌ *Lamaran Dibatalkan*\n\n"
            . "👤 *Data Pelamar*\n"
            . "Nama: {$name}\n"
            . "Institusi: {$institution}\n\n"
            . "📋 *Lowongan*\n"
            . "Judul: {$vacancy->title}\n"
            . "Divisi: {$vacancy->division}";

        return TelegramMessage::create()
            ->to(config('services.telegram.notification_group_id'))
            ->content($message);
    }
}

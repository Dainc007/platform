<?php

namespace App\Notifications;

use App\Models\Meeting;
use App\Services\SmsService;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class MeetingStatusChanged extends Notification
{
    use Queueable;

    private Meeting $meeting;
    private SmsService $smsService;

    public function __construct(Meeting $meeting)
    {
        $this->meeting = $meeting;
        $this->smsService = new SmsService();
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $user = $this->meeting->user;
        $number = $user?->phone_number;
        $date = $this->meeting->start_date;
        $hour = $this->meeting->start_date ? date('H:i', strtotime($this->meeting->start_date)) : '';

        Log::info('MeetingStatusChanged: próba wysłania SMS', [
            'user_id' => $user?->id,
            'number' => $number,
            'status' => $this->meeting->status,
        ]);

        // Wysyłka SMS po zmianie statusu spotkania
        $smsText = null;
        switch ($this->meeting->status) {
            case 'accepted':
                $smsText = "Spotkanie zostało umówione na $date o godzinie $hour. W razie nieobecności poinformuj nas o tym.";
                break;
            case 'rejected':
                $smsText = "Wniosek o spotkanie został odrzucony.";
                break;
            // Dodaj tu kolejne statusy jeśli chcesz
        }

        if ($number && $smsText) {
            Log::info("MeetingStatusChanged: wysyłka SMS: $smsText");
            $this->smsService->sendSMS($number, $smsText);
        } elseif (!$number) {
            Log::warning("MeetingStatusChanged: Brak numeru telefonu dla user_id: " . ($user?->id ?? 'brak'));
        } else {
            Log::info("MeetingStatusChanged: Status {$this->meeting->status} nie wymaga wysyłki SMS.");
        }

        return (new MailMessage)
            ->subject('Zmiana statusu spotkania')
            ->greeting('Witaj')
            ->line('Status Twojego spotkania uległ zmianie.')
            ->line('Nowy status wniosku: ' . __('meeting.status.' . $this->meeting->status))
            ->line('Data spotkania: ' . $date)
            ->salutation('Pozdrawiam');
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}

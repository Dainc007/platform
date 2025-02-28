<?php

namespace App\Notifications;

use App\Models\Vacation;
use App\Services\SmsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Laravel\Reverb\Loggers\Log;

class VacationStatusChanged extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    private Vacation $vacation;
    private SmsService $smsService;
    public function __construct(Vacation $vacation)
    {
        $this->vacation = $vacation;
        $this->smsService = new SmsService();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $status =  __('vacation.status.'. $this->vacation->status);
        $firstDay = $this->vacation->start_at->format('d-m-Y');
        $lastDay = $this->vacation->end_at->format('d-m-Y');
        $message = "$status wniosek o dni wolne $firstDay $lastDay";

        if($notifiable->phone_number)
        {
            $this->smsService->sendSMS($notifiable->phone_number, $message);
        } else {
            \Illuminate\Support\Facades\Log::error('Brak podanego numeru telefonu dla id: ' . $notifiable->id);
        }

        return (new MailMessage)
            ->subject('Zmiana statusu wniosku urlopowego')
            ->greeting('Witaj')
            ->line('Status Twojego wniosku urlopowego uległ zmianie.')
            ->line('Nowy status wniosku:' . $status)
            ->line('Pierwszy dzień urlopu : ' . $firstDay)
            ->line('Ostatni dzień urlopu: ' . $lastDay)
            ->lineIf($this->vacation->message, "Dodatkowe informacje: {$this->vacation->message}")
            ->salutation('Pozdrawiam');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

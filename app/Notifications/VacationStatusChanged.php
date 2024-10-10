<?php

namespace App\Notifications;

use App\Models\Vacation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VacationStatusChanged extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    private Vacation $vacation;
    public function __construct(Vacation $vacation)
    {
        $this->vacation = $vacation;
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
        return (new MailMessage)
            ->subject('Zmiana statusu wniosku urlopowego')
            ->greeting('Witaj')
            ->line('Status Twojego wniosku urlopowego uległ zmianie.')
            ->line('Nowy status wniosku:' . __('status'. $this->vacation->status))
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

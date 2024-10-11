<?php

namespace App\Notifications;

use App\Models\Vacation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VacationRequestCreated extends Notification
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
        $username = $this->vacation->user->name;
        return (new MailMessage)
            ->subject($username . ' - Wniosek Urlopowy')
            ->greeting('Witaj')
            ->line($username . ' zawnioskował o urlop:')
            ->line($this->vacation->start_at->format('Y-m-d') . ' : ' . $this->vacation->end_at->format('Y-m-d'));
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

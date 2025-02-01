<?php

namespace App\Notifications;

use App\Models\Meeting;
use App\Services\SmsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MeetingStatusChanged extends Notification
{
    use Queueable;

    private Meeting $meeting;
    private SmsService $smsService;

    /**
     * Create a new notification instance.
     */
    public function __construct(Meeting $meeting)
    {
        $this->meeting = $meeting;
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
        $user = $this->meeting->user;
        $status = __('vacation.status.' . $this->meeting->status);

        if ($number = $user->phone_number) {
            $date = $this->meeting->start_date;
            $message = "$status wniosek o spotkanie $date";
            $this->smsService->sendSMS($number, $message);
        }

        return (new MailMessage)
            ->subject('Zmiana statusu spotkania')
            ->greeting('Witaj')
            ->line('Status Twojego spotkania uległ zmianie.')
            ->line('Nowy status wniosku:' . $status)
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

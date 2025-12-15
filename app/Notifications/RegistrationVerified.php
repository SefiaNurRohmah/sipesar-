<?php

namespace App\Notifications;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationVerified extends Notification
{
    use Queueable;

    protected $registration;

    /**
     * Create a new notification instance.
     */
    public function __construct(Registration $registration)
    {
        $this->registration = $registration;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database']; // Only database for now
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $statusText = '';
        if ($this->registration->status === 'diterima') {
            $statusText = 'diterima';
        } elseif ($this->registration->status === 'ditolak') {
            $statusText = 'ditolak';
        } else {
            $statusText = 'diperbarui';
        }

        return [
            'title' => 'Status Pendaftaran Diperbarui!',
            'message' => "Pendaftaran Anda untuk '{$this->registration->nama}' telah {$statusText}.",
            'link' => route('siswa.hasil'),
            'registration_id' => $this->registration->id,
            'status' => $this->registration->status,
        ];
    }
}
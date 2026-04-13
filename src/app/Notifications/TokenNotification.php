<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TokenNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($token, $horaExpiracao, $name = null)
    {
        $this->token = $token;
        $this->name = $name;
        $this->horaExpiracao = $horaExpiracao;
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
            ->subject("Token de Acesso")
            ->greeting($this->name ? "Olá, {$this->name}!" : 'Olá!')
            ->line('Aqui está o token de acesso para o ContabilTarefa:')
            ->line("**{$this->token}**")
            ->line('Obrigado por usar nosso sistema.');

        // return (new MailMessage)
        //     ->subject("Token de Acesso")
        //     ->view('emails.token', compact('token', 'name', 'horaExpiracao'));
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

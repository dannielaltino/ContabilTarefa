<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class executionRequestNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($cliente, $servico, $name = NULL)
    {
        $this->cliente = $cliente;
        $this->servico = $servico;
        $this->name = $name;
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
            ->subject("Solicitação de serviço")
            ->greeting($this->name ? "Olá, {$this->name}!" : 'Olá!')
            ->line("Um dos seus clientes, {$this->cliente}, requisitou o serviço {$this->servico}!")
            ->line('Acesse a plataforma para responder a solicitação.')
            ->line('Obrigado por usar nosso sistema.')
            ->salutation(config(('app.name')));;
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

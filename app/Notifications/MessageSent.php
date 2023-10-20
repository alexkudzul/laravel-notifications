<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MessageSent extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * ShouldQueue: permite poner en cola las notificaciones.
     *
     * Si se utiliza la opcion de database en la configuración del servidor.
     * QUEUE_CONNECTION=database
     *
     * Es necesario agregar la migración de las notificaciones a la BD.
     * php artisan queue:table
     *
     * Para hacer pruebas en local ejecutar el siguiente comando:
     * php artisan queue:work
     */

    public $data;

    /**
     * Create a new notification instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
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
        $senderUser = User::find($this->data['sender_user_id']);

        return (new MailMessage)
            ->error() // Estilo de mensaje, pinta en color rojo del boton y cambia el contenido de los textos si que no esta agregado.
            ->greeting('Titulo Mensaje')
            ->line("{$senderUser->name} Te ha enviado un mensaje.")
            ->line($this->data['body'])
            ->lineIf(true, 'Este es un mensaje de prueba desde un lineIf.')
            ->action('Ver mensaje', url('/dashboard'))
            ->line('Thank you for using our application!');
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

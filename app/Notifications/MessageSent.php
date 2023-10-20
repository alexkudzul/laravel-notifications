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

    /**
     * Personalizando las plantillas y componentes.
     *
     * https://laravel.com/docs/10.x/notifications#customizing-the-templates
     * https://laravel.com/docs/10.x/notifications#customizing-the-components
     *
     * Se tendra que publicar las vistas con los siguiente comandos:
     * php artisan vendor:publish --tag=laravel-notifications
     * php artisan vendor:publish --tag=laravel-mail
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

        // return (new MailMessage)
        //     ->from('no-reply@example.com', 'Alex Ku Dzul') // Correo del remitente (sender)
        //     ->error() // Estilo de mensaje, pinta en color rojo del boton y cambia el contenido de los textos si que no esta agregado.
        //     ->subject($this->data['subject'])
        //     ->greeting('Titulo Mensaje')
        //     ->line("{$senderUser->name} Te ha enviado un mensaje.")
        //     ->line($this->data['body'])
        //     ->lineIf(true, 'Este es un mensaje de prueba desde un lineIf.')
        //     ->action('Ver mensaje', url('/dashboard'))
        //     ->line('Thank you for using our application!');

        // Uso de Markdown en las notificaciones, permite tener las vistas mas personalizadas y agregar logica.
        return (new MailMessage)
            ->from('no-reply@example.com', 'Alex Ku Dzul') // Correo del remitente (sender)
            ->subject($this->data['subject'])
            ->markdown('mail.message-sent', [
                'senderUser' => $senderUser,
                'body' => $this->data['body'],
            ]);

        /* Uso de view en las notificaciones, funciona igual que el uso de Markdown,
         con la diferencia que se usara una vista blade y no por componentes.
         Se puede agregar html y css o algun framework de css. */

        // ->view('mail.message-sent', [
        //     'senderUser' => $senderUser,
        //     'body' => $this->data['body'],
        // ]);
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

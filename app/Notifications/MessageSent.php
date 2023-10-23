<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

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

    /**
     * Canal database
     *
     * Para usar el canal de base de datos se tiene que agregar la
     * migración de las notificaciones a la BD, con el siguiente comando:
     * php artisan notifications:table
     */

    public $message;

    /**
     * Create a new notification instance.
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $senderUser = User::find($this->message->sender_user_id);

        // return (new MailMessage)
        //     ->from('no-reply@example.com', 'Alex Ku Dzul') // Correo del remitente (sender)
        //     ->error() // Estilo de mensaje, pinta en color rojo del boton y cambia el contenido de los textos si que no esta agregado.
        //     ->subject($this->message->subject)
        //     ->greeting('Titulo Mensaje')
        //     ->line("{$senderUser->name} Te ha enviado un mensaje.")
        //     ->line($this->message->body)
        //     ->lineIf(true, 'Este es un mensaje de prueba desde un lineIf.')
        //     ->action('Ver mensaje', url('/dashboard'))
        //     ->line('Thank you for using our application!');

        // Uso de Markdown en las notificaciones, permite tener las vistas mas personalizadas y agregar logica.
        return (new MailMessage)
            ->from('no-reply@example.com', 'Alex Ku Dzul') // Correo del remitente (sender)
            ->subject($this->message->subject)
            ->attach(public_path('img/alpine.webp'), [
                'as' => 'alpine-image.webp',
                'mime' => 'image/webp',
            ])
            ->markdown('mail.message-sent', [
                'senderUser' => $senderUser,
                'body' => $this->message->body,
            ]);

        /* Uso de view en las notificaciones, funciona igual que el uso de Markdown,
         con la diferencia que se usara una vista blade y no por componentes.
         Se puede agregar html y css o algun framework de css. */

        // ->view('mail.message-sent', [
        //     'senderUser' => $senderUser,
        //     'body' => $this->message->body,
        // ]);
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        /* - $notifiable: usuario que se va a notificar.
            - Cuando se envie una notificacion incrementar el contador
            notification de la tabla users.
            - Campo que sera usado para mostrar notificaciones nuevas
            en el navbar */
        $notifiable->notification += 1;
        $notifiable->save();

        $senderUser = User::find($this->message->sender_user_id);

        return [
            'url' => route('messages.show', $this->message),
            'message' => "Has recibido un nuevo mensaje de $senderUser->name",
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([]);
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

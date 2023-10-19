<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Notifications\MessageSent;
use Illuminate\Support\Facades\Notification;

class MessageController extends Controller
{
    public function create()
    {
        $users = User::where('id', '!=', auth()->user()->id)->get();

        return view('messages.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject' => 'required',
            'body' => 'required',
            'recipient_user_id' => 'required|exists:users,id',
        ]);

        $data['sender_user_id'] = auth()->user()->id;

        Message::create($data);

        $recipientUser = User::find($data['recipient_user_id']);

        $delay = now()->addSeconds(10);

        $recipientUser->notify(new MessageSent($data)); // Enviar solo a un usuario especifico

        // Notification::send($recipientUser, new MessageSent()); // Enviar a todos los usuarios ejemplo: User::all() o $users

        // $recipientUser->notify((new MessageSent())->delay($delay)); // Retrasar el envío por 10 segundos.

        // $recipientUser->notify((new MessageSent())->delay([
        //     'mail' => $delay,
        //     'database' => $delay,
        //     'broadcast' => $delay,
        // ])); // Retrasar el envío de notificaciones por 10 segundos de acuerdo al canal

        session()->flash('flash.banner', '¡Mensaje enviado!');

        return to_route('messages.create');
    }
}

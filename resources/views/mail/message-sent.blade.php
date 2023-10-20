<x-mail::message>
# Hola {{ $senderUser->name }} te ha enviado un mensaje

Mensaje:

<x-mail::panel>
{{ $body }}
</x-mail::panel>

<x-mail::button :url="url('/dashboard')" color="red">
Ver mensaje
</x-mail::button>

Gracias, <br>
{{ config('app.name') }}

</x-mail::message>

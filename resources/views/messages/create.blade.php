<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mensajes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white px-8 py-6 rounded-lg shadow-lg">
                <form action="{{ route('messages.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <x-label class="mb-1">Asunto</x-label>
                        <x-input type="text" class="w-full" name="subject"
                            placeholder="Escriba el asunto del mensaje" />
                    </div>

                    <div class="mb-4">
                        <x-label class="mb-1">Mensaje</x-label>
                        <textarea class="form-control w-full" name="body" placeholder="Escriba su mensaje"></textarea>
                    </div>

                    <div class="mb-4">
                        <x-label class="mb-1">Destinatario</x-label>
                        <select name="recipient_user_id" class="form-control w-full">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <x-button>Enviar</x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

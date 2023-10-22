<div class="ml-3 relative">
    <x-dropdown align="right" width="64">
        <x-slot name="trigger">
            <span class="inline-flex rounded-md">
                <button type="button"
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                    Notificaciones

                    <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 ml-2 px-2.5 py-0.5 rounded-full">
                        9
                    </span>
                </button>
            </span>
        </x-slot>

        <x-slot name="content">
            @forelse (auth()->user()->notifications as $notification)
                <x-dropdown-link href="{{ route('profile.show') }}">
                    {{ $notification->data['message'] }}
                    <br>
                    <span class="text-xs font-semibold">
                        {{ $notification->created_at->diffForHumans() }}
                    </span>
                </x-dropdown-link>
            @empty
                <div class="px-4 py-2">
                    No tienes notificaciones
                </div>
            @endforelse
        </x-slot>
    </x-dropdown>
</div>

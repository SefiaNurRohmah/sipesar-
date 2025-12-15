{{-- Notification Dropdown --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<div class="relative" x-data="{ open: false }" @click.away="open = false">
    <button @click="open = !open" class="relative p-2 text-white hover:text-yellow-300 focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>
        @if(auth()->user()->unreadNotifications->count() > 0)
            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">{{ auth()->user()->unreadNotifications->count() }}</span>
        @endif
    </button>

    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg py-1 z-20">
        <div class="block px-4 py-2 text-xs text-gray-400">
            Notifikasi
        </div>
        @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
            <a href="{{ $notification->data['link'] ?? '#' }}" class="flex items-center px-4 py-3 border-b hover:bg-gray-100">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-teal-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">{{ $notification->data['title'] ?? 'Notifikasi Baru' }}</p>
                    <p class="text-xs text-gray-500">{{ $notification->data['message'] ?? 'Anda memiliki notifikasi baru.' }}</p>
                    <p class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</p>
                </div>
            </a>
        @empty
            <div class="block px-4 py-2 text-sm text-gray-700">Tidak ada notifikasi baru.</div>
        @endforelse
        <div class="border-t border-gray-200"></div>
        <a href="{{ route('notifications.index') }}" class="block px-4 py-2 text-sm text-center text-teal-600 hover:bg-gray-100">Lihat Semua Notifikasi</a>
    </div>
</div>


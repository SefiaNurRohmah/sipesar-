@extends('layouts.notification')

@section('title', 'Semua Notifikasi')

@section('content')
<div class="container mx-auto">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Semua Notifikasi</h1>

        @forelse ($notifications as $notification)
            <div id="notification-{{ $notification->id }}" class="flex items-center p-4 mb-3 rounded-lg {{ $notification->read_at ? 'bg-gray-100' : 'bg-blue-50' }} shadow-sm">
                <div class="flex-shrink-0 mr-4">
                    <svg class="h-6 w-6 {{ $notification->read_at ? 'text-gray-500' : 'text-blue-600' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                    </svg>
                </div>
                <div class="flex-grow">
                    <p class="text-sm font-medium text-gray-800">{{ $notification->data['title'] ?? 'Notifikasi' }}</p>
                    <p class="text-sm text-gray-600">{{ $notification->data['message'] ?? 'Anda memiliki notifikasi.' }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                </div>
                @if (!$notification->read_at)
                    <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" class="ml-auto mark-as-read-form">
                        @csrf
                        <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Tandai Sudah Dibaca</button>
                    </form>
                @endif
            </div>
        @empty
            <div class="p-4 text-center text-gray-500">
                Tidak ada notifikasi.
            </div>
        @endforelse

        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const forms = document.querySelectorAll('.mark-as-read-form');
        forms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const form = this;
                const url = form.action;
                const formData = new FormData(form);

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': formData.get('_token'),
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const notificationId = form.action.split('/').pop();
                        const notificationDiv = document.getElementById('notification-' + notificationId);
                        if (notificationDiv) {
                            notificationDiv.classList.remove('bg-blue-50');
                            notificationDiv.classList.add('bg-gray-100');
                            const button = form.querySelector('button');
                            if (button) {
                                button.remove();
                            }
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    });
</script>
@endpush

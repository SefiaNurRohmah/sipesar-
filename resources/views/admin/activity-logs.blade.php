@extends('layouts.admin.master')

@section('title', 'Riwayat Aktivitas Admin')

@section('content')
<div class="container mx-auto pt-16">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Riwayat Aktivitas Admin</h1>
        <p class="text-gray-600 mb-6">Mencatat semua perubahan penting yang dilakukan oleh admin.</p>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Waktu</th>
                        <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Admin</th>
                        <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Aksi</th>
                        <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Deskripsi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse ($activities as $activity)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-4 px-6 text-sm">
                                {{ $activity->created_at->diffForHumans() }}
                                <span class="block text-xs text-gray-500">{{ $activity->created_at->format('d M Y, H:i') }}</span>
                            </td>
                            <td class="py-4 px-6 text-sm">{{ $activity->user->name ?? 'Sistem' }}</td>
                            <td class="py-4 px-6 text-sm">
                                <span class="px-2 py-1 font-mono text-xs leading-tight text-blue-700 bg-blue-100 rounded-md">
                                    {{ $activity->action }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-sm">{{ $activity->description }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-8 text-gray-500">
                                Belum ada aktivitas yang tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $activities->links() }}
        </div>
    </div>
</div>
@endsection

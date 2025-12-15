@extends('layouts.kepala-sekolah.master')

@section('title', 'Hasil Verifikasi Pendaftaran')

@section('content')
<div class="container mx-auto pt-16">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Hasil Verifikasi Pendaftaran</h1>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-teal-600 text-white">
                    <tr>
                        <th class="py-3 px-6 text-left">No.</th>
                        <th class="py-3 px-6 text-left">Nama Lengkap</th>
                        <th class="py-3 px-6 text-left">Status</th>
                        <th class="py-3 px-6 text-left">Diverifikasi Oleh</th>
                        <th class="py-3 px-6 text-left">Tanggal Verifikasi</th>
                        <th class="py-3 px-6 text-left">Catatan</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse ($verifikasi as $item)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6">{{ $loop->iteration }}</td>
                            <td class="py-3 px-6">{{ $item->nama }}</td>
                            <td class="py-3 px-6">
                                @if ($item->status == 'diterima')
                                    <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                                        Diterima
                                    </span>
                                @else
                                    <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full">
                                        Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-6">{{ $item->verifiedBy->name ?? 'N/A' }}</td>
                            <td class="py-3 px-6">{{ $item->verified_at ? \Carbon\Carbon::parse($item->verified_at)->format('d F Y H:i') : 'N/A' }}</td>
                            <td class="py-3 px-6">{{ $item->notes ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">Belum ada data pendaftaran yang diverifikasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

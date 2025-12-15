@extends('layouts.kepala-sekolah.master')

@section('title', 'Detail Calon Siswa')

@section('content')
<div class="container mx-auto pt-16">
    <div class="flex items-center mb-6">
        <a href="{{ route('kepala-sekolah.calon-siswa') }}" class="text-blue-500 hover:text-blue-700 flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Kembali
        </a>
    </div>
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Detail Calon Siswa</h1>

    <div class="grid md:grid-cols-3 gap-6">
        <div class="md:col-span-2 bg-white rounded-xl p-6 shadow">
            <h2 class="text-xl font-semibold mb-4">Data Pribadi</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Nama</p>
                    <p class="font-medium">{{ $registration->nama ?? ($registration->user->name ?? '-') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">NIK</p>
                    <p class="font-medium">{{ $registration->nik ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Jenis Kelamin</p>
                    <p class="font-medium">{{ optional($registration)->jenis_kelamin === 'L' ? 'Laki-laki' : (optional($registration)->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tanggal Lahir</p>
                    <p class="font-medium">{{ optional($registration)->tanggal_lahir ? \Carbon\Carbon::parse($registration->tanggal_lahir)->format('d F Y') : '-' }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-sm text-gray-500">Alamat</p>
                    <p class="font-medium">{{ $registration->alamat ?? '-' }}</p>
                </div>
            </div>

            <hr class="my-6">

            <h3 class="text-lg font-semibold mb-3">Informasi Orang Tua / Kontak</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Nama Ayah</p>
                    <p class="font-medium">{{ optional($registration)->nama_ayah ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Nama Ibu</p>
                    <p class="font-medium">{{ $registration->nama_ibu ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">No. HP</p>
                    <p class="font-medium">{{ $registration->hp_ortu ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Asal TK</p>
                    <p class="font-medium">{{ $registration->nama_tk ?? '-' }}</p>
                </div>
            </div>

            <hr class="my-6">

            <h3 class="text-lg font-semibold mb-3">Catatan & Status</h3>
            <p class="text-sm text-gray-500 mb-2">Status Pendaftaran:</p>
            <p class="inline-block px-3 py-1 rounded-full 
                @if($registration->status == 'diterima') bg-green-100 text-green-800
                @elseif($registration->status == 'ditolak') bg-red-100 text-red-800
                @else bg-yellow-100 text-yellow-800
                @endif">
                {{ ucfirst($registration->status ?? 'menunggu keputusan') }}
            </p>

            <div class="mt-4">
                <p class="text-sm text-gray-500">Catatan Admin:</p>
                <p class="text-sm text-gray-700">{{ $registration->notes ?? '-' }}</p>
            </div>
        </div>

        <aside class="bg-white rounded-xl p-6 shadow">
            <h3 class="text-lg font-semibold mb-4">Dokumen Pendaftaran</h3>

            <div class="space-y-3">
                @php
                    $documents = [
                        'kk' => ['label' => 'Kartu Keluarga', 'path' => $registration->kartu_keluarga_path],
                        'akta' => ['label' => 'Akta Kelahiran', 'path' => $registration->akta_kelahiran_path],
                        'foto' => ['label' => 'Foto Siswa (3x4)', 'path' => $registration->foto_3x4_path],
                        'ijazah' => ['label' => 'Ijazah TK', 'path' => $registration->ijazah_path],
                        'ktp_ortu' => ['label' => 'KTP Orang Tua', 'path' => $registration->ktp_ortu_path],
                        'kartu_bantuan' => ['label' => 'Kartu Bantuan (Opsional)', 'path' => $registration->kartu_bantuan_path],
                    ];
                @endphp

                @foreach ($documents as $type => $doc)
                    <div class="flex items-center justify-between p-2 rounded-lg {{ !empty($doc['path']) ? 'bg-green-50' : 'bg-red-50' }}">
                        <div>
                            <p class="text-sm font-medium text-gray-700">📄 {{ $doc['label'] }}</p>
                        </div>
                        @if(!empty($doc['path']))
                        <a target="_blank" href="{{ route('kepala-sekolah.document.view', ['id' => $registration->id, 'type' => $type]) }}" class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-700">
                            Lihat
                        </a>
                        @else
                        <span class="bg-red-500 text-white px-3 py-1 rounded text-xs">Belum</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </aside>
    </div>
</div>
@endsection

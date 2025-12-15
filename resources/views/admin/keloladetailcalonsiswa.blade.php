@extends('layouts.admin.master')

@section('title', 'Detail Calon Siswa')

{{-- Jarak dari header --}}
@section('page-padding', 'pt-[90px]')

@section('content')

{{-- Title + Back Button --}}
<div class="flex items-start gap-3 mb-8">

    {{-- Tombol Kembali --}}
    <a href="{{ url()->previous() }}"
       class="p-2 rounded-lg hover:bg-gray-100 transition">
        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 19l-7-7 7-7" />
        </svg>
    </a>

    {{-- Judul --}}
    <div>
        <h2 class="text-3xl font-bold text-gray-800">Detail Calon Siswa</h2>
        <p class="text-gray-600">Informasi lengkap data pendaftar dan dokumen yang diunggah</p>
    </div>

</div>

<div class="grid lg:grid-cols-3 gap-8">

    {{-- KOLOM KIRI --}}
    <div class="lg:col-span-2 bg-white rounded-xl p-8 shadow-md border border-blue-100 space-y-8">

        {{-- DATA PRIBADI --}}
        <div>
            <h3 class="text-xl font-semibold text-blue-800 mb-4">Data Pribadi</h3>

            <div class="grid md:grid-cols-2 gap-6 text-sm">
                <div>
                    <p class="text-gray-500">Nama</p>
                    <p class="font-semibold">{{ $registration->nama ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-gray-500">NIK</p>
                    <p class="font-semibold">{{ $registration->nik ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-gray-500">Jenis Kelamin</p>
                    <p class="font-semibold">
                        {{ $registration->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-500">Tanggal Lahir</p>
                    <p class="font-semibold">{{ $registration->tanggal_lahir ?? '-' }}</p>
                </div>

                <div class="col-span-2">
                    <p class="text-gray-500">Alamat</p>
                    <p class="font-semibold">{{ $registration->alamat }}</p>
                </div>
            </div>
        </div>

        <hr>

        {{-- ORANG TUA --}}
        <div>
            <h3 class="text-xl font-semibold text-blue-800 mb-4">Informasi Orang Tua / Kontak</h3>

            <div class="grid md:grid-cols-2 gap-6 text-sm">
                <div>
                    <p class="text-gray-500">Nama Ayah</p>
                    <p class="font-semibold">{{ $registration->nama_ayah }}</p>
                </div>

                <div>
                    <p class="text-gray-500">Nama Ibu</p>
                    <p class="font-semibold">{{ $registration->nama_ibu }}</p>
                </div>

                <div>
                    <p class="text-gray-500">No. HP Orang Tua</p>
                    <p class="font-semibold">{{ $registration->hp_ortu }}</p>
                </div>

                <div>
                    <p class="text-gray-500">Asal TK</p>
                    <p class="font-semibold">{{ $registration->nama_tk }}</p>
                </div>
            </div>
        </div>

        <hr>

        {{-- STATUS --}}
        <div>
            <h3 class="text-xl font-semibold text-blue-800 mb-4">Status & Catatan</h3>

            <p class="text-sm text-gray-500 mb-1">Status Pendaftaran:</p>
            <span class="px-3 py-1 text-xs rounded-full
                @if($registration->status=='diterima') bg-green-100 text-green-700
                @elseif($registration->status=='tidak diterima') bg-red-100 text-red-700
                @else bg-yellow-100 text-yellow-700 @endif">
                {{ ucfirst($registration->status ?? 'menunggu keputusan') }}
            </span>

            <div class="mt-4">
                <p class="text-sm text-gray-500">Catatan Admin:</p>
                <p class="text-sm font-medium text-gray-700">
                    {{ $registration->notes ?? '-' }}
                </p>
            </div>
        </div>

    </div>

    {{-- KOLOM KANAN --}}
    <aside class="bg-white rounded-xl p-8 shadow-md border border-blue-100">

        <h3 class="text-xl font-semibold text-blue-800 mb-4">Dokumen Pendaftaran</h3>

        {{-- DOKUMEN WAJIB --}}
        <p class="text-xs text-gray-500 uppercase font-semibold mb-3">Dokumen Wajib</p>

        <div class="space-y-3">

            @php
                $docs = [
                    'kk' => ['label' => 'Kartu Keluarga', 'field' => 'kartu_keluarga_path'],
                    'akta' => ['label' => 'Akta Kelahiran', 'field' => 'akta_kelahiran_path'],
                    'foto' => ['label' => 'Foto 3x4', 'field' => 'foto_3x4_path'],
                    'ijazah' => ['label' => 'Ijazah TK', 'field' => 'ijazah_path'],
                    'ktp_ortu' => ['label' => 'KTP Orang Tua', 'field' => 'ktp_ortu_path'],
                ];
            @endphp

            @foreach($docs as $key => $doc)
                @php
                    $label = $doc['label'];
                    $field = $doc['field'];
                    $path = $registration->$field;
                @endphp

                <div class="flex justify-between items-center p-3 rounded-lg
                    {{ $path ? 'bg-green-50' : 'bg-red-50' }}">

                    <div>
                        <p class="text-sm font-semibold">{{ $label }}</p>
                        <p class="text-xs text-gray-500">Wajib</p>
                    </div>

                    @if($path)
                        <a href="{{ route('admin.detail.document', ['id'=>$registration->id,'type'=>$key]) }}"
                            target="_blank"
                            class="bg-green-600 text-white px-3 py-1 rounded text-xs">
                            Lihat
                        </a>
                    @else
                        <span class="bg-red-500 text-white px-3 py-1 rounded text-xs">Belum</span>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- DOKUMEN OPSIONAL --}}
        <div class="mt-6 pt-4 border-t">
            <p class="text-xs text-gray-500 uppercase font-semibold mb-3">Dokumen Opsional</p>

            <div class="flex justify-between items-center p-3 rounded-lg
                {{ $registration->kartu_bantuan_path ? 'bg-blue-50' : 'bg-gray-50' }}">

                <div>
                    <p class="text-sm font-semibold">Kartu Bantuan (KIP/PKH/KKS)</p>
                </div>

                @if($registration->kartu_bantuan_path)
                    <a href="{{ route('admin.detail.document', ['id'=>$registration->id,'type'=>'kartu_bantuan']) }}"
                        target="_blank"
                        class="bg-blue-600 text-white px-3 py-1 rounded text-xs">
                        Lihat
                    </a>
                @else
                    <span class="bg-gray-400 text-white px-3 py-1 rounded text-xs">Tidak Ada</span>
                @endif
            </div>
        </div>

        {{-- VERIFIKASI --}}
        <div class="mt-6">
            <a href="{{ route('admin.verify', $registration->id) }}"
                class="block bg-teal-600 hover:bg-teal-700 text-white text-center px-4 py-2 rounded-lg">
                Verifikasi / Ubah Status
            </a>
        </div>

    </aside>

</div>

@endsection

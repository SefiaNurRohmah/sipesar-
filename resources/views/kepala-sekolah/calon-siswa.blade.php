@extends('layouts.kepala-sekolah.master')

@section('title', 'Data Calon Siswa')

@section('content')
<div class="container mx-auto pt-16">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Data Calon Siswa</h1>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-teal-600 text-white">
                    <tr>
                        <th class="py-3 px-6 text-left">No.</th>
                        <th class="py-3 px-6 text-left">Nama Lengkap</th>
                        <th class="py-3 px-6 text-left">Tanggal Lahir</th>
                        <th class="py-3 px-6 text-left">Jenis Kelamin</th>
                        <th class="py-3 px-6 text-left">Agama</th>
                        <th class="py-3 px-6 text-left">Status Pendaftaran</th>
                        <th class="py-3 px-6 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse ($calonSiswa as $item)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6">{{ $loop->iteration }}</td>
                            <td class="py-3 px-6">{{ $item->nama }}</td>
                            <td class="py-3 px-6">{{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d F Y') }}</td>
                            <td class="py-3 px-6">{{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            <td class="py-3 px-6">{{ $item->agama }}</td>
                            <td class="py-3 px-6">
                                <span class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full">
                                    {{ ucwords($item->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-6">
                                <a href="{{ route('kepala-sekolah.calon-siswa.show', $item->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">Tidak ada data calon siswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

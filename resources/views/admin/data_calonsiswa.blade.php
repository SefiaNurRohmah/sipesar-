<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Pendaftar - SIPESAR</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        .table-row:hover {
            background-color: #f8fafc;
        }

        .sidebar {
            transition: transform 0.3s ease;
        }

        .sidebar-hidden {
            transform: translateX(-100%);
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">

    <!-- Header -->
    @include('layouts.admin.header')

    <div class="flex pt-[80px]">

        @include('layouts.admin.sidebar')

        <main class="flex-1 ml-64 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-3xl font-bold text-gray-800">Daftar Calon Siswa</h2>
            </div>
            <div class="mb-4">
                <form method="GET" action="" class="flex items-center space-x-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama, NIK, jenis kelamin, asal sekolah..."
                        class="px-4 py-2 border rounded-lg w-64 focus:ring-2 focus:ring-teal-500">

                    <!-- FILTER STATUS -->
                    <select name="status" class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500">
                        <option value="">Semua Status</option>
                        <option value="menunggu keputusan"
                            {{ request('status') == 'menunggu keputusan' ? 'selected' : '' }}>
                            Menunggu
                        </option>
                        <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>
                            Diterima
                        </option>
                        <option value="tidak diterima" {{ request('status') == 'tidak diterima' ? 'selected' : '' }}>
                            Tidak Diterima
                        </option>
                    </select>

                    <!-- Filter Gender -->
                    <select name="gender" class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500">
                        <option value="">Semua Gender</option>
                        <option value="L" {{ request('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ request('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>

                    <!-- Filter Tanggal -->
                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                        class="px-3 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500">

                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                        class="px-3 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500">

                    <button type="submit"
                        class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg font-medium">
                        Cari
                    </button>

                    <a href="{{ route('admin.data') }}"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-medium">
                        Reset
                    </a>
                </form>
            </div>


            <div class="card bg-white rounded-xl shadow p-6">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-blue-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nama
                                    Lengkap</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">NIK</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Jenis
                                    Kelamin</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Asal
                                    Sekolah</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($registrations as $i => $reg)
                                <tr class="table-row">
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $registrations->firstItem() + $i }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-800">
                                        {{ $reg->nama ?? ($reg->user->name ?? '-') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $reg->nik ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $reg->jenis_kelamin === 'L' ? 'Laki-laki' : ($reg->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $reg->nama_tk ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        @php
                                            $status = $reg->status ?? 'menuggu keputusan';
                                            if (in_array($status, ['diterima'])) {
                                                $badge =
                                                    '<span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium">Diterima</span>';
                                            } elseif (in_array($status, ['tidak diterima'])) {
                                                $badge =
                                                    '<span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-medium">Ditolak</span>';
                                            } else {
                                                $badge =
                                                    '<span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-medium">Menunggu</span>';
                                            }
                                        @endphp
                                        {!! $badge !!}
                                    </td>
                                    <td class="px-6 py-4 flex space-x-2">
                                        <a href="{{ route('admin.detail', $reg->id) }}"
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm">Detail</a>
                                        <a href="{{ route('admin.verify', $reg->id) }}"
                                            class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg text-sm">Verifikasi</a>
                                        <form action="#" method="POST"
                                            onsubmit="return confirm('Hapus pendaftar ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-sm text-gray-500">Belum ada
                                        pendaftar</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="flex items-center justify-between mt-6">
                    <p class="text-sm text-gray-600">Menampilkan 1 - 2 dari 50 pendaftar</p>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 border rounded-lg text-sm hover:bg-gray-50">Sebelumnya</button>
                        <button class="px-3 py-1 bg-blue-600 text-white rounded-lg text-sm">1</button>
                        <button class="px-3 py-1 border rounded-lg text-sm hover:bg-gray-50">2</button>
                        <button class="px-3 py-1 border rounded-lg text-sm hover:bg-gray-50">3</button>
                        <button class="px-3 py-1 border rounded-lg text-sm hover:bg-gray-50">Selanjutnya</button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>

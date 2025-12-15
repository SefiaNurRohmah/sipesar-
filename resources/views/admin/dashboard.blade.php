@extends('layouts.admin.master')

@section('title', 'Dashboard Admin')
{{-- Padding untuk menghindari ketutupan header --}}
@section('page-padding', 'pt-[80px]')

@section('content')

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .table-row {
            transition: background-color 0.2s ease;
        }

        .table-row:hover {
            background-color: #f8fafc;
        }

        .status-badge {
            font-size: .75rem;
            font-weight: 600;
            padding: .25rem .75rem;
            border-radius: 9999px;
            display: inline-block;
        }

        .status-diterima {
            background: #dcfce7;
            color: #166534;
        }

        .status-tidak-diterima {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-menunggu-keputusan {
            background: #fef3c7;
            color: #92400e;
        }
    </style>

    {{-- FLATPICKR --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <div class="p-6">

        {{-- Judul --}}
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Dashboard Admin SIPESAR</h2>
            <p class="text-gray-600">Kelola dan pantau proses penerimaan peserta didik baru SD Negeri Larangan</p>
        </div>

        {{-- Statistik --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

            {{-- Total Pendaftar --}}
            <div class="stat-card bg-white rounded-2xl p-6 shadow-lg border border-teal-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Total Pendaftar</p>
                        <p class="text-3xl font-bold">{{ $stats['total'] }}</p>
                        <p class="text-sm text-green-600">↗ Total registrasi</p>
                    </div>
                    <div class="w-12 h-12 bg-teal-100 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Diterima --}}
            <div class="stat-card bg-white rounded-2xl p-6 shadow-lg border border-green-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Diterima</p>
                        <p class="text-3xl font-bold text-green-600">{{ $stats['lolos'] }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $stats['lolos_percent'] }}% dari total</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Tidak Diterima --}}
            <div class="stat-card bg-white rounded-2xl p-6 shadow-lg border border-red-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Tidak Diterima</p>
                        <p class="text-3xl font-bold text-red-600">{{ $stats['ditolak'] }}</p>
                    </div>

                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                        {{-- ICON SILANG --}}
                        <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>
            </div>


            {{-- Menunggu --}}
            <div class="stat-card bg-white rounded-2xl p-6 shadow-lg border border-yellow-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Menunggu Keputusan</p>
                        <p class="text-3xl font-bold text-yellow-600">{{ $stats['menunggu'] }}</p>
                    </div>

                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                        {{-- ICON JAM --}}
                        <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                            <circle cx="12" cy="12" r="9" />
                        </svg>
                    </div>
                </div>
            </div>


        </div>

        {{-- Tabel Pendaftar --}}
        <div class="bg-white rounded-2xl shadow-lg border border-teal-100">

            {{-- Header Tabel --}}
            <div class="p-6 border-b flex flex-col sm:flex-row sm:justify-between gap-4">
                <div>
                    <h3 class="text-xl font-semibold">Data Pendaftar Terbaru</h3>
                    <p class="text-sm text-gray-600">Kelola dan verifikasi data pendaftar SPSB</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    {{-- Filter Status --}}
                    <select id="statusFilter" class="px-4 py-2 border rounded-lg">
                        <option value="">Semua Status</option>
                        <option value="diterima">Diterima</option>
                        <option value="tidak diterima">Tidak Diterima</option>
                        <option value="menunggu keputusan">Menunggu Keputusan</option>
                    </select>

                    {{-- Rentang Tanggal --}}
                    <input type="text" id="dateRange" placeholder="Rentang tanggal"
                        class="px-4 py-2 border rounded-lg" />

                    {{-- Terapkan --}}
                    <button id="applyFilter" class="bg-teal-600 text-white px-4 py-2 rounded-lg">Terapkan</button>

                    {{-- Reset --}}
                    <button id="resetFilter" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">Reset</button>
                </div>
            </div>

            {{-- Tabel --}}
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs">No. Pendaftaran</th>
                            <th class="px-6 py-4 text-left text-xs">Nama Siswa</th>
                            <th class="px-6 py-4 text-left text-xs">Status</th>
                            <th class="px-6 py-4 text-left text-xs">Tanggal Daftar</th>
                            <th class="px-6 py-4 text-left text-xs">Aksi</th>
                        </tr>
                    </thead>

                    <tbody id="applicantTable" class="bg-white divide-y">
                        @forelse ($recentRegistrations as $reg)
                            @php
                                $regNo = 'SPSB' . str_pad($reg->id, 6, '0', STR_PAD_LEFT);
                                $status = $reg->status ?? 'menunggu keputusan';

                                $statusClass = match ($status) {
                                    'diterima' => 'status-diterima',
                                    'tidak diterima' => 'status-tidak-diterima',
                                    default => 'status-menunggu-keputusan',
                                };

                                $statusLabel = ucwords($status);

                                $nama = $reg->nama ?? ($reg->user->name ?? '-');
                                $initials = strtoupper(substr($nama, 0, 2));

                                $umur = $reg->tanggal_lahir ? \Carbon\Carbon::parse($reg->tanggal_lahir)->age : '-';
                            @endphp

                            <tr class="table-row" data-status="{{ strtolower($status) }}"
                                data-date="{{ $reg->created_at->format('Y-m-d') }}">

                                {{-- No daftar --}}
                                <td class="px-6 py-4 text-sm font-medium text-teal-600">{{ $regNo }}</td>

                                {{-- Nama + Avatar --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-teal-100 rounded-full flex justify-center items-center mr-3">
                                            <span class="text-xs font-medium text-teal-600">{{ $initials }}</span>
                                        </div>
                                        <div>
                                            <div class="font-medium">{{ $nama }}</div>
                                            <div class="text-gray-500 text-sm">{{ $umur }} tahun</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-4">
                                    <span class="status-badge {{ $statusClass }}">{{ $statusLabel }}</span>
                                </td>

                                {{-- Tanggal --}}
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $reg->created_at->format('d M Y, H:i') }}
                                </td>

                                {{-- Aksi --}}
                                <td class="px-6 py-4 text-sm font-medium">
                                    <a href="{{ route('admin.detail', $reg->id) }}"
                                        class="text-teal-600 hover:text-teal-900">Detail</a>

                                    @if ($status === 'menunggu keputusan')
                                        <a href="{{ route('admin.verify', $reg->id) }}"
                                            class="ml-2 text-yellow-600 hover:text-yellow-900">Verifikasi</a>
                                    @endif
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-8 text-gray-500">Belum ada pendaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer Tabel --}}
            <div class="px-6 py-4 border-t flex justify-between items-center">
                <div class="text-sm text-gray-500">
                    Menampilkan <span id="visibleCount">{{ $recentRegistrations->count() }}</span> dari
                    {{ $stats['total'] }} pendaftar
                </div>

                <a href="{{ route('admin.data') }}" class="text-sm text-teal-600 hover:text-teal-700">Lihat Semua Data
                    →</a>
            </div>

        </div>

    </div>

    {{-- Script Filter --}}
    <script>
        flatpickr("#dateRange", {
            mode: "range",
            dateFormat: "Y-m-d",
            locale: "id"
        });

        const rows = document.querySelectorAll("#applicantTable .table-row");
        const statusFilter = document.getElementById("statusFilter");
        const dateInput = document.getElementById("dateRange");
        const visibleEl = document.getElementById("visibleCount");

        document.getElementById("applyFilter").addEventListener("click", () => {
            const status = statusFilter.value.toLowerCase();
            const range = dateInput.value;

            let start = null,
                end = null;

            if (range.includes(" to ")) {
                let [s, e] = range.split(" to ");
                start = new Date(s);
                end = new Date(e);
                end.setHours(23, 59, 59);
            }

            let visible = 0;

            rows.forEach(row => {
                let rowStatus = row.dataset.status;
                let rowDate = new Date(row.dataset.date);

                let matchStatus = (!status || rowStatus === status);
                let matchDate = (!start || (rowDate >= start && rowDate <= end));

                if (matchStatus && matchDate) {
                    row.style.display = "";
                    visible++;
                } else {
                    row.style.display = "none";
                }
            });

            visibleEl.textContent = visible;
        });

        document.getElementById("resetFilter").addEventListener("click", () => {
            statusFilter.value = "";
            dateInput.value = "";

            rows.forEach(r => r.style.display = "");
            visibleEl.textContent = rows.length;
        });
    </script>

@endsection

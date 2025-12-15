<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pendaftaran - SIPESAR</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .detail-card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .detail-card:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .document-item {
            transition: all 0.2s ease;
        }

        .document-item:hover {
            background-color: #f8fafc;
        }

        .status-valid {
            color: #15803d;
            background-color: #dcfce7;
        }

        .status-invalid {
            color: #b91c1c;
            background-color: #fee2e2;
        }

        .status-pending {
            color: #92400e;
            background-color: #fef3c7;
        }

        .status-accepted {
            color: #15803d;
            background-color: #d1fae5;
            border: 2px solid #10b981;
        }

        .status-rejected {
            color: #991b1b;
            background-color: #fee2e2;
            border: 2px solid #ef4444;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">

    <!-- Header -->
    <header class="bg-teal-600 text-white shadow-lg sticky top-0 z-40">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <!-- Logo + Nama -->
            <div class="flex items-center space-x-3">
                <img src="{{ asset('asset/logo sipesar.png') }}" alt="Logo SIPESAR"
                    class="w-16 h-16 rounded-full bg-white p-0 shadow">
                <div class="flex flex-col">
                    <span class="text-lg font-bold text-white">SD Negeri Larangan</span>
                    <span class="text-sm text-gray-200">Portal SIPESAR (Sistem Penerimaan Siswa Baru)</span>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="hidden md:flex items-center space-x-6 text-white font-medium">
                <a href="{{ route('siswa.dashboard') }}" class="hover:text-yellow-300">Dashboard</a>
                <a href="{{ route('siswa.form') }}" class="hover:text-yellow-300">Formulir Pendaftaran</a>
                <a href="{{ route('siswa.detail') }}" class="hover:text-yellow-300">Detail Calon Siswa</a>
                <a href="{{ route('siswa.pengumuman') }}" class="hover:text-yellow-300">Pengumuman</a>
                <a href="{{ route('siswa.hasil') }}" class="hover:text-yellow-300">Hasil Seleksi</a>
                @include('partials.notification-dropdown')
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-500 px-4 py-2 rounded-lg hover:bg-red-600">Logout</button>
                </form>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-8">
        <!-- Page Title -->
        <div class="mb-8 flex items-center space-x-3">
            <button onclick="window.location='{{ route('siswa.dashboard') }}'"
                class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <div>
                <h2 class="text-3xl font-bold text-gray-800">Detail Pendaftaran</h2>
                <p class="text-gray-600">Lihat data diri dan status dokumen Anda</p>
            </div>
        </div>

        @if ($registration)
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Main Content Area -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Data Diri Siswa -->
                    <div class="detail-card bg-white rounded-2xl p-8 border border-teal-200">
                        <h3 class="text-xl font-semibold text-[#0b6b66] mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd" />
                            </svg>
                            Data Diri Siswa
                        </h3>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <span class="text-xs text-gray-500 block mb-1">Nama Lengkap</span>
                                <span class="font-semibold text-gray-800">{{ $registration->nama ?? '-' }}</span>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <span class="text-xs text-gray-500 block mb-1">Nomor Pendaftaran</span>
                                <span
                                    class="font-semibold text-[#0ea5a3]">SPSB{{ str_pad($registration->id, 6, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <span class="text-xs text-gray-500 block mb-1">NIK</span>
                                <span class="font-semibold text-gray-800">{{ $registration->nik ?? '-' }}</span>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <span class="text-xs text-gray-500 block mb-1">Tempat Lahir</span>
                                <span
                                    class="font-semibold text-gray-800">{{ $registration->tempat_lahir ?? '-' }}</span>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <span class="text-xs text-gray-500 block mb-1">Tanggal Lahir</span>
                                <span class="font-semibold text-gray-800">
                                    {{ $registration->tanggal_lahir ? \Carbon\Carbon::parse($registration->tanggal_lahir)->locale('id')->isoFormat('D MMMM YYYY') : '-' }}
                                </span>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <span class="text-xs text-gray-500 block mb-1">Jenis Kelamin</span>
                                <span class="font-semibold text-gray-800">
                                    {{ $registration->jenis_kelamin === 'L' ? 'Laki-laki' : ($registration->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}
                                </span>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <span class="text-xs text-gray-500 block mb-1">Agama</span>
                                <span class="font-semibold text-gray-800">{{ $registration->agama ?? '-' }}</span>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg md:col-span-2">
                                <span class="text-xs text-gray-500 block mb-1">Alamat Lengkap</span>
                                <span class="font-semibold text-gray-800">{{ $registration->alamat ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Data Orang Tua -->
                    <div class="detail-card bg-white rounded-2xl p-8 border border-teal-200">
                        <h3 class="text-xl font-semibold text-[#0b6b66] mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                            </svg>
                            Data Orang Tua/Wali
                        </h3>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <span class="text-xs text-gray-500 block mb-1">Nama Ayah</span>
                                <span class="font-semibold text-gray-800">{{ $registration->nama_ayah ?? '-' }}</span>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <span class="text-xs text-gray-500 block mb-1">Nama Ibu</span>
                                <span class="font-semibold text-gray-800">{{ $registration->nama_ibu ?? '-' }}</span>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <span class="text-xs text-gray-500 block mb-1">Pekerjaan Orang Tua</span>
                                <span
                                    class="font-semibold text-gray-800">{{ $registration->pekerjaan_ortu ?? '-' }}</span>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <span class="text-xs text-gray-500 block mb-1">Nomor HP Orang Tua</span>
                                <span class="font-semibold text-gray-800">{{ $registration->hp_ortu ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Data Sekolah Asal -->
                    <div class="detail-card bg-white rounded-2xl p-8 border border-teal-200">
                        <h3 class="text-xl font-semibold text-[#0b6b66] mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                            </svg>
                            Data Sekolah Asal
                        </h3>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <span class="text-xs text-gray-500 block mb-1">Nama TK/PAUD</span>
                                <span class="font-semibold text-gray-800">{{ $registration->nama_tk ?? '-' }}</span>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <span class="text-xs text-gray-500 block mb-1">Alamat Sekolah Asal</span>
                                <span class="font-semibold text-gray-800">{{ $registration->alamat_tk ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Dokumen yang Diupload -->
                    <div class="detail-card bg-white rounded-2xl p-8 border border-teal-200">
                        <h3 class="text-xl font-semibold text-[#0b6b66] mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                    clip-rule="evenodd" />
                            </svg>
                            Dokumen yang Diupload
                        </h3>
                        <div class="space-y-4">
                            <!-- Kartu Keluarga -->
                            <div
                                class="document-item border border-gray-200 rounded-xl p-4 flex justify-between items-center">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <div>
                                        <span class="font-medium block">Kartu Keluarga</span>
                                        <span class="text-xs text-red-500">Wajib</span>
                                    </div>
                                </div>
                                @if (!empty($registration->kartu_keluarga_path))
                                    <a href="{{ route('siswa.document.view', 'kk') }}" target="_blank"
                                        class="status-valid px-3 py-1 rounded-full text-xs font-medium hover:opacity-80 transition">
                                        ✓ Lihat Dokumen
                                    </a>
                                @else
                                    <span class="status-pending px-3 py-1 rounded-full text-xs font-medium">⏳ Belum
                                        Upload</span>
                                @endif
                            </div>

                            <!-- Akta Kelahiran -->
                            <div
                                class="document-item border border-gray-200 rounded-xl p-4 flex justify-between items-center">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <div>
                                        <span class="font-medium block">Akta Kelahiran</span>
                                        <span class="text-xs text-red-500">Wajib</span>
                                    </div>
                                </div>
                                @if (!empty($registration->akta_kelahiran_path))
                                    <a href="{{ route('siswa.document.view', 'akta') }}" target="_blank"
                                        class="status-valid px-3 py-1 rounded-full text-xs font-medium hover:opacity-80 transition">
                                        ✓ Lihat Dokumen
                                    </a>
                                @else
                                    <span class="status-pending px-3 py-1 rounded-full text-xs font-medium">⏳ Belum
                                        Upload</span>
                                @endif
                            </div>

                            <!-- Foto 3x4 -->
                            <div
                                class="document-item border border-gray-200 rounded-xl p-4 flex justify-between items-center">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <div>
                                        <span class="font-medium block">Foto 3x4</span>
                                        <span class="text-xs text-red-500">Wajib</span>
                                    </div>
                                </div>
                                @if (!empty($registration->foto_3x4_path))
                                    <a href="{{ route('siswa.document.view', 'foto') }}" target="_blank"
                                        class="status-valid px-3 py-1 rounded-full text-xs font-medium hover:opacity-80 transition">
                                        ✓ Lihat Dokumen
                                    </a>
                                @else
                                    <span class="status-pending px-3 py-1 rounded-full text-xs font-medium">⏳ Belum
                                        Upload</span>
                                @endif
                            </div>

                            <!-- Ijazah TK/PAUD -->
                            <div
                                class="document-item border border-gray-200 rounded-xl p-4 flex justify-between items-center">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                                    </svg>
                                    <div>
                                        <span class="font-medium block">Ijazah TK/PAUD</span>
                                        <span class="text-xs text-red-500">Wajib</span>
                                    </div>
                                </div>
                                @if (!empty($registration->ijazah_path))
                                    <a href="{{ route('siswa.document.view', 'ijazah') }}" target="_blank"
                                        class="status-valid px-3 py-1 rounded-full text-xs font-medium hover:opacity-80 transition">
                                        ✓ Lihat Dokumen
                                    </a>
                                @else
                                    <span class="status-pending px-3 py-1 rounded-full text-xs font-medium">⏳ Belum
                                        Upload</span>
                                @endif
                            </div>

                            <!-- KTP Orang Tua -->
                            <div
                                class="document-item border border-gray-200 rounded-xl p-4 flex justify-between items-center">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 2a1 1 0 00-1 1v1a1 1 0 002 0V3a1 1 0 00-1-1zM4 4h3a3 3 0 006 0h3a2 2 0 012 2v9a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2zm2.5 7a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm2.45 4a2.5 2.5 0 10-4.9 0h4.9zM12 9a1 1 0 100 2h3a1 1 0 100-2h-3zm-1 4a1 1 0 011-1h2a1 1 0 110 2h-2a1 1 0 01-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <div>
                                        <span class="font-medium block">KTP Orang Tua</span>
                                        <span class="text-xs text-red-500">Wajib</span>
                                    </div>
                                </div>
                                @if (!empty($registration->ktp_ortu_path))
                                    <a href="{{ route('siswa.document.view', 'ktp_ortu') }}" target="_blank"
                                        class="status-valid px-3 py-1 rounded-full text-xs font-medium hover:opacity-80 transition">
                                        ✓ Lihat Dokumen
                                    </a>
                                @else
                                    <span class="status-pending px-3 py-1 rounded-full text-xs font-medium">⏳ Belum
                                        Upload</span>
                                @endif
                            </div>

                            <!-- Kartu Bantuan -->
                            <div
                                class="document-item border border-gray-200 rounded-xl p-4 flex justify-between items-center">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <div>
                                        <span class="font-medium block">Kartu Bantuan (KIP/PKH/KPS)</span>
                                        <span class="text-xs text-gray-500">Opsional (Jika Ada)</span>
                                    </div>
                                </div>
                                @if (!empty($registration->kartu_bantuan_path))
                                    <a href="{{ route('siswa.document.view', 'kartu_bantuan') }}" target="_blank"
                                        class="status-valid px-3 py-1 rounded-full text-xs font-medium hover:opacity-80 transition">
                                        ✓ Lihat Dokumen
                                    </a>
                                @else
                                    <span class="status-pending px-3 py-1 rounded-full text-xs font-medium">⏳ Belum
                                        Upload</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Status Seleksi -->
                    <div class="detail-card bg-white rounded-2xl p-8 border border-teal-200">
                        <h3 class="text-xl font-semibold text-[#0b6b66] mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                    clip-rule="evenodd" />
                            </svg>
                            Status Seleksi
                        </h3>
                        <p class="text-gray-600 mb-4">Status pendaftaran Anda saat ini:</p>

                        @php
                            $status = $registration->status ?? 'menunggu keputusan';
                        @endphp

                        @if ($status === 'diterima')
                            <div class="status-accepted px-6 py-4 rounded-xl text-center">
                                <div class="flex items-center justify-center space-x-2 mb-2">
                                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-xl font-bold">DITERIMA</span>
                                </div>
                                <p class="text-sm">Selamat! Anda diterima di SD Negeri Larangan</p>
                            </div>
                            <div class="mt-4 bg-green-50 border border-green-200 rounded-lg p-4">
                                <p class="text-sm text-green-800">
                                    <strong>Langkah Selanjutnya:</strong> Silakan lakukan daftar ulang sesuai jadwal
                                    yang telah ditentukan.
                                    Lihat detail di halaman <a href="{{ route('siswa.hasil') }}"
                                        class="underline font-semibold">Hasil Seleksi</a>.
                                </p>
                            </div>
                        @elseif($status === 'tidak diterima')
                            <div class="status-rejected px-6 py-4 rounded-xl text-center">
                                <div class="flex items-center justify-center space-x-2 mb-2">
                                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-xl font-bold">TIDAK DITERIMA</span>
                                </div>
                                <p class="text-sm">Mohon maaf, Anda belum berhasil dalam seleksi kali ini</p>
                            </div>
                            @if ($registration->notes)
                                <div class="mt-4 bg-red-50 border border-red-200 rounded-lg p-4">
                                    <p class="text-sm text-red-800">
                                        <strong>Catatan Admin:</strong> {{ $registration->notes }}
                                    </p>
                                </div>
                            @endif
                        @else
                            <div class="status-pending px-6 py-4 rounded-xl text-center">
                                <div class="flex items-center justify-center space-x-2 mb-2">
                                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-xl font-bold">MENUNGGU KEPUTUSAN</span>
                                </div>
                                <p class="text-sm">Pendaftaran Anda sedang dalam proses verifikasi</p>
                            </div>
                            <div class="mt-4 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <p class="text-sm text-yellow-800">
                                    <strong>Info:</strong> Data Anda sedang diverifikasi oleh admin. Mohon periksa
                                    halaman ini secara berkala untuk update status.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="detail-card bg-white rounded-2xl p-6 text-center sticky top-24">

                        <!-- FOTO PROFIL SISWA -->
                        @if ($registration && $registration->foto_profile_path)
                            <img src="{{ asset('storage/' . $registration->foto_profile_path) }}" alt="Foto Profil"
                                class="w-28 h-28 rounded-full object-cover mx-auto mb-4 shadow-lg border-4 border-teal-100">
                        @else
                            <div
                                class="w-28 h-28 rounded-full bg-teal-50 flex items-center justify-center mx-auto mb-4 text-gray-400">
                                <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7
                        9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        @endif

                        <!-- IDENTITAS SISWA -->
                        <h3 class="text-xl font-semibold text-gray-800 mb-1">
                            {{ $registration->nama ?? 'Calon Siswa' }}
                        </h3>
                        <p class="text-sm text-gray-500 mb-4">No.
                            SPSB{{ str_pad($registration->id, 6, '0', STR_PAD_LEFT) }}</p>

                        <!-- STATUS DOKUMEN -->
                        <div class="bg-teal-50 rounded-xl p-4 text-left mb-4">
                            <h4 class="font-semibold text-[#0b6b66] mb-3 text-sm">Kelengkapan Dokumen:</h4>
                            <div class="space-y-2 text-xs">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700">Kartu Keluarga</span>
                                    @if (!empty($registration->kartu_keluarga_path))
                                        <span class="text-green-600 font-medium">✓ Lengkap</span>
                                    @else
                                        <span class="text-yellow-600 font-medium">⏳ Belum</span>
                                    @endif
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700">Akta Kelahiran</span>
                                    @if (!empty($registration->akta_kelahiran_path))
                                        <span class="text-green-600 font-medium">✓ Lengkap</span>
                                    @else
                                        <span class="text-yellow-600 font-medium">⏳ Belum</span>
                                    @endif
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700">Foto 3x4</span>
                                    @if (!empty($registration->foto_3x4_path))
                                        <span class="text-green-600 font-medium">✓ Lengkap</span>
                                    @else
                                        <span class="text-yellow-600 font-medium">⏳ Belum</span>
                                    @endif
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700">Ijazah TK</span>
                                    @if (!empty($registration->ijazah_path))
                                        <span class="text-green-600 font-medium">✓ Ada</span>
                                    @else
                                        <span class="text-yellow-600 font-medium">⏳ Belum</span>
                                    @endif
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700">KTP Ortu</span>
                                    @if (!empty($registration->ktp_ortu_path))
                                        <span class="text-green-600 font-medium">✓ Ada</span>
                                    @else
                                        <span class="text-yellow-600 font-medium">⏳ Belum</span>
                                    @endif
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700">Kartu Bantuan</span>
                                    @if (!empty($registration->kartu_bantuan_path))
                                        <span class="text-green-600 font-medium">✓ Ada</span>
                                    @else
                                        <span class="text-gray-400 font-medium">- Opsional</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- CATATAN -->
                        <div class="bg-blue-50 rounded-xl p-4 text-left mb-4">
                            <h4 class="font-semibold text-blue-800 mb-2 text-sm">Catatan Penting:</h4>
                            <ul class="space-y-2 text-xs text-gray-700">
                                <li class="flex items-start"><span class="mr-2">✓</span><span>Pastikan dokumen jelas
                                        dan sesuai</span></li>
                                <li class="flex items-start"><span class="mr-2">✓</span><span>Tunggu hasil
                                        verifikasi dari admin</span></li>
                                <li class="flex items-start"><span class="mr-2">✓</span><span>Cek status secara
                                        berkala</span></li>
                            </ul>
                        </div>

                        <a href="{{ route('siswa.form') }}"
                            class="block bg-teal-600 hover:bg-teal-700 text-white px-6 py-3 rounded-lg font-medium transition mb-3">
                            Edit Data Pendaftaran
                        </a>
                        <a href="{{ route('siswa.dashboard') }}"
                            class="block bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-medium transition">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        @else
            <!-- Jika Belum Ada Data Pendaftaran -->
            <div class="max-w-2xl mx-auto">
                <div class="bg-white rounded-2xl p-8 border border-gray-200 text-center">
                    <svg class="w-20 h-20 mx-auto mb-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd" />
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Data Pendaftaran</h3>
                    <p class="text-gray-600 mb-6">Anda belum melakukan pendaftaran. Silakan isi formulir pendaftaran
                        terlebih dahulu.</p>
                    <a href="{{ route('siswa.form') }}"
                        class="inline-block bg-teal-600 hover:bg-teal-700 text-white px-8 py-3 rounded-lg font-semibold transition">
                        Isi Formulir Pendaftaran
                    </a>
                </div>
            </div>
        @endif
    </main>
</body>

</html>

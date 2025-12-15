<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - PPDB SD Negeri Larangan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-[#e0f2fe] to-[#f0fdfa] min-h-screen">

    <!-- Navbar -->
    <header class="bg-teal-600 text-white shadow-lg sticky top-0 z-40">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <!-- Logo + Nama -->
            <div class="flex items-center space-x-3">
                <img src="/asset/logo sipesar.png" alt="Logo SIPESAR" class="w-16 h-16 rounded-full bg-white p-0 shadow">
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
    <main class="container mx-auto px-6 pt-18 pb-12">
        <!-- Welcome Banner -->
        <section class="welcome-gradient rounded-2xl p-6 mb-8 border border-teal-200 text-center">
            <h2 class="text-2xl font-bold text-[#0b6b66] mb-2">Selamat Datang, {{ $formData['nama'] ?? $user->name }}
            </h2>
            <p class="text-[#0ea5a3]">Silakan lengkapi semua tahapan pendaftaran di bawah ini</p>
        </section>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Kiri -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Profil -->
                <div class="bg-white rounded-2xl p-6 border border-teal-100 card">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Profil Siswa</h3>
                    <p><b>Nama:</b> {{ $formData['nama'] ?? $user->name }}</p>
                    <p><b>NIK:</b> {{ $formData['nik'] ?? '-' }}</p>
                    <p><b>Tanggal Lahir:</b> {{ $formData['tanggal_lahir'] ?? '-' }}</p>
                    <a href="{{ route('siswa.detail') }}"
                        class="mt-3 inline-block text-[#0ea5a3] hover:text-[#0b6b66] font-medium text-sm">Lihat Detail
                        →</a>
                </div>

                <!-- Formulir -->
                <div class="bg-white rounded-2xl p-6 border border-teal-100 card">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Formulir Pendaftaran</h3>
                    <div class="flex items-center space-x-2 mb-3">
                        @if($progress >= 100)
                        <span class="text-white px-3 py-1 rounded-full text-xs font-medium bg-green-600">Lengkap</span>
                        @elseif($progress >= 50)
                        <span class="text-white px-3 py-1 rounded-full text-xs font-medium bg-yellow-600">Sebagian</span>
                        @else
                        <span class="text-white px-3 py-1 rounded-full text-xs font-medium bg-red-600">Belum Lengkap</span>
                        @endif
                        <span class="text-sm text-gray-600">{{ $progress }}% selesai</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mb-3">
                        <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $progress }}%"></div>
                    </div>
                    <a href="{{ route('siswa.form') }}"
                        class="text-yellow-600 hover:text-yellow-700 font-medium text-sm">Lanjutkan Pengisian →</a>
                </div>

                <!-- Upload Dokumen -->
                <div class="bg-white rounded-2xl p-6 border border-teal-100 card">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Upload Dokumen</h3>
                    <p class="text-xs text-gray-500 mb-4">Dokumen wajib: 5 file </p>

                    <div class="space-y-2">
                        <!-- Dokumen Wajib -->
                        <div class="flex items-center justify-between p-2 rounded-lg {{ $docStatus['kartu_keluarga_path'] ? 'bg-green-50' : 'bg-yellow-50' }}">
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-700">📄 Kartu Keluarga</span>
                                <span class="text-xs text-red-600 font-semibold">*Wajib</span>
                            </div>
                            @if($docStatus['kartu_keluarga_path'])
                            <a href="{{ route('siswa.document.view', 'kk') }}" target="_blank"
                                class="text-sm bg-green-500 text-white px-2 py-1 rounded-full">✓ Selesai</a>
                            @else
                            <span class="text-xs bg-yellow-500 text-white px-2 py-1 rounded-full">Belum</span>
                            @endif
                        </div>

                        <div class="flex items-center justify-between p-2 rounded-lg {{ $docStatus['akta_kelahiran_path'] ? 'bg-green-50' : 'bg-yellow-50' }}">
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-700">📄 Akta Kelahiran</span>
                                <span class="text-xs text-red-600 font-semibold">*Wajib</span>
                            </div>
                            @if($docStatus['akta_kelahiran_path'])
                            <a href="{{ route('siswa.document.view', 'akta') }}" target="_blank"
                                class="text-sm bg-green-500 text-white px-2 py-1 rounded-full">✓ Selesai</a>
                            @else
                            <span class="text-xs bg-yellow-500 text-white px-2 py-1 rounded-full">Belum</span>
                            @endif
                        </div>

                        <div class="flex items-center justify-between p-2 rounded-lg {{ $docStatus['foto_3x4_path'] ? 'bg-green-50' : 'bg-yellow-50' }}">
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-700">📷 Foto Siswa (3x4)</span>
                                <span class="text-xs text-red-600 font-semibold">*Wajib</span>
                            </div>
                            @if($docStatus['foto_3x4_path'])
                            <a href="{{ route('siswa.document.view', 'foto') }}" target="_blank"
                                class="text-sm bg-green-500 text-white px-2 py-1 rounded-full">✓ Selesai</a>
                            @else
                            <span class="text-xs bg-yellow-500 text-white px-2 py-1 rounded-full">Belum</span>
                            @endif
                        </div>

                        <div class="flex items-center justify-between p-2 rounded-lg {{ $docStatus['ijazah_path'] ? 'bg-green-50' : 'bg-yellow-50' }}">
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-700">📄 Ijazah TK</span>
                                <span class="text-xs text-red-600 font-semibold">*Wajib</span>
                            </div>
                            @if($docStatus['ijazah_path'])
                            <a href="{{ route('siswa.document.view', 'ijazah') }}" target="_blank"
                                class="text-sm bg-green-500 text-white px-2 py-1 rounded-full">✓ Selesai</a>
                            @else
                            <span class="text-xs bg-yellow-500 text-white px-2 py-1 rounded-full">Belum</span>
                            @endif
                        </div>

                        <div class="flex items-center justify-between p-2 rounded-lg {{ $docStatus['ktp_ortu_path'] ? 'bg-green-50' : 'bg-yellow-50' }}">
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-700">📄 KTP Orang Tua</span>
                                <span class="text-xs text-red-600 font-semibold">*Wajib</span>
                            </div>
                            @if($docStatus['ktp_ortu_path'])
                            <a href="{{ route('siswa.document.view', 'ktp_ortu') }}" target="_blank"
                                class="text-sm bg-green-500 text-white px-2 py-1 rounded-full">✓ Selesai</a>
                            @else
                            <span class="text-xs bg-yellow-500 text-white px-2 py-1 rounded-full">Belum</span>
                            @endif
                        </div>

                        <!-- Dokumen Opsional -->
                        <div class="border-t border-gray-200 my-3 pt-2">
                            <p class="text-xs text-gray-500 mb-2">Dokumen opsional :</p>
                        </div>

                        <div class="flex items-center justify-between p-2 rounded-lg {{ $docStatus['kartu_bantuan_path'] ? 'bg-green-50' : 'bg-gray-50' }}">
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-700">📄 Kartu Bantuan (KIP/PKH/KKS)</span>
                                <span class="text-xs text-blue-600 font-semibold">Opsional</span>
                            </div>
                            @if($docStatus['kartu_bantuan_path'])
                            <a href="{{ route('siswa.document.view', 'kartu_bantuan') }}" target="_blank"
                                class="text-sm bg-green-500 text-white px-2 py-1 rounded-full">✓ Ada</a>
                            @else
                            <span class="text-xs bg-gray-400 text-white px-2 py-1 rounded-full">-</span>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4">
                        <span class="text-sm text-gray-600">
                            Dokumen Wajib: <b>{{ $mandatoryDocsCount }}/5</b>
                            <span class="text-xs text-gray-500">({{ $docPercent }}%)</span>
                        </span>
                        <a href="{{ route('siswa.form') }}" class="mt-3 inline-block text-green-600 hover:text-green-700 font-medium text-sm">Kelola Dokumen →</a>
                    </div>
                </div>

                <!-- Pengumuman -->
                <div class="bg-white rounded-2xl p-6 border border-teal-100 card">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Pengumuman Hasil Seleksi</h3>
                    <div class="flex items-center space-x-2 mb-3">
                        <span class="text-white px-3 py-1 rounded-full text-xs font-medium bg-teal-600">Hasil Seleksi</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-3">Hasil seleksi akan diumumkan di halaman Pengumuman</p>
                    <a href="{{ route('siswa.hasil') }}" class="text-[#0ea5a3] hover:text-[#0b6b66] font-medium text-sm">Lihat
                        Pengumuman →</a>
                </div>
            </div>

            <!-- Kanan -->
            <div class="space-y-6">
                <!-- Ilustrasi -->
                <div class="bg-white rounded-2xl shadow-lg p-6 text-center card">
                    <img src="/asset/kartun anak sd.jpg" alt="Ilustrasi Siswa" class="w-36 mx-auto mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Semangat Belajar!</h3>
                    <p class="text-sm text-gray-600">Lengkapi semua tahapan pendaftaran untuk menjadi bagian dari
                        keluarga besar SD Negeri Larangan</p>
                </div>
                <!-- Progress -->
                <div class="bg-white rounded-2xl shadow-lg p-6 card">
                    <h4 class="font-semibold text-gray-800 mb-4">Progress Pendaftaran</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Formulir</span>
                            <span class="text-xs bg-yellow-500 text-white px-2 py-1 rounded-full">{{ $totalFields ? round(($filled/$totalFields)*100) : 0 }}%</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Dokumen Wajib</span>
                            <span class="text-xs {{ $docPercent >= 100 ? 'bg-green-500' : 'bg-yellow-500' }} text-white px-2 py-1 rounded-full">{{ $mandatoryDocsCount }}/5 ({{ $docPercent }}%)</span>
                        </div>
                        @if($optionalDocsCount > 0)
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Dokumen Opsional</span>
                            <span class="text-xs bg-blue-500 text-white px-2 py-1 rounded-full">✓ {{ $optionalDocsCount }}</span>
                        </div>
                        @endif
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="font-medium text-gray-800">Total Progress</span>
                            <span class="font-bold text-[#0ea5a3]">{{ $progress }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                            <div class="bg-[#0ea5a3] h-2 rounded-full" style="width: {{ $progress }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>

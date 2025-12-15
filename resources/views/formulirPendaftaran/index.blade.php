<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran - SIPESAR SD Negeri Larangan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .form-section {
            transition: all 0.3s ease;
        }

        .form-section:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .status-incomplete {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-teal-50 to-green-50 min-h-screen">
    <!-- Header -->
    <header class="bg-gradient-to-r from-teal-600 to-teal-700 shadow sticky top-0 z-40">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Logo + Nama -->
            <div class="flex items-center space-x-3">
                <img src="{{ asset('asset/logo sipesar.png') }}" alt="Logo SIPESAR"
                    class="w-12 h-12 rounded-full bg-white p-2 shadow">
                <div class="flex flex-col">
                    <span class="text-lg font-bold text-white">SD Negeri Larangan</span>
                    <span class="text-sm text-gray-200">Portal SIPESAR (Sistem Penerimaan Siswa Baru)</span>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="hidden md:flex items-center space-x-6 text-white font-medium">
                <a href="{{ route('dashboard') }}" class="hover:text-yellow-300">Dashboard</a>
                <a href="{{ route('formulirPendaftaran.index') }}" class="hover:text-yellow-300">Formulir
                    Pendaftaran</a>
                <a href="{{ route('detailSiswa') }}" class="hover:text-yellow-300">Detail Calon Siswa</a>
                <a href="{{ route('pengumuman') }}" class="hover:text-yellow-300">Pengumuman</a>
                <a href="{{ route('hasilSeleksi') }}">Hasil Seleksi</a>
                <a href="{{ route('login') }}" class="bg-red-500 px-4 py-2 rounded-lg hover:bg-red-600">Logout</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-8">
        <!-- Status Indicator -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-teal-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Status Pendaftaran</h3>
                        <div class="flex items-center space-x-2 mt-1">
                            <span class="status-incomplete text-white px-3 py-1 rounded-full text-sm font-medium">
                                Belum Lengkap
                            </span>
                            <span class="text-sm text-gray-600">75% selesai</span>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">Batas waktu pendaftaran:</p>
                    <p class="text-lg font-semibold text-red-600">30 Juni 2024</p>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Form Content -->
            <div class="lg:col-span-2">
                <form action="{{ route('formulirPendaftaran.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-8">
                    @csrf
                    <!-- Data Diri Siswa -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 form-section border border-teal-200">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Data Diri Siswa</h3>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" placeholder="Masukkan nama lengkap"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">NIK</label>
                                <input type="text" name="nik" placeholder="Masukkan NIK"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" placeholder="Masukkan tempat lahir"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                                <select name="jenis_kelamin"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                                    required>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Agama</label>
                                <select name="agama"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                                    required>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Konghucu">Konghucu</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                            <textarea name="alamat" rows="3" placeholder="Masukkan alamat lengkap"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" required></textarea>
                        </div>
                    </div>

                    <!-- Data Orang Tua -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 form-section border border-teal-200">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Data Orang Tua/Wali</h3>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Ayah</label>
                                <input type="text" name="nama_ayah" placeholder="Masukkan nama ayah"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Ibu</label>
                                <input type="text" name="nama_ibu" placeholder="Masukkan nama ibu"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan Orang Tua</label>
                                <input type="text" name="pekerjaan_orang_tua"
                                    placeholder="Masukkan pekerjaan orang tua"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor HP Orang Tua</label>
                                <input type="tel" name="no_hp_orang_tua" placeholder="08xxxxxxxxxx"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                                    required>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Dokumen -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 form-section border border-teal-200">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Upload Dokumen</h3>
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kartu Keluarga</label>
                                <input type="file" name="kk_file" class="w-full" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Akta Kelahiran</label>
                                <input type="file" name="akta_kelahiran_file" class="w-full" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Foto 3x4</label>
                                <input type="file" name="foto_3x4" class="w-full" required>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <!-- Tombol Aksi -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-teal-200">
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <!-- Tombol Simpan Perubahan (Submit) -->
                            <button type="submit" name="action" value="submit"
                                class="bg-teal-600 hover:bg-teal-700 text-white px-8 py-3 rounded-lg font-semibold text-lg transition-colors">
                                Simpan Perubahan
                            </button>

                            <!-- Tombol Simpan Draft -->
                            <button type="submit" name="action" value="draft"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold text-lg transition-colors">
                                Simpan Draft
                            </button>

                            <!-- Tombol Batalkan -->
                            <button type="reset"
                                class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-lg font-semibold text-lg transition-colors">
                                Batalkan
                            </button>
                        </div>
                    </div>


                    <!-- Sidebar -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-2xl shadow-lg p-6 text-center sticky top-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Lengkapi Data Anda!</h3>
                            <p class="text-sm text-gray-600 mb-4">Pastikan semua data sudah benar sebelum disimpan.</p>
                            <div class="bg-teal-50 rounded-lg p-4 text-left">
                                <h4 class="font-medium text-teal-800 mb-2">Checklist:</h4>
                                <ul class="list-disc ml-5 text-sm text-gray-700 space-y-1">
                                    <li>Data Diri Siswa</li>
                                    <li>Data Orang Tua</li>
                                    <li>Data Sekolah Asal</li>
                                    <li>Upload Dokumen</li>
                                </ul>
                            </div>
                        </div>
                    </div>
            </div>
    </main>

    <script>
        function toggleMobileMenu() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        }
    </script>
</body>

</html>

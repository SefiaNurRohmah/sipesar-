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
    <header class="bg-teal-600 text-white shadow-lg sticky top-0 z-40">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <!-- Logo + Nama -->
            <div class="flex items-center space-x-3">
                <img src="/asset/logo sipesar.png" alt="Logo SIPESAR"
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
        @if (session('status'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
        @endif

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Form Content -->
            <div class="lg:col-span-2">
                <form id="registrationForm" class="space-y-8" method="POST" action="{{ route('siswa.form.submit') }}"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- Data Diri Siswa -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 form-section border border-teal-200">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Data Diri Siswa</h3>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                <input name="nama" type="text" placeholder="Masukkan nama lengkap"
                                    value="{{ old('nama', $formData['nama'] ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">NIK</label>
                                <input name="nik" type="text" placeholder="Masukkan NIK"
                                    value="{{ old('nik', $formData['nik'] ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir</label>
                                <input name="tempat_lahir" type="text" placeholder="Masukkan tempat lahir"
                                    value="{{ old('tempat_lahir', $formData['tempat_lahir'] ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                                <input name="tanggal_lahir" type="date"
                                    value="{{ old('tanggal_lahir', $formData['tanggal_lahir'] ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                                <select name="jenis_kelamin"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                                    <option value="">Pilih</option>
                                    <option value="L"
                                        {{ old('jenis_kelamin', $formData['jenis_kelamin'] ?? '') === 'L' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="P"
                                        {{ old('jenis_kelamin', $formData['jenis_kelamin'] ?? '') === 'P' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Agama</label>
                                <select name="agama"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                                    <option value="">Pilih</option>
                                    @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                                        <option value="{{ $agama }}"
                                            {{ old('agama', $formData['agama'] ?? '') === $agama ? 'selected' : '' }}>
                                            {{ $agama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                            <textarea name="alamat" rows="3" placeholder="Masukkan alamat lengkap"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">{{ old('alamat', $formData['alamat'] ?? '') }}</textarea>
                        </div>
                    </div>

                    <!-- Data Orang Tua -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 form-section border border-teal-200">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Data Orang Tua/Wali</h3>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Ayah</label>
                                <input name="nama_ayah" type="text" placeholder="Masukkan nama ayah"
                                    value="{{ old('nama_ayah', $formData['nama_ayah'] ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Ibu</label>
                                <input name="nama_ibu" type="text" placeholder="Masukkan nama ibu"
                                    value="{{ old('nama_ibu', $formData['nama_ibu'] ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan Orang Tua</label>
                                <input name="pekerjaan_ortu" type="text" placeholder="Masukkan pekerjaan orang tua"
                                    value="{{ old('pekerjaan_ortu', $formData['pekerjaan_ortu'] ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor HP Orang Tua</label>
                                <input name="hp_ortu" type="tel" placeholder="08xxxxxxxxxx"
                                    value="{{ old('hp_ortu', $formData['hp_ortu'] ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                            </div>
                        </div>
                    </div>

                    <!-- Data Sekolah Asal -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 form-section border border-teal-200">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Data Sekolah Asal</h3>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama TK/PAUD</label>
                                <input name="nama_tk" type="text" placeholder="Masukkan nama TK/PAUD"
                                    value="{{ old('nama_tk', $formData['nama_tk'] ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Sekolah Asal</label>
                                <input name="alamat_tk" type="text" placeholder="Masukkan alamat sekolah asal"
                                    value="{{ old('alamat_tk', $formData['alamat_tk'] ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                            </div>
                        </div>
                    </div>

                    <!-- Upload Dokumen -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Kartu Keluarga <span class="text-xs text-gray-500">(PDF/JPG)</span>
                        </label>
                        <input name="kk" type="file" class="w-full" accept=".pdf,.jpg,.jpeg" required>
                        @error('kk')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Akta Kelahiran <span class="text-xs text-gray-500">(PDF/JPG)</span>
                        </label>
                        <input name="akta" type="file" class="w-full" accept=".pdf,.jpg,.jpeg" required>
                        @error('akta')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Foto 3x4 <span class="text-xs text-gray-500">(JPG)</span>
                        </label>
                        <input name="foto" type="file" class="w-full" accept=".jpg,.jpeg" required>
                        @error('foto')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Ijazah <span class="text-xs text-gray-500">(PDF/JPG)</span>
                        </label>
                        <input name="ijazah" type="file" class="w-full" accept=".pdf,.jpg,.jpeg">
                        @error('ijazah')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            KTP Orang Tua <span class="text-xs text-gray-500">(PDF/JPG)</span>
                        </label>
                        <input name="ktp_ortu" type="file" class="w-full" accept=".pdf,.jpg,.jpeg">
                        @error('ktp_ortu')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Kartu Bantuan <span class="text-xs text-gray-500">(PDF/JPG)</span>
                        </label>
                        <input name="kartu_bantuan" type="file" class="w-full" accept=".pdf,.jpg,.jpeg">
                        @error('kartu_bantuan')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    <!-- Tombol Aksi -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-teal-200">
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <button type="submit" name="action" value="save"
                                class="bg-teal-600 hover:bg-teal-700 text-white px-8 py-3 rounded-lg font-semibold text-lg transition-colors">
                                Simpan Perubahan
                            </button>
                            <button type="submit" name="action" value="draft"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold text-lg transition-colors">
                                Simpan Draft
                            </button>
                            <a href="{{ route('siswa.dashboard') }}"
                                class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-lg font-semibold text-lg transition-colors inline-flex items-center">
                                Batalkan
                            </a>
                        </div>
                    </div>
                </form>
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

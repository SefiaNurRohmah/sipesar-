<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Dokumen - SIPESAR</title>
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

        .photo-preview {
            width: 80px;
            height: 100px;
            background: linear-gradient(135deg, #ccfbf1, #99f6e4);
            border: 2px dashed #0d9488;
        }

        .file-icon {
            background: linear-gradient(135deg, #0ea5a3, #0b6b66);
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">

    <!-- Header -->
    @include('layouts.admin.header')

    <div class="flex pt-[80px]">

       @include('layouts.admin.sidebar')

        <!-- Main Content -->
        <main class="flex-1 ml-64 container mx-auto px-6 py-8">
            <!-- Success Message -->
            @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <!-- Error Messages -->
            @if($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg" role="alert">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Page Title -->
            <div class="mb-8 flex items-center space-x-3">
                <a href="{{ route('admin.data') }}" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-3xl font-bold text-gray-800">Detail Pendaftar & Verifikasi Dokumen</h2>
                    <p class="text-gray-600">Verifikasi kelengkapan dan keabsahan dokumen pendaftar</p>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Main Content Area -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Data Diri -->
                    <div class="detail-card bg-white rounded-2xl p-8 border border-teal-200">
                        <h3 class="text-xl font-semibold text-[#0b6b66] mb-4">Data Diri Pendaftar</h3>
                        <div class="grid md:grid-cols-2 gap-6">
                            <p><span class="text-gray-500">Nama Lengkap:</span>
                                <span class="font-semibold text-gray-800">{{ $registration->nama ?? '-' }}</span>
                            </p>
                            <p><span class="text-gray-500">ID Pendaftaran:</span>
                                <span class="font-semibold text-[#0ea5a3]">PPDB{{ str_pad($registration->id, 6, '0', STR_PAD_LEFT) }}</span>
                            </p>
                            <p><span class="text-gray-500">NIK:</span>
                                <span class="font-semibold text-gray-800">{{ $registration->nik ?? '-' }}</span>
                            </p>
                            <p><span class="text-gray-500">TTL:</span>
                                <span class="font-semibold text-gray-800">
                                    {{ $registration->tempat_lahir ?? '-' }},
                                    {{ $registration->tanggal_lahir ? \Carbon\Carbon::parse($registration->tanggal_lahir)->format('d F Y') : '-' }}
                                </span>
                            </p>
                            <p><span class="text-gray-500">Jenis Kelamin:</span>
                                <span class="font-semibold text-gray-800">{{ $registration->jenis_kelamin ?? '-' }}</span>
                            </p>
                            <p><span class="text-gray-500">Agama:</span>
                                <span class="font-semibold text-gray-800">{{ $registration->agama ?? '-' }}</span>
                            </p>
                            <p><span class="text-gray-500">Alamat:</span>
                                <span class="font-semibold text-gray-800">{{ $registration->alamat ?? '-' }}</span>
                            </p>
                            <p><span class="text-gray-500">Nama Ayah:</span>
                                <span class="font-semibold text-gray-800">{{ $registration->nama_ayah ?? '-' }}</span>
                            </p>
                            <p><span class="text-gray-500">Nama Ibu:</span>
                                <span class="font-semibold text-gray-800">{{ $registration->nama_ibu ?? '-' }}</span>
                            </p>
                            <p><span class="text-gray-500">Pekerjaan Orang Tua:</span>
                                <span class="font-semibold text-gray-800">{{ $registration->pekerjaan_ortu ?? '-' }}</span>
                            </p>
                            <p><span class="text-gray-500">No. HP Orang Tua:</span>
                                <span class="font-semibold text-gray-800">{{ $registration->hp_ortu ?? '-' }}</span>
                            </p>
                            <p><span class="text-gray-500">Asal TK:</span>
                                <span class="font-semibold text-gray-800">{{ $registration->nama_tk ?? '-' }}</span>
                            </p>
                        </div>
                    </div>

                    <!-- Dokumen -->
                    <div class="detail-card bg-white rounded-2xl p-8 border border-teal-200">
                        <h3 class="text-xl font-semibold text-[#0b6b66] mb-4">Dokumen Pendukung</h3>
                        <div class="space-y-4">
                            <!-- Kartu Keluarga -->
                            <div class="document-item border border-gray-200 rounded-xl p-4 flex justify-between items-center">
                                <div class="flex items-center space-x-3">
                                    <span>Kartu Keluarga</span>
                                    @if($registration->kartu_keluarga_path)
                                    <a href="{{ route('admin.detail.document', ['id' => $registration->id, 'type' => 'kk']) }}"
                                        target="_blank"
                                        class="text-teal-600 hover:text-teal-800 text-sm underline">
                                        Lihat Dokumen
                                    </a>
                                    @endif
                                </div>
                                @if($registration->kartu_keluarga_path)
                                <span class="status-valid px-3 py-1 rounded-full text-xs font-medium">✓ Valid</span>
                                @else
                                <span class="status-invalid px-3 py-1 rounded-full text-xs font-medium">✗ Belum Upload</span>
                                @endif
                            </div>

                            <!-- Akta Kelahiran -->
                            <div class="document-item border border-gray-200 rounded-xl p-4 flex justify-between items-center">
                                <div class="flex items-center space-x-3">
                                    <span>Akta Kelahiran</span>
                                    @if($registration->akta_kelahiran_path)
                                    <a href="{{ route('admin.detail.document', ['id' => $registration->id, 'type' => 'akta']) }}"
                                        target="_blank"
                                        class="text-teal-600 hover:text-teal-800 text-sm underline">
                                        Lihat Dokumen
                                    </a>
                                    @endif
                                </div>
                                @if($registration->akta_kelahiran_path)
                                <span class="status-valid px-3 py-1 rounded-full text-xs font-medium">✓ Valid</span>
                                @else
                                <span class="status-invalid px-3 py-1 rounded-full text-xs font-medium">✗ Belum Upload</span>
                                @endif
                            </div>

                            <!-- Foto 3x4 -->
                            <div class="document-item border border-gray-200 rounded-xl p-4 flex justify-between items-center">
                                <div class="flex items-center space-x-3">
                                    <span>Foto 3x4</span>
                                    @if($registration->foto_3x4_path)
                                    <a href="{{ route('admin.detail.document', ['id' => $registration->id, 'type' => 'foto']) }}"
                                        target="_blank"
                                        class="text-teal-600 hover:text-teal-800 text-sm underline">
                                        Lihat Dokumen
                                    </a>
                                    @endif
                                </div>
                                @if($registration->foto_3x4_path)
                                <span class="status-valid px-3 py-1 rounded-full text-xs font-medium">✓ Valid</span>
                                @else
                                <span class="status-invalid px-3 py-1 rounded-full text-xs font-medium">✗ Belum Upload</span>
                                @endif
                            </div>

                            <!-- Ijazah TK -->
                            <div class="document-item border border-gray-200 rounded-xl p-4 flex justify-between items-center">
                                <div class="flex items-center space-x-3">
                                    <span>Ijazah TK</span>
                                    @if($registration->ijazah_path)
                                    <a href="{{ route('admin.detail.document', ['id' => $registration->id, 'type' => 'ijazah']) }}"
                                        target="_blank"
                                        class="text-teal-600 hover:text-teal-800 text-sm underline">
                                        Lihat Dokumen
                                    </a>
                                    @endif
                                </div>
                                @if($registration->ijazah_path)
                                <span class="status-valid px-3 py-1 rounded-full text-xs font-medium">✓ Valid</span>
                                @else
                                <span class="status-invalid px-3 py-1 rounded-full text-xs font-medium">✗ Belum Upload</span>
                                @endif
                            </div>

                            <!-- KTP Orang Tua -->
                            <div class="document-item border border-gray-200 rounded-xl p-4 flex justify-between items-center">
                                <div class="flex items-center space-x-3">
                                    <span>KTP Orang Tua</span>
                                    @if($registration->ktp_ortu_path)
                                    <a href="{{ route('admin.detail.document', ['id' => $registration->id, 'type' => 'ktp_ortu']) }}"
                                        target="_blank"
                                        class="text-teal-600 hover:text-teal-800 text-sm underline">
                                        Lihat Dokumen
                                    </a>
                                    @endif
                                </div>
                                @if($registration->ktp_ortu_path)
                                <span class="status-valid px-3 py-1 rounded-full text-xs font-medium">✓ Valid</span>
                                @else
                                <span class="status-invalid px-3 py-1 rounded-full text-xs font-medium">✗ Belum Upload</span>
                                @endif
                            </div>

                            <!-- Kartu Bantuan (Opsional) -->
                            <div class="document-item border border-gray-200 rounded-xl p-4 flex justify-between items-center bg-blue-50">
                                <div class="flex items-center space-x-3">
                                    <span>Kartu Bantuan (KIP/PKH/KKS)</span>
                                    <span class="text-xs text-gray-500 italic">(Opsional)</span>
                                    @if($registration->kartu_bantuan_path)
                                    <a href="{{ route('admin.detail.document', ['id' => $registration->id, 'type' => 'kartu_bantuan']) }}"
                                        target="_blank"
                                        class="text-teal-600 hover:text-teal-800 text-sm underline">
                                        Lihat Dokumen
                                    </a>
                                    @endif
                                </div>
                                @if($registration->kartu_bantuan_path)
                                <span class="status-valid px-3 py-1 rounded-full text-xs font-medium">✓ Ada</span>
                                @else
                                <span class="bg-gray-200 text-gray-600 px-3 py-1 rounded-full text-xs font-medium">- Tidak Ada</span>
                                @endif
                            </div>
                        </div>
                        </div>
                    </div>

                    <!-- Aksi Admin -->
                    <div class="detail-card bg-white rounded-2xl p-8 border border-teal-200">
                        <h3 class="text-xl font-semibold text-[#0b6b66] mb-4">Aksi Verifikasi Admin</h3>
                        <form action="{{ route('admin.verify.update', $registration->id) }}" method="POST" class="space-y-6">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status Seleksi</label>
                                <select name="status"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                                    <option value="menunggu keputusan" {{ ($registration->status ?? 'menunggu keputusan') == 'menunggu keputusan' ? 'selected' : '' }}>
                                        Menunggu Keputusan
                                    </option>
                                    <option value="diterima" {{ ($registration->status ?? '') == 'diterima' ? 'selected' : '' }}>
                                        Diterima
                                    </option>
                                    <option value="tidak diterima" {{ ($registration->status ?? '') == 'tidak diterima' ? 'selected' : '' }}>
                                        Tidak Diterima
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Admin</label>
                                <textarea name="notes"
                                    rows="4"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                                    placeholder="Tambahkan catatan jika diperlukan...">{{ old('notes', $registration->notes ?? '') }}</textarea>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-4">
                                <button type="submit"
                                    class="bg-gradient-to-r from-[#0ea5a3] to-[#0b6b66] text-white px-6 py-3 rounded-lg font-medium hover:opacity-90">
                                    Simpan Verifikasi
                                </button>
                                <a href="{{ route('admin.data') }}"
                                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 rounded-lg font-medium text-center">
                                    Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="detail-card bg-white rounded-2xl p-6 text-center sticky top-24">
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Verifikasi Dokumen</h3>
                        <p class="text-gray-600 mb-4">Periksa dengan teliti setiap dokumen yang diupload oleh
                            pendaftar.</p>
                        <div class="bg-teal-50 rounded-xl p-4 text-left">
                            <h4 class="font-semibold text-[#0b6b66] mb-2">Tips Verifikasi:</h4>
                            <ul class="space-y-2 text-sm text-gray-700">
                                <li>✓ Pastikan foto jelas</li>
                                <li>✓ Cek kesesuaian data</li>
                                <li>✓ Verifikasi tanggal & tanda tangan</li>
                            </ul>
                        </div>

                        <!-- Status Saat Ini -->
                        <div class="mt-6 p-4 bg-gray-50 rounded-xl">
                            <h4 class="font-semibold text-gray-800 mb-2">Status Saat Ini:</h4>
                            @if(($registration->status ?? 'waiting') == 'waiting')
                            <span class="status-pending px-4 py-2 rounded-full text-sm font-medium inline-block">
                                ⏳ Menunggu Keputusan
                            </span>
                            @elseif($registration->status == 'accepted')
                            <span class="status-valid px-4 py-2 rounded-full text-sm font-medium inline-block">
                                ✓ Diterima
                            </span>
                            @elseif($registration->status == 'rejected')
                            <span class="status-invalid px-4 py-2 rounded-full text-sm font-medium inline-block">
                                ✗ Tidak Diterima
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>

</html>

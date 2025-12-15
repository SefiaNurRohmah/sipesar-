<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Seleksi - SIPESAR</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .status-accepted {
            background: linear-gradient(135deg, #0ea5a3, #0b766a);
            animation: pulse 2s infinite;
        }

        .status-rejected {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }

        .status-pending {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .result-card {
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .result-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        @media print {
            body {
                background: white;
            }

            header,
            nav,
            button,
            .no-print {
                display: none !important;
            }

            .print-area {
                margin-top: 0 !important;
                padding: 0 !important;
            }
        }
    </style>
</head>

<body class="bg-gradient-to-br from-teal-50 to-green-50 min-h-screen">

    <!-- Header/Navbar -->
    <header class="bg-teal-600 text-white shadow-lg sticky top-0 z-40 no-print">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('asset/logo sipesar.png') }}" alt="Logo SIPESAR"
                    class="w-16 h-16 rounded-full bg-white p-0 shadow">
                <div class="flex flex-col">
                    <span class="text-lg font-bold text-white">SD Negeri Larangan</span>
                    <span class="text-sm text-gray-200">Portal SIPESAR (Sistem Penerimaan Siswa Baru)</span>
                </div>
            </div>
            <nav class="hidden md:flex items-center space-x-6 text-white font-medium">
                <a href="{{ route('siswa.dashboard') }}" class="hover:text-yellow-300">Dashboard</a>
                <a href="{{ route('siswa.form') }}" class="hover:text-yellow-300">Formulir Pendaftaran</a>
                <a href="{{ route('siswa.detail') }}" class="hover:text-yellow-300">Detail Calon Siswa</a>
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
    <main class="container mx-auto px-6 py-12">

        <div class="text-center mb-12 no-print">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Pengumuman Hasil Seleksi</h1>
            <p class="text-lg text-gray-600">Tahun Ajaran 2026/2027</p>
            <p class="text-md text-gray-500 mt-2">SD Negeri Larangan</p>
        </div>

        <!-- Area untuk dicetak -->
        <div id="printArea" class="print-area bg-white rounded-3xl p-8 border border-teal-100 max-w-4xl mx-auto">
            <!-- Info Siswa -->
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $name }}</h2>
                <p class="text-lg text-gray-600">Nomor Pendaftaran:
                    <span class="font-semibold text-teal-600">{{ $regNo }}</span>
                </p>
                @if ($registration && $registration->nik)
                    <p class="text-md text-gray-500 mt-1">NIK: {{ $registration->nik }}</p>
                @endif
            </div>

            <!-- Status Seleksi -->
            <div class="text-center mb-10">
                <div class="{{ $statusClass }} text-white rounded-2xl p-8">
                    <h3 class="text-3xl font-bold mb-2">{{ $statusText }}</h3>
                    <p class="text-lg opacity-90">{{ $statusDesc }}</p>
                </div>
            </div>

            <!-- Detail Calon Siswa -->
            @if ($registration)
                <div class="border-t border-gray-300 pt-6 mt-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Detail Calon Siswa</h3>
                    <table class="w-full border border-gray-200 rounded-lg text-sm">
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td class="p-3 font-medium w-1/3">Nama Lengkap</td>
                                <td class="p-3">{{ $registration->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="p-3 font-medium">NIK</td>
                                <td class="p-3">{{ $registration->nik ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="p-3 font-medium">Tempat, Tanggal Lahir</td>
                                <td class="p-3">
                                    {{ $registration->tempat_lahir ?? '-' }},
                                    {{ $registration->tanggal_lahir ? \Carbon\Carbon::parse($registration->tanggal_lahir)->locale('id')->isoFormat('D MMMM YYYY') : '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="p-3 font-medium">Jenis Kelamin</td>
                                <td class="p-3">
                                    {{ $registration->jenis_kelamin === 'L' ? 'Laki-laki' : ($registration->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="p-3 font-medium">Agama</td>
                                <td class="p-3">{{ $registration->agama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="p-3 font-medium">Alamat Lengkap</td>
                                <td class="p-3">{{ $registration->alamat ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="p-3 font-medium">Nama Ayah</td>
                                <td class="p-3">{{ $registration->nama_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="p-3 font-medium">Nama Ibu</td>
                                <td class="p-3">{{ $registration->nama_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="p-3 font-medium">Pekerjaan Orang Tua</td>
                                <td class="p-3">{{ $registration->pekerjaan_ortu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="p-3 font-medium">Nomor HP Orang Tua</td>
                                <td class="p-3">{{ $registration->hp_ortu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="p-3 font-medium">Sekolah Asal</td>
                                <td class="p-3">{{ $registration->nama_tk ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Tombol Aksi -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8 no-print">
            @if ($statusKey === 'diterima')
                <button onclick="printSection()"
                    class="bg-teal-600 hover:bg-teal-700 text-white px-8 py-3 rounded-xl font-semibold text-lg transition-all">
                    📄 Cetak Bukti Penerimaan
                </button>
            @endif
            <a href="{{ route('siswa.dashboard') }}"
                class="bg-gray-600 hover:bg-gray-700 text-white px-8 py-3 rounded-xl font-semibold text-lg transition-all text-center">
                ← Kembali ke Dashboard
            </a>
        </div>

    </main>

    <script>
        function printSection() {
            const printContent = document.getElementById('printArea').innerHTML;
            const originalContent = document.body.innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;
            window.location.reload(); // refresh untuk mengembalikan tampilan normal
        }
    </script>

</body>

</html>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman - SIPESAR</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .nav-link {
            @apply px-4 py-2 rounded-lg font-medium transition;
        }

        .nav-link:hover {
            @apply bg-teal-700 text-white;
        }

        .announcement-card {
            transition: all 0.3s ease;
        }

        .announcement-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">

    <!-- Header/Navbar -->
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
    <main class="container mx-auto px-6 py-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">📢 Pengumuman Terbaru</h2>

        @if($pengumuman->count() > 0)
        <!-- Pengumuman Aktif -->
        <div class="grid md:grid-cols-2 gap-6">
            @foreach($pengumuman as $item)
            <!-- Card Pengumuman -->
            <div class="announcement-card bg-white p-6 rounded-2xl shadow border-l-4 border-teal-500">
                <h3 class="text-xl font-semibold text-gray-800">{{ $item->title }}</h3>
                <p class="text-sm text-gray-500 mt-1">{{ \Carbon\Carbon::parse($item->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</p>
                <p class="text-gray-700 mt-3">
                    {{ $item->content }}
                </p>
            </div>
            @endforeach
        </div>
        @else
        <!-- Jika tidak ada pengumuman -->
        <div class="bg-white p-8 rounded-2xl shadow text-center">
            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum Ada Pengumuman</h3>
            <p class="text-gray-600">Saat ini belum ada pengumuman terbaru. Silakan cek kembali nanti.</p>
        </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-gray-100 text-center py-4 mt-10 text-sm text-gray-600">
        &copy; 2026 SIPESAR - Sistem Penerimaan Siswa Baru
    </footer>

</body>

</html>

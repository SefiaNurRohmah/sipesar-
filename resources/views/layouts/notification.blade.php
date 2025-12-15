<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Notifikasi - SIPESAR')</title>

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-50 min-h-screen">

    {{-- Header (assuming navbar.blade.php is the main header) --}}
    <header class="bg-teal-600 text-white shadow-lg fixed top-0 left-0 w-full z-50">
        <div class="px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('asset/logo sipesar.png') }}" class="w-12 h-12 rounded-full bg-white p-2 shadow">
                <div>
                    <h1 class="font-bold text-lg">SD Negeri Larangan</h1>
                    <p class="text-sm text-gray-200">Sistem Informasi Pendaftaran Siswa Baru</p>
                </div>
            </div>

            @include('partials.navbar') {{-- Include the main navbar with notification dropdown --}}
        </div>
    </header>


    {{-- MAIN CONTENT AREA --}}
    <main class="flex-1 p-6 pt-24"> {{-- pt-24 to account for fixed header --}}
        @yield('content')
    </main>

    @stack('scripts')
</body>

</html>

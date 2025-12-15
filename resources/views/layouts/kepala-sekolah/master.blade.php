<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Kepala Sekolah - SIPESAR')</title>

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Flatpickr --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .sidebar {
            transition: transform 0.3s ease;
        }

        .sidebar-hidden {
            transform: translateX(-100%);
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-50 min-h-screen">

    {{-- Header --}}
    @include('layouts.kepala-sekolah.header')

    <div class="flex">

        {{-- Sidebar --}}
        @include('layouts.kepala-sekolah.sidebar')

        {{-- MAIN CONTENT AREA --}}
        <main class="flex-1 ml-64 p-6 @yield('page-padding', 'pt-6')">
            @yield('content')
        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    {{-- Sidebar Mobile Toggle --}}
    <script>
        const sidebar = document.getElementById("sidebar");

        const toggleButton = document.createElement("button");
        toggleButton.className =
            "lg:hidden fixed bottom-4 left-4 z-50 bg-teal-600 text-white p-3 rounded-full shadow-lg hover:bg-teal-700 transition";

        toggleButton.innerHTML = `
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                clip-rule="evenodd" />
        </svg>
        `;

        toggleButton.addEventListener("click", () => {
            sidebar.classList.toggle("sidebar-hidden");
        });

        document.body.appendChild(toggleButton);
    </script>

    @stack('scripts')
</body>

</html>

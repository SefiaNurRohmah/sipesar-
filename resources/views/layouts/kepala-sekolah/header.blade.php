<header class="bg-teal-600 text-white shadow-lg fixed top-0 left-0 w-full z-50">
    <div class="px-6 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <img src="{{ asset('asset/logo sipesar.png') }}" class="w-12 h-12 rounded-full bg-white p-2 shadow">
            <div>
                <h1 class="font-bold text-lg">SD Negeri Larangan</h1>
                <p class="text-sm text-gray-200">Portal Kepala Sekolah</p>
            </div>
        </div>

        <div class="hidden md:flex items-center space-x-3">
            @include('partials.notification-dropdown')
            <div class="text-right">
                <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-200">{{ auth()->user()->email }}</p>
            </div>
            <div class="w-10 h-10 bg-teal-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                </svg>
            </div>
        </div>
    </div>
</header>

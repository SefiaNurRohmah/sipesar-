<aside id="sidebar"
    class="w-64 bg-white shadow-md fixed top-0 left-0 h-full pt-24 z-40 transform sidebar-hidden lg:transform-none">
    <div class="p-4">
        <h2 class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-4">Menu Utama</h2>
        <nav class="space-y-2">
            <a href="{{ route('kepala-sekolah.dashboard') }}"
                class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-teal-50 transition {{ request()->routeIs('kepala-sekolah.dashboard') ? 'bg-teal-100 text-teal-800 font-bold' : '' }}">
                <svg class="w-6 h-6 mr-3 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                    </path>
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('kepala-sekolah.calon-siswa') }}"
                class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-teal-50 transition {{ request()->routeIs('kepala-sekolah.calon-siswa*') ? 'bg-teal-100 text-teal-800 font-bold' : '' }}">
                <svg class="w-6 h-6 mr-3 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.653-.124-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.653.124-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
                <span>Data Calon Siswa</span>
            </a>

            <a href="{{ route('kepala-sekolah.hasil-verifikasi') }}"
                class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-teal-50 transition {{ request()->routeIs('kepala-sekolah.hasil-verifikasi') ? 'bg-teal-100 text-teal-800 font-bold' : '' }}">
                <svg class="w-6 h-6 mr-3 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Hasil Verifikasi</span>
            </a>

            <a href="{{ route('kepala-sekolah.laporan') }}"
                class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-teal-50 transition {{ request()->routeIs('kepala-sekolah.laporan*') ? 'bg-teal-100 text-teal-800 font-bold' : '' }}">
                <svg class="w-6 h-6 mr-3 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                <span>Laporan</span>
            </a>
        </nav>

        <div class="absolute bottom-0 left-0 w-full p-4 border-t border-gray-200">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full flex items-center p-3 text-red-600 rounded-lg hover:bg-red-50 transition">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>

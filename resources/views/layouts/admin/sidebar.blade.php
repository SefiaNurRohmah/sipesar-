<aside id="sidebar"
    class="fixed top-[80px] left-0 w-64 h-[calc(100vh-80px)] bg-white border-r shadow overflow-y-auto">
    <div class="p-6">
        <nav class="space-y-2">
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center space-x-3 px-4 py-3 rounded-lg font-medium text-gray-600 bg-white
                hover:bg-green-600 hover:text-white transition-colors active-link">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.data') }}"
                class="flex items-center space-x-3 text-gray-600 hover:bg-green-600 hover:text-white px-4 py-3 rounded-lg font-medium transition-colors">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z" />
                </svg>
                <span>Data Calon Siswa</span>
            </a>

            <a href="{{ route('admin.announcements') }}"
                class="flex items-center space-x-3 text-gray-600 hover:bg-green-600 hover:text-white px-4 py-3 rounded-lg font-medium transition-colors">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z"
                        clip-rule="evenodd" />
                </svg>
                <span>Kelola Pengumuman</span>
            </a>

            <a href="{{ route('admin.activity-logs') }}"
                class="flex items-center space-x-3 text-gray-600 hover:bg-green-600 hover:text-white px-4 py-3 rounded-lg font-medium transition-colors">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 2a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V4a2 2 0 00-2-2H4zm5.293 10.293a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 13.414V16a1 1 0 11-2 0v-2.586l-1.293 1.293a1 1 0 01-1.414-1.414l3-3zM8 7a1 1 0 012 0v2.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 111.414-1.414L8 9.586V7z" clip-rule="evenodd" />
                </svg>
                <span>Riwayat Aktivitas</span>
            </a>

            <a href="{{ route('admin.reports') }}"
                class="flex items-center space-x-3 text-gray-600 hover:bg-green-600 hover:text-white px-4 py-3 rounded-lg font-medium transition-colors">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Laporan</span>
            </a>

            <!-- Tombol Logout -->
            <form method="POST" action="{{ route('logout') }}" class="pt-2">
                @csrf
                <button type="submit"
                    class="w-full flex items-center space-x-3 text-gray-600 hover:bg-red-600 hover:text-white px-4 py-3 rounded-lg font-medium transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </nav>
    </div>
</aside>

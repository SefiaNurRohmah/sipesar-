<nav class="hidden md:flex items-center space-x-6 text-white font-medium">
    @auth
    @php $role = auth()->user()->role ?? 'siswa'; @endphp

    @if($role === 'siswa')
    <a href="{{ route('siswa.dashboard') }}" class="hover:text-yellow-300">Dashboard</a>
    <a href="{{ route('siswa.form') }}" class="hover:text-yellow-300">Formulir Pendaftaran</a>
    <a href="{{ route('siswa.detail') }}" class="hover:text-yellow-300">Detail Calon Siswa</a>
    <a href="{{ route('siswa.pengumuman') }}" class="hover:text-yellow-300">Pengumuman</a>
    <a href="{{ route('siswa.hasil') }}" class="hover:text-yellow-300">Hasil Seleksi</a>
    @elseif($role === 'admin')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-yellow-300">Dashboard Admin</a>
    <a href="{{ route('admin.dashboard') }}" class="hover:text-yellow-300">Kelola</a>
    @elseif($role === 'kepala_sekolah')
    <a href="{{ route('kepala-sekolah.dashboard') }}" class="hover:text-yellow-300">Dashboard Kepsek</a>
    @else
    <a href="{{ route('siswa.dashboard') }}" class="hover:text-yellow-300">Dashboard</a>
    @endif

    <form method="POST" action="{{ route('logout') }}" class="inline">
        @csrf
        <button type="submit" class="bg-red-500 px-4 py-2 rounded-lg hover:bg-red-600">Logout</button>
    </form>
    @else
    <a href="{{ route('welcome') }}" class="hover:text-yellow-300">Home</a>
    <a href="{{ route('login') }}" class="hover:text-yellow-300">Login</a>
    <a href="{{ route('register') }}" class="hover:text-yellow-300">Register</a>
    @endauth
</nav>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>SIPESAR - SD Negeri Larangan</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg: #f6fbff;
            --blue: #0ea5a3;
            --blue-dark: #0b6b66;
            --light-blue: #e6fbfb;
            --green: #13b58b;
            --muted: #6b7280;
            --card-shadow: 0 8px 24px rgba(7, 22, 31, 0.06);
            --radius: 14px;
            --max-width: 1100px;
            --gap: 24px;
            font-family: 'Poppins', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        }

        * {
            box-sizing: border-box
        }

        html,
        body {
            height: 100%
        }

        body {
            margin: 0;
            background: var(--bg);
            color: #0f172a;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            line-height: 1.5;
            font-size: 16px;
        }

        .wrap {
            max-width: var(--max-width);
            margin: 0 auto;
            padding: 0 20px;
        }

        header {
            background: rgba(255, 255, 255, 0.95);
            position: sticky;
            top: 0;
            z-index: 60;
            box-shadow: 0 4px 18px rgba(15, 23, 42, 0.06);
            backdrop-filter: blur(8px);
        }

        .nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 14px 20px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px
        }

        .brand h1 {
            margin: 0;
            font-size: 18px;
            color: var(--blue-dark);
            font-weight: 700
        }

        nav ul {
            display: flex;
            gap: 16px;
            list-style: none;
            margin: 0;
            padding: 0;
            align-items: center
        }

        nav a {
            color: var(--muted);
            text-decoration: none;
            font-weight: 600
        }

        .btn-login {
            background: linear-gradient(90deg, var(--green), var(--blue));
            color: white;
            padding: 10px 16px;
            border-radius: 999px;
            border: 0;
            font-weight: 600;
            box-shadow: 0 8px 20px rgba(6, 100, 88, 0.12);
            cursor: pointer;
        }

        .hero {
            background-image: url("{{ asset('asset/sd larangan.jpg') }}");
            background-size: cover;
            background-position: center;
            border-radius: 8px;
            margin: 18px auto 32px;
            padding: 80px 20px;
            /* dulu 64px, sekarang lebih besar */
            min-height: 85vh;
            /* tambahan: tinggi minimum 85% tinggi layar */
            color: white;
            position: relative;
            overflow: hidden;
        }

        .hero:before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(4, 30, 40, 0.45), rgba(6, 25, 35, 0.45));
            mix-blend-mode: multiply;
            border-radius: 8px;
        }

        .hero .wrap {
            position: relative;
            z-index: 2;
            display: flex;
            gap: 24px;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap
        }

        .hero-left {
            max-width: 640px;
            margin-top: 120px;
            /* <<< geser teks ke bawah */
        }

        .eyebadge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.12);
            padding: 6px 12px;
            border-radius: 999px;
            font-weight: 600;
            margin-bottom: 18px
        }

        .hero h2 {
            font-size: 36px;
            margin: 0 0 12px;
            line-height: 1.05
        }

        .hero p {
            margin: 0 0 18px;
            color: rgba(255, 255, 255, 0.95)
        }

        .cta-row {
            display: flex;
            gap: 12px;
            flex-wrap: wrap
        }

        .btn-primary {
            background: var(--green);
            color: white;
            padding: 12px 18px;
            border-radius: 12px;
            border: 0;
            font-weight: 700;
            cursor: pointer
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.12);
            color: white;
            padding: 12px 18px;
            border-radius: 12px;
            border: 0
        }

        .hero-illus {
            width: 320px;
            max-width: 40%;
            min-width: 260px;
            opacity: 0.98
        }

        section {
            padding: 44px 0
        }

        .section-title {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            margin-bottom: 18px
        }

        .section-title h3 {
            margin: 0;
            font-size: 28px
        }

        .section-title p {
            margin: 0;
            color: var(--muted);
            max-width: 720px;
            text-align: center
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: var(--gap);
            margin-top: 18px
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: var(--card-shadow);
            min-height: 170px;
            display: flex;
            flex-direction: column;
            gap: 12px
        }

        .card .icon {
            width: 52px;
            height: 52px;
            border-radius: 10px;
            background: linear-gradient(135deg, #cfeff5, #dff9ef);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: var(--blue-dark)
        }

        .card h4 {
            margin: 0;
            font-size: 18px
        }

        .card p {
            margin: 0;
            color: var(--muted);
            font-size: 14px
        }

        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: var(--gap);
            align-items: start
        }

        .big-card {
            background: linear-gradient(180deg, #f2f9fb, #f9fffc);
            border-radius: 16px;
            padding: 22px;
            box-shadow: var(--card-shadow)
        }

        .list-check {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 12px
        }

        .list-item {
            display: flex;
            gap: 12px;
            align-items: flex-start
        }

        .badge {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: var(--blue);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700
        }

        .doc-badge {
            background: var(--green)
        }

        .steps {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-top: 18px
        }

        .step {
            background: white;
            padding: 18px;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            text-align: center
        }

        .step .round {
            width: 72px;
            height: 72px;
            border-radius: 18px;
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            background: linear-gradient(90deg, var(--blue), var(--green));
            color: white
        }

        .contact-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-top: 18px
        }

        .contact-card {
            background: linear-gradient(180deg, #e8fbf5, #eefefd);
            padding: 18px;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            text-align: center
        }

        .contact-card h4 {
            margin-top: 8px;
            margin-bottom: 6px
        }

        .contact-card p {
            margin: 0;
            color: var(--muted);
            font-size: 14px
        }

        .contact-btn {
            margin-top: 12px;
            display: inline-block;
            padding: 10px 14px;
            border-radius: 10px;
            background: var(--green);
            color: white;
            text-decoration: none;
            font-weight: 600
        }

        footer {
            background: #071128;
            color: #dbeafe;
            padding: 34px 0;
            margin-top: 28px
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 18px
        }

        .footer-grid h5 {
            color: #fff;
            margin-bottom: 10px
        }

        .socials {
            display: flex;
            gap: 10px;
            margin-top: 10px
        }

        .socials a {
            display: inline-block;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #0b2b2f;
            color: white;
            text-align: center;
            line-height: 36px;
            text-decoration: none
        }

        @media (max-width:980px) {
            .cards {
                grid-template-columns: 1fr 1fr
            }

            .two-col {
                grid-template-columns: 1fr
            }

            .steps {
                grid-template-columns: repeat(2, 1fr)
            }

            .contact-grid {
                grid-template-columns: 1fr
            }

            .hero-left {
                max-width: 100%
            }

            .hero-illus {
                display: none
            }
        }

        @media (max-width:560px) {
            .nav {
                padding: 10px 12px
            }

            nav ul {
                display: none
            }

            .hero {
                padding: 36px 16px
            }

            .hero h2 {
                font-size: 26px
            }

            .cards {
                grid-template-columns: 1fr
            }

            .steps {
                grid-template-columns: 1fr
            }

            .wrap {
                padding: 0 14px
            }

            /* tambahkan ini */
            .hero-left {
                margin-top: 60px;
                /* di layar kecil turunnya lebih sedikit */
            }
        }


        /* === ENHANCEMENT UI === */
        * {
            transition: all 0.3s ease;
        }

        nav a:hover {
            color: var(--blue);
            transform: translateY(-2px);
        }

        .btn-login:hover,
        .btn-primary:hover,
        .btn-secondary:hover,
        .contact-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(6, 100, 88, 0.25);
        }

        .hero-left h2,
        .hero-left p,
        .cta-row {
            animation: fadeUp 1s ease forwards;
            opacity: 0;
        }

        .hero-left h2 {
            animation-delay: 0.2s;
        }

        .hero-left p {
            animation-delay: 0.4s;
        }

        .cta-row {
            animation-delay: 0.6s;
        }

        @keyframes fadeUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .card:hover,
        .step:hover,
        .contact-card:hover {
            transform: translateY(-6px) scale(1.02);
            box-shadow: 0 10px 26px rgba(7, 22, 31, 0.12);
        }

        .card .icon {
            animation: pulse 2.5s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.08);
                opacity: 0.9;
            }
        }

        .hero:before {
            animation: gradientMove 6s ease-in-out infinite alternate;
        }

        @keyframes gradientMove {
            from {
                opacity: 0.45;
            }

            to {
                opacity: 0.65;
            }
        }

        .section-title h3 {
            position: relative;
        }

        .section-title h3::after {
            content: '';
            display: block;
            width: 60px;
            height: 3px;
            background: var(--green);
            margin: 10px auto 0;
            border-radius: 3px;
            opacity: 0;
            transform: scaleX(0);
            transition: all 0.4s ease;
        }

        .section-title:hover h3::after {
            opacity: 1;
            transform: scaleX(1);
        }

        .socials a:hover {
            background: var(--blue);
            transform: rotate(10deg);
        }

        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .reveal.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <header>
        <div class="wrap nav">
            <div class="brand">
                <img src="{{ asset('asset/logo sipesar.png') }}" alt="Logo SD Negeri Larangan"
                    style="height:48px;width:48px;border-radius:8px;object-fit:cover;">
                <div>
                    <h1>SD Negeri Larangan</h1>
                    <div style="font-size:12px;color:var(--muted)">Portal SIPESAR (Sistem Penerimaan Siswa Baru)</div>
                </div>
            </div>

            <nav>
                <ul>
                    <li><a href="#home">Beranda</a></li>
                    <li><a href="#about">Tentang</a></li>
                    <li><a href="#syarat">Syarat</a></li>
                    <li><a href="#alur">Alur</a></li>
                    <li><a href="#kontak">Kontak</a></li>
                </ul>
            </nav>

            <div>
                <a href="{{ route('login') }}" class="btn-login">Login</a>
            </div>
        </div>
    </header>

    <!-- HERO -->
    <!-- onclick & input file DIHAPUS, karena background sudah statis -->
    <section class="hero" id="home" aria-label="Hero">
        <div class="wrap">
            <div class="hero-left">
                <span class="eyebadge">PERSYARATAN TERSEDIA</span>
                <h2>Pendaftaran Siswa Baru <br> SD Negeri Larangan</h2>
                <p>Daftarkan putra-putri Anda dengan mudah melalui portal resmi SIPESAR. Isi formulir, unggah dokumen,
                    dan pantau status pendaftaran secara online.</p>

                <div class="cta-row">
                    <a href="{{ route('register') }}" class="btn-primary" style="text-decoration: none;">Daftar
                        Sekarang</a>
                    <button class="btn-secondary" onclick="location.href='#alur'">Cara Mendaftar</button>
                </div>
            </div>

            <div class="hero-illus">
                {{-- Jika mau, bisa tambah ilustrasi di kanan --}}
                {{-- <img src="{{ asset('asset/illus-spsb.png') }}" alt="Ilustrasi SPSB" style="width:100%;border-radius:16px;"> --}}
            </div>
        </div>
    </section>

    <!-- PENGUMUMAN TERBARU -->
    <section class="wrap">
        <div class="section-title">
            <h3>Pengumuman Terbaru</h3>
            <p>Informasi dan pengumuman penting terkait SPSB yang perlu Anda perhatikan.</p>
        </div>

        <div class="cards">
            @if(isset($announcements) && $announcements->count() > 0)
                @foreach($announcements as $announce)
                    <article class="card">
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:12px;">
                            <div style="flex:1;">
                                <h4 style="margin-bottom:6px">{{ $announce->title }}</h4>
                                <p style="color:var(--muted);font-size:13px;margin-bottom:12px">{{ \Illuminate\Support\Str::limit(strip_tags($announce->content), 120) }}</p>
                                <a href="{{ route('siswa.pengumuman') }}" style="text-decoration:none;color:var(--blue-dark);font-weight:700">Lihat Pengumuman →</a>
                            </div>
                            <div style="width:86px;text-align:right;color:var(--muted);font-size:13px">{{ $announce->formatted_date ?? $announce->created_at->format('d M Y') }}</div>
                        </div>
                    </article>
                @endforeach
            @else
                <div class="card">
                    <h4>Tidak ada pengumuman</h4>
                    <p style="color:var(--muted)">Belum ada pengumuman aktif saat ini.</p>
                </div>
            @endif
        </div>
    </section>
    <!-- STATS -->
    <section class="wrap">
        <div class="cards" style="grid-template-columns: repeat(3,1fr);">
            <div class="card" style="display:flex;align-items:center;gap:16px;">
                <div class="icon" style="width:60px;height:60px;border-radius:12px;background:linear-gradient(90deg,#cfeff5,#dff9ef);font-size:20px;">👥</div>
                <div>
                    <h4 style="font-size:20px;margin-bottom:6px">{{ $totalRegistrations ?? 0 }} Pendaftar</h4>
                    <p style="margin:0;color:var(--muted);font-size:13px">Total pendaftar hingga saat ini</p>
                </div>
            </div>

            <div class="card" style="display:flex;align-items:center;gap:16px;">
                <div class="icon" style="width:60px;height:60px;border-radius:12px;background:linear-gradient(90deg,#fef9c3,#ecfccb);font-size:20px;">✅</div>
                <div>
                    <h4 style="font-size:20px;margin-bottom:6px">{{ $accepted ?? 0 }} Diterima</h4>
                    <p style="margin:0;color:var(--muted);font-size:13px">Siswa yang sudah diterima</p>
                </div>
            </div>

            <div class="card" style="display:flex;align-items:center;gap:16px;">
                <div class="icon" style="width:60px;height:60px;border-radius:12px;background:linear-gradient(90deg,#e6f7ff,#eef6fb);font-size:20px;">⏳</div>
                <div>
                    <h4 style="font-size:20px;margin-bottom:6px">{{ $pending ?? 0 }} Menunggu</h4>
                    <p style="margin:0;color:var(--muted);font-size:13px">Sedang dalam proses verifikasi</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ABOUT -->
    <section id="about" class="wrap">
        <div class="section-title">
            <h3>Mengapa Memilih SD Negeri Larangan?</h3>
            <p>Kami menghadirkan lingkungan belajar yang ramah anak, pengajar profesional, serta fasilitas yang
                mendukung perkembangan akademik dan karakter siswa.</p>
        </div>

        <div class="cards">
            <article class="card">
                <div class="icon">💡</div>
                <h4>Pembelajaran Inovatif</h4>
                <p>Metode pembelajaran modern yang menggabungkan pendekatan personal dan teknologi untuk mengembangkan
                    kreativitas siswa.</p>
            </article>

            <article class="card">
                <div class="icon">👩‍🏫</div>
                <h4>Tenaga Pengajar Berkualitas</h4>
                <p>Guru bersertifikat dan berpengalaman yang berdedikasi memberikan pembelajaran berkualitas serta
                    perhatian individual.</p>
            </article>

            <article class="card">
                <div class="icon">🏫</div>
                <h4>Fasilitas Lengkap</h4>
                <p>Ruang kelas nyaman, perpustakaan, area bermain, dan fasilitas olahraga yang mendukung pembelajaran
                    holistik.</p>
            </article>
        </div>
    </section>

    <!-- SYARAT -->
    <section id="syarat" class="wrap">
        <div class="section-title">
            <h3>Syarat Pendaftaran Siswa Baru</h3>
            <p>Pastikan Anda menyiapkan dokumen berikut sebelum melakukan pendaftaran online.</p>
        </div>

        <div class="two-col">
            <div class="big-card">
                <h4>Syarat Umum</h4>
                <div class="list-check">
                    <div class="list-item">
                        <div class="badge">✓</div>
                        <div><strong>Berusia minimal 7 tahun</strong>
                            <div style="color:var(--muted);font-size:13px">Per 1 Juli tahun ajaran</div>
                        </div>
                    </div>
                    <div class="list-item">
                        <div class="badge">✓</div>
                        <div><strong>Telah Lulus TK/PAUD</strong>
                            <div style="color:var(--muted);font-size:13px">Tidak wajib, tapi diutamakan yang pernah
                                PAUD/TK 1 tahun.</div>
                        </div>
                    </div>
                    <div class="list-item">
                        <div class="badge">✓</div>
                        <div><strong>Sehat jasmani & rohani</strong>
                            <div style="color:var(--muted);font-size:13px">Dapat diminta surat keterangan dokter</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="big-card">
                <h4>Dokumen Persyaratan</h4>
                <div class="list-check">
                    <div class="list-item">
                        <div class="badge doc-badge">1</div>
                        <div><strong>Akta Kelahiran</strong>
                            <div style="color:var(--muted);font-size:13px"></div>
                        </div>
                    </div>
                    <div class="list-item">
                        <div class="badge doc-badge">2</div>
                        <div><strong>Kartu Keluarga</strong>
                            <div style="color:var(--muted);font-size:13px"></div>
                        </div>
                    </div>
                    <div class="list-item">
                        <div class="badge doc-badge">3</div>
                        <div><strong>Pas Foto</strong>
                            <div style="color:var(--muted);font-size:13px">3x4 cm</div>
                        </div>
                    </div>
                    <div class="list-item">
                        <div class="badge doc-badge">4</div>
                        <div><strong>Ijazah Terakhir</strong>
                            <div style="color:var(--muted);font-size:13px"></div>
                        </div>
                    </div>
                    <div class="list-item">
                        <div class="badge doc-badge">5</div>
                        <div><strong>KTP Orang Tua/Wali</strong>
                            <div style="color:var(--muted);font-size:13px"></div>
                        </div>
                    </div>
                    <div class="list-item">
                        <div class="badge doc-badge">6</div>
                        <div><strong> Kartu Bantuan </strong>
                            <div style="color:var(--muted);font-size:13px">Jika Memiliki</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ALUR -->
    <section id="alur" class="wrap">
        <div class="section-title">
            <h3>Alur Pendaftaran Online</h3>
            <p>Ikuti langkah-langkah berikut untuk melakukan pendaftaran melalui sistem SIPESAR.</p>
        </div>

        <div class="steps">
            <div class="step">
                <div class="round">1</div>
                <h4>Daftar Akun</h4>
                <p>Buat akun dengan data siswa</p>
            </div>
            <div class="step">
                <div class="round">2</div>
                <h4>Isi Formulir</h4>
                <p>Lengkapi data pribadi dan orang tua</p>
            </div>
            <div class="step">
                <div class="round">3</div>
                <h4>Unggah Dokumen</h4>
                <p>Upload syarat (Akta Kelahiran, Kartu Keluarga, pas foto 3x4, Ijazah terakhir, KTP Orang Tua/Wali,
                    kartu Bantuan (Jika punya) )</p>
            </div>
            <div class="step">
                <div class="round">4</div>
                <h4>Verifikasi</h4>
                <p>Verifikasi oleh Panitia Sekolah </p>
            </div>
            <div class="step">
                <div class="round">5</div>
                <h4>Pengumuman Hasil Seleksi</h4>
                <p>Aakan ada Informasi Terkait Pengumuman Hasil Seleksi</p>
            </div>
            <div class="step">
                <div class="round">6</div>
                <h4>Daftar Ulang</h4>
                <p>Siswa yang diterima wajib melakukan daftar ulang dengan membawa dokumen asli.</p>
            </div>
        </div>
    </section>

    <!-- KONTAK -->
    <section id="kontak" class="wrap">
        <div class="section-title">
            <h3>Hubungi Kami</h3>
            <p>Jika ada pertanyaan seputar penerimaan siswa baru, silakan hubungi kontak resmi berikut.</p>
        </div>

        <div class="contact-grid">
            <div class="contact-card">
                <h4>Telepon</h4>
                <p>(0281) 245759</p>
                <a class="contact-btn" href="tel:0281123456">Hubungi</a>
            </div>
            <div class="contact-card">
                <h4>Email</h4>
                <p>info@sdlarangan.sch.id</p>
                <a class="contact-btn" href="mailto:info@sdlarangan.sch.id">Kirim Email</a>
            </div>
            <div class="contact-card">
                <h4>Alamat</h4>
                <p> Jln. Kecamatan No. 3 Kembaran RT / RW : 2 / 1, Desa / Kelurahan : Kembaran, Kecamatan : Kec.
                    Kembaran, Kode Pos : 53182</p>
                <a class="contact-btn" href="https://maps.app.goo.gl/ztvJKubSid7HTYf47" target="_blank">Lihat
                    Peta</a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="wrap footer-grid">
            <div>
                <h5>Tentang SIPESAR</h5>
                <p>SIPESAR (Sistem Penerimaan Siswa Baru) adalah portal resmi pendaftaran SD Negeri Larangan yang
                    mempermudah proses administrasi.</p>
            </div>
            <div>
                <h5>Informasi</h5>
                <p>FAQ <br> Jadwal Pendaftaran <br> Biaya Pendidikan</p>
            </div>
            <div>
                <h5>Ikuti Kami</h5>
                <div class="socials">
                    <a href="#">f</a>
                    <a href="#">▶</a>
                    <a href="#">📷</a>
                </div>
            </div>
        </div>
    </footer>

    {{-- SCRIPT DIPINDAH KE AKHIR & TANPA FITUR UPLOAD BG --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const reveals = document.querySelectorAll('.reveal, .card, .step, .contact-card');

            function handleScroll() {
                for (let el of reveals) {
                    const rect = el.getBoundingClientRect();
                    if (rect.top < window.innerHeight - 80) {
                        el.classList.add('show');
                    }
                }
            }

            window.addEventListener('scroll', handleScroll);
            handleScroll(); // trigger awal
        });
    </script>
</body>

</html>

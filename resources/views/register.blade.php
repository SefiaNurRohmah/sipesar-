<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Register - SIPESAR SD Negeri Larangan</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --blue: #0ea5a3;
            --blue-dark: #0b6b66;
            --green: #13b58b;
            --muted: #6b7280;
            --bg-soft: #eafaf9;
            --card-shadow: 0 12px 40px rgba(13, 44, 40, 0.08);
            --radius: 18px;
            --glass: rgba(255,255,255,0.86);
            font-family: 'Poppins', sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: radial-gradient(circle at top left, #dff8f5 0, #f6fbff 40%, #e3f3ff 100%);
        }

        /* HEADER */
        header {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 24px;
            background: rgba(255, 255, 255, 0.96);
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.06);
            position: sticky;
            top: 0;
            z-index: 10;
            backdrop-filter: blur(10px);
        }

        header img {
            height: 50px;
            width: 50px;
            border-radius: 12px;
            object-fit: cover;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .brand-text strong {
            font-size: 18px;
            color: var(--blue-dark);
            font-weight: 700;
        }

        .brand-text span {
            font-size: 13px;
            color: var(--muted);
        }

        /* MAIN LAYOUT */
        .register-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 16px 40px;
        }

        .register-layout {
            width: 100%;
            max-width: 980px;
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--card-shadow);
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            background: linear-gradient(180deg, var(--glass), rgba(255,255,255,0.98));
            border: 1px solid rgba(8, 120, 112, 0.04);
        }

        /* LEFT PANEL (INFO + ILLUSTRATION) */
        .register-info {
            position: relative;
            padding: 42px 36px 28px;
            color: white;
            background-image: linear-gradient(135deg, rgba(24, 139, 127, 0.92), rgba(6, 101, 91, 0.92)),
                url("{{ asset('asset/kartun anak sd.jpg') }}");
            background-size: cover;
            background-position: center;
        }

        .register-info::after {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top left, rgba(255, 255, 255, 0.18), transparent 50%);
            mix-blend-mode: screen;
        }

        .register-info-inner {
            position: relative;
            z-index: 1;
            max-width: 380px;
        }

        .badge-small {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11px;
            background: rgba(255, 255, 255, 0.18);
        }

        .badge-dot {
            width: 7px;
            height: 7px;
            border-radius: 999px;
            background: #bbf7d0;
        }

        .register-info h2 {
            margin: 14px 0 6px;
            font-size: 26px;
        }

        .register-info p {
            margin: 0 0 18px;
            font-size: 13px;
            color: rgba(241, 245, 249, 0.96);
        }

        .info-list {
            list-style: none;
            padding: 0;
            margin: 0 0 22px;
            font-size: 13px;
        }

        .info-list li {
            display: flex;
            gap: 8px;
            margin-bottom: 6px;
        }

        .info-list li span {
            margin-top: 2px;
        }

        .info-footnote {
            font-size: 11px;
            opacity: 0.9;
        }

        /* RIGHT PANEL (FORM) */
        .register-card {
            padding: 28px 28px 28px;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .register-card-header {
            margin-bottom: 12px;
            text-align: left;
        }

        .register-card-header h3 {
            margin: 0 0 4px;
            font-size: 22px;
            color: var(--blue-dark);
        }

        .register-card-header span {
            font-size: 13px;
            color: var(--muted);
        }

        .step-indicator {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 999px;
            background: #ecfeff;
            color: var(--blue-dark);
            font-size: 11px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        /* FORM */
        .form-group {
            margin-bottom: 14px;
        }

        label {
            display: block;
            font-weight: 600;
            font-size: 13px;
            margin-bottom: 5px;
            color: var(--blue-dark);
        }

        .input-group{
            position:relative;
        }
        input {
            width: 100%;
            padding: 12px 12px 12px 44px;
            border-radius: 10px;
            border: 1px solid #e6eef0;
            font-size: 14px;
            transition: all 0.18s ease;
            font-family: inherit;
            background: linear-gradient(180deg, rgba(248,252,252,0.8), rgba(255,255,255,0.98));
        }

        input:focus {
            outline: none;
            border-color: var(--blue);
            box-shadow: 0 3px 18px rgba(14, 165, 163, 0.08), inset 0 1px 0 rgba(255,255,255,0.3);
        }

        /* input icon */
        .input-icon{
            position:absolute;left:12px;top:50%;transform:translateY(-50%);width:24px;height:24px;display:flex;align-items:center;justify-content:center;font-size:14px;color:var(--blue-dark);
        }
        .field-hint{font-size:12px;color:var(--muted);margin-top:6px}

        .password-wrapper {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center;
            border-radius:8px; cursor:pointer; color:var(--muted);
            transition: background .15s ease, transform .12s ease;
        }
        .toggle-password:hover{ background: rgba(6, 95, 86, 0.06); transform:translateY(-2px) }
        .toggle-password svg{ width:18px;height:18px; display:block }
        /* Visual only, for SR only text */
        .sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}

        .btn-primary {
            width: 100%;
            background: linear-gradient(90deg, var(--green), var(--blue));
            color: white;
            padding: 13px;
            border: none;
            border-radius: 999px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease, opacity 0.2s ease;
            margin-top: 6px;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            opacity: 0.97;
            box-shadow: 0 10px 24px rgba(14, 165, 163, 0.45);
        }

        /* small microcopy */
        .meta-small{font-size:13px;color:var(--muted);margin-top:8px}

        /* password strength */
        .pw-strength{
            height:8px;border-radius:8px;background:#eef2f2;overflow:hidden;margin-top:8px
        }
        .pw-strength .bar{height:100%;width:0%;background:linear-gradient(90deg,#ff8a65,#13b58b);transition:width .2s ease}

        .link-login {
            margin-top: 14px;
            text-align: center;
            font-size: 13px;
            color: var(--muted);
        }

        .link-login a {
            color: var(--blue);
            font-weight: 600;
            text-decoration: none;
        }

        .link-login a:hover {
            text-decoration: underline;
        }

        /* Error Message */
        .error-message {
            color: #dc2626;
            margin-bottom: 14px;
            font-size: 13px;
            background: #fef2f2;
            border-radius: 10px;
            padding: 8px 10px;
        }

        .error-message ul {
            margin: 0 0 0 16px;
            padding-left: 4px;
        }

        /* RESPONSIVE */
        @media (max-width: 880px) {
            .register-layout {
                grid-template-columns: 1fr;
            }

            .register-info {
                display: none;
            }

            .register-card {
                padding: 22px 18px 22px;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <img src="{{ asset('asset/logo sipesar.png') }}" alt="Logo SIPESAR">
        <div class="brand-text">
            <strong>SD Negeri Larangan</strong>
            <span>Portal SIPESAR (Sistem Penerimaan Siswa Baru)</span>
        </div>
    </header>

    <!-- Register Layout -->
    <div class="register-wrapper">
        <div class="register-layout">
            <!-- Left info panel -->
            <div class="register-info">
                <div class="register-info-inner">
                    <div class="badge-small">
                        <span class="badge-dot"></span> SPSB Online
                    </div>
                    <h2>Selamat Datang di SIPESAR</h2>
                    <p>Buat akun terlebih dahulu untuk mulai mengisi formulir pendaftaran siswa baru secara
                        online, kapan pun dan di mana pun.</p>

                    <ul class="info-list">
                        <li>
                            <span>✅</span>
                            <div>Proses pendaftaran lebih cepat & transparan.</div>
                        </li>
                        <li>
                            <span>✅</span>
                            <div>Pantau status verifikasi dokumen langsung dari rumah.</div>
                        </li>
                        <li>
                            <span>✅</span>
                            <div>Data tersimpan aman di sistem sekolah.</div>
                        </li>
                    </ul>

                    <div class="info-footnote">
                        Pastikan email & nomor HP yang digunakan masih aktif, agar mudah dihubungi oleh panitia
                        SPSB.
                    </div>
                </div>
            </div>

            <!-- Right form panel -->
            <div class="register-card">
                <div class="register-card-header">
                    <h3>Buat Akun Baru</h3>
                    <span>Isi data di bawah ini dengan benar.</span>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="error-message">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" id="nama" name="name"
                               placeholder="Masukkan nama lengkap"
                               value="{{ old('name') }}" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Aktif</label>
                        <input type="email" id="email" name="email"
                               placeholder="contoh@email.com"
                               value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="hp">Nomor HP</label>
                        <input type="text" id="hp" name="hp"
                               placeholder="0812xxxxxxx" value="{{ old('hp') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Kata Sandi</label>
                           <div class="password-wrapper">
                            <input type="password" id="password" name="password"
                                placeholder="Minimal 6 karakter" required>
                            <button type="button" class="toggle-password" data-target="password" aria-pressed="false" aria-label="Tampilkan kata sandi">
                                <!-- eye-open icon -->
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <span class="sr-only">Tampilkan kata sandi</span>
                            </button>
                        </div>
                        <div id="pw-hint" class="field-hint">Gunakan kombinasi huruf besar, angka, dan simbol untuk keamanan.</div>
                        <div class="pw-strength" aria-hidden><div class="bar" id="pw-bar"></div></div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                        <div class="password-wrapper">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   placeholder="Ulangi kata sandi" required>
                            <button type="button" class="toggle-password" data-target="password_confirmation" aria-pressed="false" aria-label="Tampilkan kata sandi konfirmasi">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <span class="sr-only">Tampilkan kata sandi konfirmasi</span>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary">Daftar</button>
                </form>

                <div class="link-login">
                    Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle tampil/sembunyi password
        document.querySelectorAll('.toggle-password').forEach(btn => {
            btn.addEventListener('click', () => {
                const targetId = btn.getAttribute('data-target');
                const input = document.getElementById(targetId);
                if (!input) return;

                    const eyeOpen = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">\n                                        <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"></path>\n                                        <circle cx="12" cy="12" r="3"></circle>\n                                    </svg>';
                    const eyeClose = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">\n                                        <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a19.79 19.79 0 0 1 5.59-6.36"></path>\n                                        <path d="M1 1l22 22"></path>\n                                    </svg>';

                    // Toggle input type
                    if (input.type === 'password') {
                        input.type = 'text';
                        btn.setAttribute('aria-pressed', 'true');
                        btn.setAttribute('aria-label', 'Sembunyikan kata sandi');
                        // update icon and SR text
                        btn.innerHTML = eyeClose + '<span class="sr-only">Sembunyikan kata sandi</span>';
                    } else {
                        input.type = 'password';
                        btn.setAttribute('aria-pressed', 'false');
                        btn.setAttribute('aria-label', 'Tampilkan kata sandi');
                        btn.innerHTML = eyeOpen + '<span class="sr-only">Tampilkan kata sandi</span>';
                    }
            });
        });

        // Password strength indicator (simple)
        const pwInput = document.getElementById('password');
        const pwBar = document.getElementById('pw-bar');
        if (pwInput && pwBar) {
            pwInput.addEventListener('input', () => {
                const val = pwInput.value;
                let score = 0;
                if (val.length >= 6) score += 1;
                if (/[A-Z]/.test(val)) score += 1;
                if (/[0-9]/.test(val)) score += 1;
                if (/[^A-Za-z0-9]/.test(val)) score += 1;

                let width = (score / 4) * 100;
                pwBar.style.width = width + '%';
                if (width < 34) {
                    pwBar.style.background = 'linear-gradient(90deg,#ff8a65,#fb7185)';
                } else if (width < 66) {
                    pwBar.style.background = 'linear-gradient(90deg,#ffd166,#f59e0b)';
                } else {
                    pwBar.style.background = 'linear-gradient(90deg,#34d399,#059669)';
                }
            });
        }

        // Simple client-side validation before submit (adds a class on errors)
        document.querySelector('form').addEventListener('submit', function (e) {
            const email = document.getElementById('email');
            const hp = document.getElementById('hp');
            const pwd = document.getElementById('password');
            const confirm = document.getElementById('password_confirmation');

            // Clear previous markers
            document.querySelectorAll('.error-message-js').forEach(el => el.remove());

            const errors = [];
            if (!email.value.includes('@')) errors.push('Email harus valid.');
            if (hp.value.length < 8) errors.push('Nomor HP terlalu pendek.');
            if (pwd.value.length < 6) errors.push('Kata sandi minimal 6 karakter.');
            if (pwd.value !== confirm.value) errors.push('Kata sandi dan konfirmasi tidak cocok.');

            if (errors.length) {
                e.preventDefault();
                const container = document.createElement('div');
                container.className = 'error-message error-message-js';
                container.innerHTML = '<ul>' + errors.map(err => '<li>' + err + '</li>').join('') + '</ul>';
                document.querySelector('.register-card').insertBefore(container, document.querySelector('.register-card').children[0]);
                window.scrollTo({top: document.querySelector('.register-card').offsetTop - 24, behavior: 'smooth'});
                return false;
            }
        });
    </script>

</body>

</html>

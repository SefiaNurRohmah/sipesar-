<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Login - SIPESAR SD Negeri Larangan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --blue: #0ea5a3;
            --blue-dark: #0b6b66;
            --green: #13b58b;
            --muted: #6b7280;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
            --radius: 16px;
            font-family: 'Poppins', sans-serif;
        }

        body {
            margin: 0;
            background: #f6fbff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        header {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 24px;
            background: #fff;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.06);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        header img {
            height: 52px;
            width: 52px;
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
            color: #075e54;
            /* hijau tua */
            font-weight: 700;
        }

        .brand-text span {
            font-size: 13px;
            color: var(--muted);
            font-weight: 400;
        }

        /* Layout */
        .login-page {
            flex: 1;
            display: flex;
            min-height: calc(100vh - 70px);
        }

        .login-left {
            flex: 1;
            background: url('https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEhMhKFGeb_zoU6cBPnXofxZ-mpJz1MfnbGBlKUxkiSgi8FBl6-akZxfJfDmXV1-MUSxnp1xddxgAcrbBg7EQdz-w78QH3rGLE9ebPB2q5F4VS2tjiXt0LOv6awQGymoLq6hsJgd8PeHY-D4DeMjg0j0P8wV-MkSzFxCfnHpMAl3ORtmQS5R2egaSEqE/s1600/20230312_0941500.jpg') center/cover no-repeat;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        .login-left::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
        }

        .login-left .overlay-text {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 20px;
        }

        .login-left h2 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .login-left p {
            font-size: 16px;
            max-width: 400px;
            margin: 0 auto;
        }

        .login-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .login-card {
            background: #fff;
            border-radius: var(--radius);
            box-shadow: var(--card-shadow);
            padding: 40px;
            max-width: 420px;
            width: 100%;
            animation: fadeIn 0.8s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-card h2 {
            margin: 0 0 20px;
            font-size: 26px;
            text-align: center;
            color: var(--blue-dark);
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 6px;
            color: var(--blue-dark);
        }

        input {
            width: 100%;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid #d1d5db;
            font-size: 15px;
            transition: all 0.2s ease;
        }

        input:focus {
            outline: none;
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(14, 165, 163, 0.2);
        }

        .btn-primary {
            width: 100%;
            background: linear-gradient(90deg, var(--green), var(--blue));
            color: white;
            padding: 14px;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            transition: transform 0.2s ease, opacity 0.2s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            opacity: 0.95;
        }

        .link-register {
            margin-top: 18px;
            text-align: center;
            font-size: 14px;
            color: var(--muted);
        }

        .link-register a {
            color: var(--blue);
            font-weight: 600;
            text-decoration: none;
        }

        .link-register a:hover {
            text-decoration: underline;
        }

        @media (max-width: 900px) {
            .login-page {
                flex-direction: column;
            }

            .login-left {
                min-height: 200px;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <img src="asset/logo sipesar.png" alt="Logo SIPESAR">
        <div class="brand-text">
            <strong>SD Negeri Larangan</strong>
            <span>Portal SIPESAR (Sistem Penerimaan Siswa Baru)</span>
        </div>
    </header>

    <!-- Login Content -->
    <div class="login-page">
        <div class="login-left">
            <div class="overlay-text">
                <h2>Selamat Datang</h2>
                <p>Akses akun Anda untuk memantau status pendaftaran dan melanjutkan proses SIPESAR dengan mudah.</p>
            </div>
        </div>
        <div class="login-right">
            <div class="login-card">
                <h2>Login Akun</h2>
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="login">Email / Nomor HP</label>
                        <input type="text" id="login" name="login" placeholder="Masukkan email atau nomor HP Anda" value="{{ old('login') }}"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="password">Kata Sandi</label>
                        <input type="password" id="password" name="password" placeholder="Masukkan kata sandi"
                            required>
                    </div>
                    <button type="submit" class="btn-primary">Masuk</button>
                </form>
                <div class="link-register">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
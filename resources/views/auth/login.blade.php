<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - SPK TK Al Azkar</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <style>
        :root {
            --primary: #1B4332;
            --primary-light: #52b788;
            --secondary: #F17F72;
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --bg-color: #f4faf6;
            --card-bg: #ffffff;
            --glass-border: #e5e7eb;
            --input-bg: #f9fafb;
            --error-color: #ef4444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Nunito', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
            color: var(--text-main);
        }

        /* Animated Background Orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.8;
            animation: float 20s infinite alternate;
            z-index: 1;
        }

        .orb-1 {
            background: #d8f3df;
            width: 450px;
            height: 450px;
            top: -100px;
            left: -100px;
            animation-delay: 0s;
        }

        .orb-2 {
            background: #fde4e1;
            width: 350px;
            height: 350px;
            bottom: -50px;
            right: -50px;
            animation-delay: -5s;
        }

        .orb-3 {
            background: #a9deb9;
            width: 300px;
            height: 300px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: -10s;
        }

        @keyframes float {
            0% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(50px, -50px) scale(1.1); }
            66% { transform: translate(-30px, 40px) scale(0.9); }
            100% { transform: translate(0, 0) scale(1); }
        }

        /* Container */
        .login-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 450px;
            padding: 2rem;
            margin: 1rem;
        }

        .glass-card {
            background: var(--card-bg);
            border: 2px dashed var(--glass-border);
            border-radius: 30px;
            padding: 2.5rem 2rem;
            box-shadow: 0 20px 40px rgba(27, 67, 50, 0.08);
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(30px);
        }

        @keyframes slideUp {
            to { opacity: 1; transform: translateY(0); }
        }

        .header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .header-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            background: rgba(82, 183, 136, 0.15);
            border-radius: 50%;
            margin-bottom: 1.5rem;
            font-size: 28px;
            color: var(--primary);
        }

        .header h1 {
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 0.5rem;
            color: var(--primary);
        }

        .header p {
            color: var(--text-muted);
            font-size: 15px;
            font-weight: 600;
        }

        /* Form Group */
        .form-group {
            margin-bottom: 1.2rem;
            position: relative;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--primary);
            transition: color 0.3s;
            margin-left: 5px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 1.2rem;
            color: var(--text-muted);
            font-size: 20px;
            transition: all 0.3s ease;
            z-index: 2;
        }

        .form-control {
            width: 100%;
            background: var(--input-bg);
            border: 2px solid var(--glass-border);
            color: var(--text-main);
            padding: 0.8rem 1rem 0.8rem 3rem;
            border-radius: 16px;
            font-size: 15px;
            outline: none;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .form-control::placeholder {
            color: #9ca3af;
            font-weight: 500;
        }

        .form-control:focus {
            border-color: var(--primary-light);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(82, 183, 136, 0.15);
        }

        .input-wrapper:focus-within .input-icon {
            color: var(--primary-light);
            transform: scale(1.1);
        }

        /* Error Box */
        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border-left: 4px solid var(--error-color);
            color: #b91c1c;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            50% { transform: translateX(5px); }
            75% { transform: translateX(-5px); }
        }

        /* Button */
        .btn-submit {
            width: 100%;
            padding: 1rem;
            background: var(--primary);
            border: none;
            border-radius: 16px;
            color: white;
            font-size: 16px;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 1.5rem;
            box-shadow: 0 8px 20px rgba(27, 67, 50, 0.25);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            background: #122c21;
            box-shadow: 0 12px 25px rgba(27, 67, 50, 0.35);
        }

        .btn-submit:active {
            transform: translateY(1px);
        }

        /* Credentials info */
        .credentials {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 2px dashed var(--glass-border);
            text-align: center;
        }

        .credentials p {
            color: var(--text-muted);
            font-size: 13px;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-weight: 600;
        }

        .credentials p i {
            color: var(--secondary);
            font-size: 16px;
        }

        .badge {
            background: rgba(241, 127, 114, 0.1);
            padding: 3px 8px;
            border-radius: 8px;
            color: var(--secondary);
            font-family: 'Nunito', monospace;
            border: 1px solid rgba(241, 127, 114, 0.2);
        }
    </style>
</head>
<body>

    <!-- Animated Background -->
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <div class="login-wrapper">
        <div class="glass-card">
            <div class="header">
                <div style="margin-bottom: 1rem; display: flex; justify-content: center;">
                    <div style="background: white; padding: 12px; border-radius: 20px; display: inline-block; box-shadow: 0 10px 20px rgba(0,0,0,0.05); border: 3px solid var(--primary-light);">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo TK Al Azkar" style="width: 75px; height: 75px; object-fit: contain; border-radius: 8px;">
                    </div>
                </div>
                <h1>SPK Al Azkar</h1>
                <p>Silakan masuk ke akun Anda</p>
            </div>

            @if($errors->any())
                <div class="alert-error">
                    <i class="ri-error-warning-line"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ url('/login') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="email">Alamat Email</label>
                    <div class="input-wrapper">
                        <i class="ri-mail-line input-icon"></i>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Contoh: kepsek@alazkar.tk" value="{{ old('email') }}" required autofocus autocomplete="email">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Kata Sandi</label>
                    <div class="input-wrapper">
                        <i class="ri-lock-2-line input-icon"></i>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan kata sandi" required autocomplete="current-password">
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <span>Masuk Aplikasi</span>
                    <i class="ri-arrow-right-line"></i>
                </button>
            </form>

            <div class="credentials">
                <p><i class="ri-admin-fill"></i> <span>Admin: <span class="badge">kepsek@alazkar.tk</span> / <span class="badge">password</span></span></p>
                <p><i class="ri-user-smile-fill"></i> <span>Guru: <span class="badge">budi.guru@alazkar.tk</span> / <span class="badge">password</span></span></p>
            </div>
        </div>
    </div>

</body>
</html>

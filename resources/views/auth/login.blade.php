<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - SPK TK Al Azkar</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <style>
        :root {
            --primary: #6366f1;
            --primary-light: #818cf8;
            --primary-dark: #4f46e5;
            --secondary: #ec4899;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --bg-color: #0f172a;
            --glass-bg: rgba(30, 41, 59, 0.7);
            --glass-border: rgba(255, 255, 255, 0.1);
            --input-bg: rgba(15, 23, 42, 0.6);
            --error-color: #ef4444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
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
            opacity: 0.5;
            animation: float 20s infinite alternate;
            z-index: 1;
        }

        .orb-1 {
            background: var(--primary);
            width: 400px;
            height: 400px;
            top: -100px;
            left: -100px;
            animation-delay: 0s;
        }

        .orb-2 {
            background: var(--secondary);
            width: 350px;
            height: 350px;
            bottom: -50px;
            right: -50px;
            animation-delay: -5s;
        }

        .orb-3 {
            background: #3b82f6;
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

        /* Glass Container */
        .login-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 450px;
            padding: 2rem;
            margin: 1rem;
        }

        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 2rem 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(30px);
        }

        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
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
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 16px;
            margin-bottom: 1.5rem;
            font-size: 28px;
            color: white;
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
        }

        .header h1 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(to right, #fff, #cbd5e1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .header p {
            color: var(--text-muted);
            font-size: 15px;
            font-weight: 300;
        }

        /* Form Group */
        .form-group {
            margin-bottom: 1.2rem;
            position: relative;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #cbd5e1;
            transition: color 0.3s;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            color: var(--text-muted);
            font-size: 20px;
            transition: all 0.3s ease;
            z-index: 2;
        }

        .form-control {
            width: 100%;
            background: var(--input-bg);
            border: 1px solid var(--glass-border);
            color: white;
            padding: 0.8rem 1rem 0.8rem 2.8rem;
            border-radius: 12px;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
        }

        .form-control::placeholder {
            color: #64748b;
        }

        .form-control:focus {
            border-color: var(--primary-light);
            background: rgba(30, 41, 59, 0.8);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
        }

        .input-wrapper:focus-within .input-icon {
            color: var(--primary-light);
            transform: scale(1.1);
        }

        /* Error Box */
        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border-left: 4px solid var(--error-color);
            color: #fca5a5;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
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
            padding: 0.8rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 0.5rem;
        }

        .btn-submit::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.2) 50%, rgba(255,255,255,0) 100%);
            transform: skewX(-20deg);
            transition: all 0.6s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.4);
        }

        .btn-submit:hover::after {
            left: 150%;
        }

        .btn-submit:active {
            transform: translateY(1px);
        }

        /* Credentials info */
        .credentials {
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--glass-border);
            text-align: center;
        }

        .credentials p {
            color: var(--text-muted);
            font-size: 13px;
            margin-bottom: 0.5rem;
            line-height: 1.6;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .credentials p i {
            color: var(--primary-light);
        }

        .badge {
            background: rgba(255,255,255,0.1);
            padding: 2px 8px;
            border-radius: 4px;
            color: #cbd5e1;
            font-family: monospace;
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
                    <div style="background: white; padding: 8px; border-radius: 16px; display: inline-block; box-shadow: 0 10px 20px rgba(0,0,0,0.2);">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo TK Al Azkar" style="width: 65px; height: 65px; object-fit: contain;">
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
                <p><i class="ri-admin-line"></i> <span>Admin: <span class="badge">kepsek@alazkar.tk</span> / <span class="badge">password</span></span></p>
                <p><i class="ri-user-2-line"></i> <span>Guru: <span class="badge">budi.guru@alazkar.tk</span> / <span class="badge">password</span></span></p>
            </div>
        </div>
    </div>

</body>
</html>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --bg-body: #f8fafc;
            --bg-card: #ffffff;
            --border: #e2e8f0;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --input-bg: #ffffff;
            --input-border: #cbd5e1;
            --demo-bg: rgba(99, 102, 241, 0.05);
            --demo-border: rgba(99, 102, 241, 0.15);
        }

        [data-theme="dark"] {
            --bg-body: #0f172a;
            --bg-card: #1e293b;
            --border: #334155;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --input-bg: #0f172a;
            --input-border: #334155;
            --demo-bg: rgba(99, 102, 241, 0.08);
            --demo-border: rgba(99, 102, 241, 0.2);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            position: relative;
            overflow: hidden;
            transition: background-color 0.3s, color 0.3s;
        }

        body::before {
            /*content: '';*/
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, transparent 70%);
            top: -200px;
            right: -200px;
        }

        body::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(168, 85, 247, 0.1) 0%, transparent 70%);
            bottom: -150px;
            left: -100px;
        }

        .login-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 3rem;
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 1;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, border-color 0.3s;
        }

        [data-theme="dark"] .login-card {
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        }

        .brand-section {
            text-align: center;
            margin-bottom: 2rem;
        }

        .brand-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            color: white;
            margin-bottom: 1rem;
            box-shadow: 0 8px 32px rgba(99, 102, 241, 0.3);
        }

        .brand-section h2 {
            color: var(--text-main);
            font-weight: 800;
            font-size: 1.5rem;
            margin: 0;
        }

        .brand-section p {
            color: var(--text-muted);
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }

        .form-control {
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            color: var(--text-main);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            background: var(--bg-card);
            border-color: #6366f1;
            color: var(--text-main);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
            outline: none;
        }

        .form-label {
            color: var(--text-muted);
            font-weight: 500;
            font-size: 0.85rem;
        }

        .btn-login {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            border: none;
            color: white;
            font-weight: 700;
            border-radius: 12px;
            padding: 0.75rem;
            font-size: 0.95rem;
            width: 100%;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #818cf8, #6366f1);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.3);
        }

        .error-message {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 10px;
            padding: 0.75rem 1rem;
            color: #f87171;
            font-size: 0.85rem;
            margin-bottom: 1rem;
        }

        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
        }

        .input-icon .form-control {
            padding-left: 2.75rem;
        }

        .demo-info {
            margin-top: 1.5rem;
            padding: 1rem;
            background: var(--demo-bg);
            border: 1px solid var(--demo-border);
            border-radius: 12px;
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .demo-info strong {
            color: #818cf8;
        }

        .theme-toggle {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            background: var(--bg-card);
            border: 1px solid var(--border);
            color: var(--text-main);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            transition: all 0.3s;
        }

        .theme-toggle:hover {
            background: var(--input-bg);
        }

        /* Mobile Responsive */
        @media (max-width: 480px) {
            body {
                padding: 1rem;
            }

            .login-card {
                padding: 1.75rem 1.25rem;
                border-radius: 20px;
            }

            .brand-icon {
                width: 52px;
                height: 52px;
                font-size: 1.4rem;
                border-radius: 16px;
            }

            .brand-section h2 {
                font-size: 1.25rem;
            }

            .brand-section {
                margin-bottom: 1.25rem;
            }

            .form-control {
                padding: 0.65rem 0.85rem;
                font-size: 0.85rem;
            }

            .input-icon .form-control {
                padding-left: 2.5rem;
            }

            .btn-login {
                padding: 0.65rem;
                font-size: 0.9rem;
            }

            .demo-info {
                padding: 0.75rem;
                font-size: 0.7rem;
                margin-top: 1rem;
            }

            .theme-toggle {
                top: 1rem;
                right: 1rem;
                width: 36px;
                height: 36px;
            }
        }
    </style>
    <script>
        const currTheme = localStorage.getItem('theme') || 'dark';
        document.documentElement.setAttribute('data-theme', currTheme);
    </script>
</head>

<body>
    <button class="theme-toggle" onclick="toggleTheme()" title="Toggle Theme">
        <i class="bi bi-moon-stars-fill" id="theme-icon"></i>
    </button>
    <div class="login-card">
        <div class="brand-section">
            <div class="brand-icon"><i class="bi bi-shop"></i></div>
            <h2>Toko Kelontong</h2>
            <p>Sistem Manajemen Toko</p>
        </div>

        @if($errors->any())
            <div class="error-message">
                <i class="bi bi-exclamation-circle me-1"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <div class="input-icon">
                    <i class="bi bi-envelope"></i>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                        placeholder="Masukkan email" required autofocus>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-icon">
                    <i class="bi bi-lock"></i>
                    <input type="password" class="form-control" name="password" placeholder="Masukkan password"
                        required>
                </div>
            </div>
            <div class="mb-3 form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                    style="border-color:var(--border);">
                <label class="form-check-label" for="remember" style="color:var(--text-muted);font-size:0.85rem;">Ingat
                    saya</label>
            </div>
            <button type="submit" class="btn btn-login">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
            </button>
        </form>

        <!--<div class="demo-info">
            <strong>Demo Login:</strong><br>
            Admin: admin@toko.com / password<br>
            Kasir: kasir@toko.com / password<br>
            Owner: owner@toko.com / password
        </div>-->
    </div>
    <script>
        function updateIcon(th) {
            const icon = document.getElementById('theme-icon');
            if (th === 'dark') {
                icon.className = 'bi bi-moon-stars-fill';
            } else {
                icon.className = 'bi bi-brightness-high-fill';
            }
        }
        updateIcon(document.documentElement.getAttribute('data-theme'));

        function toggleTheme() {
            let currentTheme = document.documentElement.getAttribute('data-theme');
            let newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateIcon(newTheme);
        }
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>麗誠OP系統登入</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #4f8cff;
            --primary-hover: #3d79e8;
            --text-main: #1f2937;
            --text-soft: #6b7280;
            --border-color: #d7dde5;
            --card-bg: rgba(255, 255, 255, 0.92);
            --shadow: 0 18px 40px rgba(0, 0, 0, 0.12);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Segoe UI", "Microsoft JhengHei", "PingFang TC", sans-serif;
            background:
                linear-gradient(rgba(255,255,255,0.35), rgba(255,255,255,0.35)),
                url('{{ asset('images/back.jpg') }}') center center / cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-box {
            width: 100%;
            max-width: 400px;
            background: var(--card-bg);
            border: 1px solid rgba(255,255,255,0.7);
            border-radius: 20px;
            padding: 36px 30px;
            box-shadow: var(--shadow);
            backdrop-filter: blur(8px);
        }

        .login-logo {
            width: 60px;
            height: 60px;
            margin: 0 auto 18px;
            border-radius: 16px;
            background: linear-gradient(135deg, #5a8ff3, #8ab5ff);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: 700;
        }

        .login-title {
            text-align: center;
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 6px;
        }

        .login-subtitle {
            text-align: center;
            color: var(--text-soft);
            font-size: 0.92rem;
            margin-bottom: 28px;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .form-control {
            height: 48px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            font-size: 0.95rem;
            box-shadow: none;
        }

        .form-control:focus {
            border-color: #8eb4ff;
            box-shadow: 0 0 0 0.2rem rgba(79, 140, 255, 0.12);
        }

        .btn-login {
            height: 48px;
            border: none;
            border-radius: 12px;
            background: var(--primary);
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
        }

        .btn-login:hover {
            background: var(--primary-hover);
            color: #fff;
        }

        .alert {
            border-radius: 12px;
            border: none;
            margin-top: 16px;
            margin-bottom: 0;
        }

        .login-footer {
            text-align: center;
            margin-top: 22px;
            color: #94a3b8;
            font-size: 0.86rem;
        }

        @media (max-width: 576px) {
            .login-box {
                padding: 30px 20px;
                border-radius: 16px;
            }

            .login-title {
                font-size: 1.4rem;
            }
        }
    </style>
</head>
<body>

<div class="login-box">
    <div class="login-logo">OP</div>

    <div class="login-title">麗誠OP系統</div>
    <div class="login-subtitle">請登入您的帳號</div>

    <form method="POST" action="{{ route('login.submit') }}">
        @csrf

        <div class="mb-3">
            <label for="usercode" class="form-label">帳號</label>
            <input type="text" class="form-control" id="usercode" name="usercode" required autocomplete="username">
        </div>

        <div class="mb-3">
            <label for="userpass" class="form-label">密碼</label>
            <input type="password" class="form-control" id="userpass" name="userpass" required autocomplete="current-password">
        </div>

        @if($errors->has('login'))
            <div class="alert alert-danger">
                {{ $errors->first('login') }}
            </div>
        @endif

        <div class="mt-4">
            <button type="submit" class="btn btn-login w-100">登入</button>
        </div>
    </form>

    <div class="login-footer">
        © {{ date('Y') }} 麗誠OP系統
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
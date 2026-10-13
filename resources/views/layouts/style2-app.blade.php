<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>麗誠OP系統</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/budai.css') }}">
    @stack('styles')

    <style>
        :root {
            --sidebar-bg: #111827;
            --sidebar-hover: #1f2937;
            --sidebar-text: #e5e7eb;
            --sidebar-muted: #9ca3af;
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --page-bg: #f3f6fb;
            --card-bg: #ffffff;
            --border-color: #e5e7eb;
            --shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
            --radius: 16px;
        }

        * {
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            background: var(--page-bg);
            color: #1f2937;
            font-family: "Segoe UI", "Microsoft JhengHei", "PingFang TC", sans-serif;
        }

        .topbar {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 0.75rem 1.5rem;
        }

        .navbar {
            padding: 0;
            background: transparent !important;
        }

        .brand-area {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-right: 28px;
        }

        .brand-logo {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 18px;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.35);
        }

        .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }

        .brand-text .title {
            color: #ffffff;
            font-size: 1.1rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin: 0;
        }

        .brand-text .subtitle {
            color: #94a3b8;
            font-size: 0.8rem;
            margin-top: 3px;
        }

        .navbar-nav .nav-item {
            margin-right: 8px;
        }

        .navbar-nav .nav-link {
            color: var(--sidebar-text) !important;
            font-weight: 500;
            padding: 10px 16px !important;
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .show > .nav-link {
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff !important;
        }

        .dropdown-menu {
            border: 1px solid rgba(226, 232, 240, 0.9);
            border-radius: 14px;
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.12);
            padding: 10px;
            min-width: 220px;
            margin-top: 10px;
        }

        .dropdown-item {
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 0.95rem;
            color: #334155;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background: #eff6ff;
            color: var(--primary);
        }

        .page-wrapper {
            padding: 24px;
        }

        .content-shell {
            background: var(--card-bg);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 28px;
            min-height: calc(100vh - 120px);
            border: 1px solid rgba(229, 231, 235, 0.8);
        }

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border-color);
        }

        .page-header-left h1 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
        }

        .page-header-left p {
            margin: 6px 0 0;
            color: #64748b;
            font-size: 0.95rem;
        }

        .system-badge {
            display: inline-flex;
            align-items: center;
            padding: 8px 14px;
            background: #eff6ff;
            color: var(--primary);
            border-radius: 999px;
            font-size: 0.88rem;
            font-weight: 600;
        }

        .content {
            width: 100%;
        }

        .card,
        .table,
        .form-control,
        .form-select,
        .btn {
            border-radius: 12px !important;
        }

        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            border-color: var(--primary-hover);
        }

        .table {
            overflow: hidden;
            background: #fff;
        }

        .table thead th {
            background: #f8fafc;
            border-top: none;
            color: #334155;
            font-weight: 700;
        }

        .form-control:focus,
        .custom-select:focus,
        .btn:focus {
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.15);
            border-color: #93c5fd;
        }

        .navbar-toggler {
            border: none;
            background: rgba(255, 255, 255, 0.08);
            padding: 8px 10px;
            border-radius: 10px;
        }

        .navbar-toggler:focus {
            outline: none;
            box-shadow: none;
        }

        @media (max-width: 991.98px) {
            .topbar {
                padding: 1rem;
            }

            .brand-area {
                margin-bottom: 12px;
            }

            .navbar-nav .nav-item {
                margin-right: 0;
                margin-bottom: 6px;
            }

            .page-wrapper {
                padding: 16px;
            }

            .content-shell {
                padding: 18px;
                min-height: auto;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
        }
    </style>
</head>
<body>

    <div class="topbar">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="brand-area">
                <div class="brand-logo">OP</div>
                <div class="brand-text">
                    <div class="title">麗誠 OP 系統</div>
                    <div class="subtitle">Professional Operation Management System</div>
                </div>
            </div>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="切換導覽">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="menuCreate" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            建檔
                        </a>
                        <div class="dropdown-menu" aria-labelledby="menuCreate">
                            <a class="dropdown-item" href="{{ route('group.index') }}">團體</a>
                            <a class="dropdown-item" href="{{ route('ticket.index') }}">純票務</a>
                            <a class="dropdown-item" href="{{ route('visaonly.index') }}">純證件</a>
                            <a class="dropdown-item" href="{{ route('guestbook.index') }}">交辦事項</a>
                            <a class="dropdown-item" href="{{ route('flight.index') }}">航班控位</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="menuSearch" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            找檔案
                        </a>
                        <div class="dropdown-menu" aria-labelledby="menuSearch">
                            <a class="dropdown-item" href="{{ route('ordersearch.index') }}">檔案搜尋</a>
                            <a class="dropdown-item" href="{{ route('visasearch.index') }}">證件查找</a>
                            <a class="dropdown-item" href="{{ route('temporder.index') }}">五吉訂單</a>
                            <a class="dropdown-item" href="{{ route('temporder2.index') }}">業者訂單</a>
                            <a class="dropdown-item" href="{{ route('chotelorder.index') }}">控房</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="menuInfo" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            資訊列表
                        </a>
                        <div class="dropdown-menu" aria-labelledby="menuInfo">
                            <a class="dropdown-item" href="{{ route('budai.index') }}">船控明細</a>
                            <a class="dropdown-item" href="{{ route('buslist.index') }}">接駁明細</a>
                            <a class="dropdown-item" href="{{ route('longdistance.index') }}">接駁名單</a>
                            <a class="dropdown-item" href="{{ route('shortdistance.index') }}">接駁名單(嘉)</a>
                            <a class="dropdown-item" href="{{ route('shortdistance2.index') }}">接駁名單(新)</a>
                            <a class="dropdown-item" href="{{ route('hotelorderlist.index') }}">訂房單列表</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="menuFinance" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            帳務
                        </a>
                        <div class="dropdown-menu" aria-labelledby="menuFinance">
                            <a class="dropdown-item" href="{{ route('finalpay.index', ['check' => 0]) }}">團體尾款</a>
                            <a class="dropdown-item" href="{{ route('finalpay.index', ['check' => 2]) }}">票務尾款</a>
                            <a class="dropdown-item" href="{{ route('mbill.index') }}">月結票務</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="menuSystem" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            系統管理
                        </a>
                        <div class="dropdown-menu" aria-labelledby="menuSystem">
                            <a class="dropdown-item" href="{{ route('schedulema.index') }}">證件進度</a>
                            <a class="dropdown-item" href="{{ route('location.index') }}">地點管理</a>
                            <a class="dropdown-item" href="{{ route('trafficma.index') }}">交通管理</a>
                            <a class="dropdown-item" href="{{ route('localts.index') }}">接待社</a>
                            <a class="dropdown-item" href="{{ route('accountsma.index') }}">帳款項目</a>
                            <a class="dropdown-item" href="{{ route('hotellist.index') }}">飯店管理</a>
                            <a class="dropdown-item" href="{{ route('carinfo.index') }}">接駁車文字</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                登出系統
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>

                <div class="ml-auto d-none d-lg-block">
                    <span class="system-badge">企業營運後台</span>
                </div>
            </div>
        </nav>
    </div>

    <div class="page-wrapper">
        <div class="content-shell">
            <div class="page-header">
                <div class="page-header-left">
                    <h1>營運管理平台</h1>
                    <p>整合建檔、查詢、帳務與系統管理功能</p>
                </div>
                <div class="system-badge">Modern Admin UI</div>
            </div>

            <div class="content">
                @yield('content')
            </div>
        </div>
    </div>

</body>
</html>
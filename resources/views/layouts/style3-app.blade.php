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
            --sidebar-width: 260px;
            --sidebar-bg: #0f172a;
            --sidebar-bg-2: #111827;
            --sidebar-text: #cbd5e1;
            --sidebar-title: #ffffff;
            --sidebar-hover: rgba(255, 255, 255, 0.08);
            --sidebar-active: linear-gradient(135deg, #2563eb, #1d4ed8);
            --main-bg: #f1f5f9;
            --topbar-bg: #ffffff;
            --card-bg: #ffffff;
            --text-main: #0f172a;
            --text-sub: #64748b;
            --border-color: #e2e8f0;
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
            font-family: "Segoe UI", "Microsoft JhengHei", "PingFang TC", sans-serif;
            background: var(--main-bg);
            color: var(--text-main);
        }

        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--sidebar-bg) 0%, var(--sidebar-bg-2) 100%);
            color: var(--sidebar-text);
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            overflow-y: auto;
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.08);
            z-index: 1030;
        }

        .sidebar-header {
            padding: 24px 20px 18px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .brand-box {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .brand-logo {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 18px;
            font-weight: 700;
            box-shadow: 0 10px 24px rgba(37, 99, 235, 0.35);
            flex-shrink: 0;
        }

        .brand-text h1 {
            margin: 0;
            font-size: 1.1rem;
            color: var(--sidebar-title);
            font-weight: 700;
        }

        .brand-text p {
            margin: 4px 0 0;
            font-size: 0.82rem;
            color: #94a3b8;
        }

        .sidebar-section {
            padding: 18px 14px 10px;
        }

        .sidebar-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: #64748b;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 0 12px;
            margin-bottom: 10px;
        }

        .sidebar .nav-link {
            color: var(--sidebar-text);
            border-radius: 12px;
            padding: 12px 14px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link[aria-expanded="true"] {
            background: var(--sidebar-hover);
            color: #ffffff;
        }

        .sidebar .nav-link.dropdown-toggle::after {
            float: right;
            margin-top: 10px;
        }

        .sidebar .submenu {
            padding-left: 8px;
            margin-top: 8px;
            margin-bottom: 10px;
        }

        .sidebar .submenu a {
            display: block;
            text-decoration: none;
            color: #aeb9c9;
            padding: 10px 14px;
            margin-bottom: 6px;
            border-radius: 10px;
            font-size: 0.94rem;
            transition: all 0.2s ease;
        }

        .sidebar .submenu a:hover {
            background: rgba(37, 99, 235, 0.14);
            color: #ffffff;
            text-decoration: none;
        }

        .sidebar-footer {
            padding: 18px 20px 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            margin-top: 14px;
        }

        .logout-btn {
            display: block;
            width: 100%;
            text-align: center;
            background: rgba(239, 68, 68, 0.12);
            color: #fca5a5;
            padding: 12px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.2);
            color: #ffffff;
            text-decoration: none;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
        }

        .topbar {
            background: var(--topbar-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 18px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        .topbar-left h2 {
            margin: 0;
            font-size: 1.45rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .topbar-left p {
            margin: 4px 0 0;
            color: var(--text-sub);
            font-size: 0.92rem;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 8px 14px;
            border-radius: 999px;
            background: #eff6ff;
            color: #2563eb;
            font-size: 0.88rem;
            font-weight: 700;
        }

        .mobile-menu-btn {
            display: none;
            background: #e2e8f0;
            border: none;
            border-radius: 10px;
            padding: 8px 12px;
            font-weight: 600;
        }

        .page-content {
            padding: 28px;
        }

        .content-card {
            background: var(--card-bg);
            border-radius: 20px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(226, 232, 240, 0.9);
            padding: 28px;
            min-height: calc(100vh - 150px);
        }

        .card,
        .table,
        .form-control,
        .custom-select,
        .btn {
            border-radius: 12px !important;
        }

        .table {
            background: #fff;
            overflow: hidden;
        }

        .table thead th {
            background: #f8fafc;
            border-top: none;
            color: #334155;
            font-weight: 700;
        }

        .form-control,
        .custom-select {
            border-color: #dbe2ea;
            min-height: 42px;
        }

        .form-control:focus,
        .custom-select:focus,
        .btn:focus {
            border-color: #93c5fd;
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.14);
        }

        .btn-primary {
            background: #2563eb;
            border-color: #2563eb;
        }

        .btn-primary:hover {
            background: #1d4ed8;
            border-color: #1d4ed8;
        }

        .sidebar-backdrop {
            display: none;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.25s ease;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .mobile-menu-btn {
                display: inline-block;
            }

            .page-content {
                padding: 16px;
            }

            .content-card {
                padding: 18px;
                min-height: auto;
            }

            .topbar {
                padding: 14px 16px;
            }

            .topbar-left h2 {
                font-size: 1.15rem;
            }

            .topbar-left p {
                font-size: 0.84rem;
            }

            .status-badge {
                display: none;
            }

            .sidebar-backdrop {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(15, 23, 42, 0.45);
                z-index: 1025;
            }

            .sidebar-backdrop.show {
                display: block;
            }
        }
    </style>
</head>
<body>
    <div class="admin-layout">

        <aside class="sidebar" id="sidebarMenu">
            <div class="sidebar-header">
                <div class="brand-box">
                    <div class="brand-logo">OP</div>
                    <div class="brand-text">
                        <h1>麗誠 OP 系統</h1>
                        <p>Operation Management Platform</p>
                    </div>
                </div>
            </div>

            <div class="sidebar-section">
                <div class="sidebar-label">功能選單</div>

                <ul class="nav flex-column">

                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle" data-toggle="collapse" href="#menuCreate" role="button" aria-expanded="false">
                            建檔管理
                        </a>
                        <div class="collapse submenu" id="menuCreate">
                            <a href="{{ route('group.index') }}">團體</a>
                            <a href="{{ route('ticket.index') }}">純票務</a>
                            <a href="{{ route('visaonly.index') }}">純證件</a>
                            <a href="{{ route('guestbook.index') }}">交辦事項</a>
                            <a href="{{ route('flight.index') }}">航班控位</a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle" data-toggle="collapse" href="#menuSearch" role="button" aria-expanded="false">
                            檔案查詢
                        </a>
                        <div class="collapse submenu" id="menuSearch">
                            <a href="{{ route('ordersearch.index') }}">檔案搜尋</a>
                            <a href="{{ route('visasearch.index') }}">證件查找</a>
                            <a href="{{ route('temporder.index') }}">五吉訂單</a>
                            <a href="{{ route('temporder2.index') }}">業者訂單</a>
                            <a href="{{ route('chotelorder.index') }}">控房</a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle" data-toggle="collapse" href="#menuInfo" role="button" aria-expanded="false">
                            資訊列表
                        </a>
                        <div class="collapse submenu" id="menuInfo">
                            <a href="{{ route('budai.index') }}">船控明細</a>
                            <a href="{{ route('buslist.index') }}">接駁明細</a>
                            <a href="{{ route('longdistance.index') }}">接駁名單</a>
                            <a href="{{ route('shortdistance.index') }}">接駁名單(嘉)</a>
                            <a href="{{ route('shortdistance2.index') }}">接駁名單(新)</a>
                            <a href="{{ route('hotelorderlist.index') }}">訂房單列表</a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle" data-toggle="collapse" href="#menuFinance" role="button" aria-expanded="false">
                            帳務管理
                        </a>
                        <div class="collapse submenu" id="menuFinance">
                            <a href="{{ route('finalpay.index', ['check' => 0]) }}">團體尾款</a>
                            <a href="{{ route('finalpay.index', ['check' => 2]) }}">票務尾款</a>
                            <a href="{{ route('mbill.index') }}">月結票務</a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle" data-toggle="collapse" href="#menuSystem" role="button" aria-expanded="false">
                            系統管理
                        </a>
                        <div class="collapse submenu" id="menuSystem">
                            <a href="{{ route('schedulema.index') }}">證件進度</a>
                            <a href="{{ route('location.index') }}">地點管理</a>
                            <a href="{{ route('trafficma.index') }}">交通管理</a>
                            <a href="{{ route('localts.index') }}">接待社</a>
                            <a href="{{ route('accountsma.index') }}">帳款項目</a>
                            <a href="{{ route('hotellist.index') }}">飯店管理</a>
                            <a href="{{ route('carinfo.index') }}">接駁車文字</a>
                        </div>
                    </li>

                </ul>
            </div>

            <div class="sidebar-footer">
                <a href="#" class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    登出系統
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                    @csrf
                </form>
            </div>
        </aside>

        <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

        <main class="main-content">
            <div class="topbar">
                <div class="topbar-left">
                    <h2>營運管理後台</h2>
                    <p>整合建檔、查詢、帳務與系統設定的一站式管理平台</p>
                </div>
                <div class="topbar-right">
                    <span class="status-badge">Professional Admin System</span>
                    <button type="button" class="mobile-menu-btn" id="mobileMenuBtn">選單</button>
                </div>
            </div>

            <div class="page-content">
                <div class="content-card">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var mobileMenuBtn = document.getElementById('mobileMenuBtn');
            var sidebarMenu = document.getElementById('sidebarMenu');
            var sidebarBackdrop = document.getElementById('sidebarBackdrop');

            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', function () {
                    sidebarMenu.classList.toggle('show');
                    sidebarBackdrop.classList.toggle('show');
                });
            }

            if (sidebarBackdrop) {
                sidebarBackdrop.addEventListener('click', function () {
                    sidebarMenu.classList.remove('show');
                    sidebarBackdrop.classList.remove('show');
                });
            }
        });
    </script>
</body>
</html>
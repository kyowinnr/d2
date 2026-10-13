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
            --sidebar-width: 270px;

            --bg-main: #d0d0d0;
            --bg-panel: #f4f6f8;
            --bg-panel-2: #eef1f4;
            --bg-topbar: #f8f9fb;
            --bg-card: #ffffff;
            --bg-card-soft: #f3f5f7;
            --bg-hover: #e8edf3;

            --text-main: #1f2937;
            --text-soft: #5f6b7a;
            --text-muted: #7a8796;

            --border-color: #c3cad3;
            --border-light: #d2d8df;

            --primary: #4f8cff;
            --primary-hover: #3f79e6;
            --primary-soft: rgba(79, 140, 255, 0.12);

            --success: #2dad7a;
            --danger: #d96c6c;
            --warning: #d8a34d;

            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --radius-lg: 18px;
            --radius-md: 12px;
            --radius-sm: 10px;
        }

        * {
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            background: var(--bg-main);
            color: var(--text-main);
            font-family: "Segoe UI", "Microsoft JhengHei", "PingFang TC", sans-serif;
            font-size: 14px;
        }

        a {
            transition: all .2s ease;
        }

        .admin-layout {
            display: flex;
            min-height: 100vh;
            background: var(--bg-main);
        }

        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #2e3a48 0%, #374454 100%);
            border-right: 1px solid #49576a;
            position: fixed;
            inset: 0 auto 0 0;
            overflow-y: auto;
            z-index: 1040;
            box-shadow: 6px 0 28px rgba(0, 0, 0, 0.12);
        }

        .sidebar-header {
            padding: 22px 18px 18px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .brand-box {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .brand-logo {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            background: linear-gradient(135deg, #5a8ff3, #84b0ff);
            color: #fff;
            font-weight: 700;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(79, 140, 255, 0.22);
            flex-shrink: 0;
        }

        .brand-text h1 {
            margin: 0;
            font-size: 1.08rem;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: 0.3px;
        }

        .brand-text p {
            margin: 4px 0 0;
            font-size: 0.82rem;
            color: #c8d2dc;
        }

        .system-info {
            margin-top: 16px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.10);
            border-radius: 14px;
            padding: 12px 14px;
        }

        .system-info .label {
            font-size: 0.74rem;
            color: #d4dce5;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }

        .system-info .value {
            font-size: 0.95rem;
            color: #ffffff;
            font-weight: 600;
        }

        .sidebar-section {
            padding: 16px 14px 12px;
        }

        .sidebar-label {
            padding: 0 10px;
            margin-bottom: 10px;
            color: #d5dde6;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .sidebar .nav-link {
            color: #edf3fa;
            border-radius: 12px;
            padding: 12px 14px;
            font-weight: 600;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: transparent;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link[aria-expanded="true"] {
            background: rgba(255,255,255,0.12);
            color: #ffffff;
            text-decoration: none;
        }

        .sidebar .submenu {
            padding: 8px 0 4px 8px;
        }

        .sidebar .submenu a {
            display: block;
            color: #e5ecf4;
            text-decoration: none;
            padding: 10px 14px;
            border-radius: 10px;
            margin-bottom: 6px;
            font-size: 0.92rem;
            border: 1px solid transparent;
        }

        .sidebar .submenu a:hover {
            background: rgba(255,255,255,0.10);
            border-color: rgba(255,255,255,0.08);
            color: #ffffff;
            text-decoration: none;
        }

        .sidebar-footer {
            padding: 16px 18px 24px;
            border-top: 1px solid rgba(255,255,255,0.08);
            margin-top: 10px;
        }

        .logout-btn {
            display: block;
            width: 100%;
            padding: 12px 14px;
            border-radius: 12px;
            text-align: center;
            text-decoration: none;
            font-weight: 700;
            color: #ffe0e0;
            background: rgba(224, 127, 127, 0.16);
            border: 1px solid rgba(224, 127, 127, 0.22);
        }

        .logout-btn:hover {
            color: #fff;
            background: rgba(224, 127, 127, 0.24);
            text-decoration: none;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            background: linear-gradient(180deg, #d0d0d0 0%, #dadada 100%);
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 1030;
            background: rgba(248, 249, 251, 0.94);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #c8cfd8;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .erp-badge {
            display: inline-flex;
            align-items: center;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(79, 140, 255, 0.10);
            border: 1px solid rgba(79, 140, 255, 0.16);
            color: #2f5fae;
            font-size: 0.86rem;
            font-weight: 700;
        }

        .mobile-menu-btn {
            display: none;
            border: 1px solid #c3cad3;
            background: #ffffff;
            color: #1f2937;
            border-radius: 10px;
            padding: 8px 12px;
            font-weight: 700;
        }

        .page-content {
            padding: 24px;
        }

        .content-card {
            background: linear-gradient(180deg, #ffffff 0%, #f7f8fa 100%);
            border: 1px solid var(--border-color);
            border-radius: 22px;
            box-shadow: var(--shadow);
            padding: 26px;
            min-height: calc(100vh - 110px);
        }

        .card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg) !important;
            box-shadow: none;
            color: var(--text-main);
        }

        .table {
            background: transparent;
            color: var(--text-main);
            border-radius: 14px !important;
            overflow: hidden;
        }

        .table thead th {
            background: #eef2f6;
            color: #243142;
            border-top: none !important;
            border-bottom: 1px solid var(--border-light) !important;
            font-weight: 700;
        }

        .table td,
        .table th {
            border-color: #d7dde4 !important;
            vertical-align: middle;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0,0,0,0.015);
        }

        .form-control,
        .custom-select,
        select,
        textarea {
            background-color: #ffffff !important;
            border: 1px solid #c8cfd8 !important;
            color: #1f2937 !important;
            border-radius: 12px !important;
            min-height: 42px;
        }

        .form-control::placeholder,
        textarea::placeholder {
            color: #8a97a6 !important;
        }

        .form-control:focus,
        .custom-select:focus,
        select:focus,
        textarea:focus {
            background-color: #ffffff !important;
            color: #1f2937 !important;
            border-color: #6ea0ff !important;
            box-shadow: 0 0 0 0.18rem rgba(110, 160, 255, 0.16) !important;
        }

        .btn {
            border-radius: 12px !important;
            font-weight: 700;
            padding: 9px 16px;
        }

        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            border-color: var(--primary-hover);
        }

        .btn-secondary {
            background: #7c8794;
            border-color: #7c8794;
            color: #ffffff;
        }

        .btn-secondary:hover {
            background: #6f7a87;
            border-color: #6f7a87;
        }

        .btn-success {
            background: var(--success);
            border-color: var(--success);
        }

        .btn-danger {
            background: var(--danger);
            border-color: var(--danger);
        }

        .alert {
            border-radius: 14px;
            border: none;
        }

        .dropdown-menu {
            background: #ffffff;
            border: 1px solid #d0d7df;
            border-radius: 14px;
            box-shadow: 0 18px 40px rgba(0,0,0,0.10);
            padding: 8px;
        }

        .dropdown-item {
            color: #223042;
            border-radius: 10px;
            padding: 10px 12px;
        }

        .dropdown-item:hover {
            background: #edf3fb;
            color: #1e4e99;
        }

        .badge {
            border-radius: 999px;
            padding: 6px 10px;
            font-weight: 700;
        }

        hr {
            border-color: var(--border-color);
        }

        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #e1e1e1;
        }

        ::-webkit-scrollbar-thumb {
            background: #a7b0bb;
            border-radius: 999px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #8d98a5;
        }

        .sidebar-backdrop {
            display: none;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform .25s ease;
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

            .erp-badge {
                display: none;
            }

            .page-content {
                padding: 14px;
            }

            .content-card {
                padding: 18px;
                min-height: auto;
            }

            .topbar {
                padding: 14px 16px;
            }

            .sidebar-backdrop {
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.25);
                z-index: 1035;
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
                        <p>Enterprise Resource Platform</p>
                    </div>
                </div>

                <div class="system-info">
                    <div class="label">系統模式</div>
                    <div class="value">企業 ERP 介面</div>
                </div>
            </div>

            <div class="sidebar-section">
                <div class="sidebar-label">主功能</div>

                <ul class="nav flex-column">

                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle" data-toggle="collapse" href="#menuCreate" role="button" aria-expanded="false">
                            <span>建檔管理</span>
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
                            <span>檔案查詢</span>
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
                            <span>資訊列表</span>
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
                            <span>帳務管理</span>
                        </a>
                        <div class="collapse submenu" id="menuFinance">
                            <a href="{{ route('finalpay.index', ['check' => 0]) }}">團體尾款</a>
                            <a href="{{ route('finalpay.index', ['check' => 2]) }}">票務尾款</a>
                            <a href="{{ route('mbill.index') }}">月結票務</a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle" data-toggle="collapse" href="#menuSystem" role="button" aria-expanded="false">
                            <span>系統管理</span>
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
                <div class="topbar-right">
                    <span class="erp-badge">Enterprise ERP UI</span>
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
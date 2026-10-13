<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>麗誠OP系統</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/budai.css') }}">
    @stack('styles')

    <style>
        :root {
            --bg-main: #d0d0d0;
            --bg-main-soft: #dddddd;
            --bg-topbar: #f8f9fb;
            --bg-card: #ffffff;
            --bg-card-soft: #f4f6f8;
            --bg-hover: #eef3f8;

            --nav-bg-1: #2f3b49;
            --nav-bg-2: #374455;
            --nav-hover: rgba(255,255,255,0.10);

            --text-main: #1f2937;
            --text-soft: #5f6b7a;
            --text-muted: #7f8a97;
            --text-white: #ffffff;

            --border-color: #c8d0d8;
            --border-soft: #dde3e8;

            --primary: #4f8cff;
            --primary-hover: #3d79e8;
            --primary-soft: rgba(79, 140, 255, 0.12);

            --success: #24b47e;
            --warning: #e4a93b;
            --danger: #d96b6b;
            --info: #4aa3c9;

            --shadow: 0 10px 25px rgba(0,0,0,0.08);
            --radius-lg: 20px;
            --radius-md: 14px;
            --radius-sm: 10px;
        }

        * {
            box-sizing: border-box;
        }

        html, body {
            min-height: 100%;
        }

        body {
            margin: 0;
            font-family: "Segoe UI", "Microsoft JhengHei", "PingFang TC", sans-serif;
            background: linear-gradient(180deg, var(--bg-main) 0%, var(--bg-main-soft) 100%);
            color: var(--text-main);
            font-size: 14px;
        }

        a {
            transition: all .2s ease;
        }

        .top-navbar {
            position: sticky;
            top: 0;
            z-index: 1050;
            background: linear-gradient(90deg, var(--nav-bg-1) 0%, var(--nav-bg-2) 100%);
            border-bottom: 1px solid rgba(255,255,255,0.08);
            box-shadow: 0 6px 18px rgba(0,0,0,0.10);
        }

        .top-navbar .navbar {
            padding: 10px 18px;
        }

        .brand-box {
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none !important;
        }

        .brand-logo {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            background: linear-gradient(135deg, #5a8ff3, #8ab5ff);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 17px;
            font-weight: 700;
            box-shadow: 0 10px 20px rgba(79, 140, 255, 0.25);
            flex-shrink: 0;
        }

        .brand-text h1 {
            margin: 0;
            color: #fff;
            font-size: 1.06rem;
            font-weight: 700;
            line-height: 1.1;
        }

        .brand-text p {
            margin: 4px 0 0;
            color: #ced7e0;
            font-size: 0.82rem;
            line-height: 1.1;
        }

        .navbar-toggler {
            border: 1px solid rgba(255,255,255,0.22);
            background: rgba(255,255,255,0.08);
            border-radius: 10px;
            padding: 7px 11px;
            color: #fff;
        }

        .navbar-toggler:focus {
            outline: none;
            box-shadow: none;
        }

        .top-navbar .navbar-nav {
            align-items: center;
        }

        .top-navbar .nav-item {
            margin: 0 4px;
        }

        .top-navbar .nav-link {
            color: #eef4fb !important;
            border-radius: 12px;
            padding: 10px 14px !important;
            font-weight: 600;
            font-size: 0.93rem;
            display: flex;
            align-items: center;
            gap: 9px;
            white-space: nowrap;
        }

        .top-navbar .nav-link:hover,
        .top-navbar .nav-link:focus,
        .top-navbar .show > .nav-link {
            background: var(--nav-hover);
            color: #fff !important;
        }

        .top-navbar .nav-link i {
            width: 16px;
            text-align: center;
            font-size: 0.9rem;
        }

        .system-badge {
            display: inline-flex;
            align-items: center;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(255,255,255,0.10);
            border: 1px solid rgba(255,255,255,0.10);
            color: #f3f7fb;
            font-size: 0.86rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .system-badge i {
            margin-right: 8px;
        }

        .top-navbar .dropdown-menu {
            background: #ffffff;
            border: 1px solid #d0d7df;
            border-radius: 14px;
            box-shadow: 0 18px 40px rgba(0,0,0,0.10);
            padding: 8px;
            min-width: 220px;
            margin-top: 10px;
        }

        .top-navbar .dropdown-item {
            color: #223042;
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 0.92rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .top-navbar .dropdown-item i {
            width: 16px;
            text-align: center;
            font-size: 0.85rem;
            color: #526070;
        }

        .top-navbar .dropdown-item:hover {
            background: #edf3fb;
            color: #1e4e99;
            text-decoration: none;
        }

        .top-navbar .dropdown-divider {
            margin: 8px 0;
            border-top: 1px solid #e5eaf0;
        }

        .nav-right-tools {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: 16px;
        }

        .logout-btn-top {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none !important;
            padding: 10px 14px;
            border-radius: 12px;
            font-weight: 700;
            background: rgba(217, 107, 107, 0.18);
            border: 1px solid rgba(217, 107, 107, 0.24);
            color: #fff0f0 !important;
            white-space: nowrap;
        }

        .logout-btn-top:hover {
            color: #ffffff !important;
            background: rgba(217, 107, 107, 0.28);
        }

        .main-content {
            width: 100%;
            min-height: calc(100vh - 72px);
        }

        .page-content {
            padding: 24px;
        }

        .content-card {
            background: linear-gradient(180deg, #ffffff 0%, #f7f8fa 100%);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            padding: 24px;
            min-height: calc(100vh - 130px);
        }

        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 22px;
        }

        .kpi-card {
            background: #ffffff;
            border: 1px solid var(--border-soft);
            border-radius: 18px;
            padding: 18px;
            box-shadow: 0 8px 18px rgba(0,0,0,0.04);
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 112px;
        }

        .kpi-left small {
            display: block;
            font-size: 0.85rem;
            color: var(--text-soft);
            margin-bottom: 8px;
            font-weight: 600;
        }

        .kpi-left h3 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .kpi-left .kpi-trend {
            margin-top: 8px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .kpi-trend.up { color: var(--success); }
        .kpi-trend.warn { color: var(--warning); }
        .kpi-trend.down { color: var(--danger); }

        .kpi-icon {
            width: 54px;
            height: 54px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            background: var(--primary-soft);
            color: var(--primary);
            flex-shrink: 0;
        }

        .kpi-card.success .kpi-icon {
            background: rgba(36, 180, 126, 0.12);
            color: var(--success);
        }

        .kpi-card.warning .kpi-icon {
            background: rgba(228, 169, 59, 0.14);
            color: var(--warning);
        }

        .kpi-card.danger .kpi-icon {
            background: rgba(217, 107, 107, 0.14);
            color: var(--danger);
        }

        .section-card {
            background: #fff;
            border: 1px solid var(--border-soft);
            border-radius: 18px;
            box-shadow: 0 8px 18px rgba(0,0,0,0.04);
            margin-bottom: 20px;
            overflow: hidden;
        }

        .section-header {
            padding: 18px 20px;
            border-bottom: 1px solid var(--border-soft);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .section-title h3 {
            margin: 0;
            font-size: 1.08rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .section-title p {
            margin: 6px 0 0;
            color: var(--text-soft);
            font-size: 0.88rem;
        }

        .table-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-soft);
            background: #fafbfd;
        }

        .table-toolbar-left,
        .table-toolbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .table-search {
            position: relative;
            min-width: 260px;
        }

        .table-search i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #8a97a6;
        }

        .table-search input {
            padding-left: 36px !important;
        }

        .table-responsive {
            margin: 0;
        }

        .erp-table {
            width: 100%;
            margin-bottom: 0;
            color: var(--text-main);
            background: #fff;
        }

        .erp-table thead th {
            background: #eef2f6;
            color: #243142;
            border-top: none !important;
            border-bottom: 1px solid var(--border-soft) !important;
            font-weight: 700;
            white-space: nowrap;
            cursor: pointer;
            user-select: none;
            position: relative;
        }

        .erp-table thead th.sortable:hover {
            background: #e7edf5;
        }

        .erp-table th,
        .erp-table td {
            padding: 14px 16px;
            border-color: #e0e6eb !important;
            vertical-align: middle;
        }

        .erp-table tbody tr:hover {
            background: #f8fbff;
        }

        .sort-indicator {
            margin-left: 8px;
            font-size: 0.78rem;
            color: #7c8794;
        }

        .erp-pagination {
            padding: 16px 20px;
            border-top: 1px solid var(--border-soft);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            background: #fff;
        }

        .erp-pagination-info {
            color: var(--text-soft);
            font-size: 0.9rem;
            font-weight: 600;
        }

        .erp-pagination-controls {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .erp-page-btn {
            min-width: 38px;
            height: 38px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            background: #fff;
            color: var(--text-main);
            font-weight: 700;
        }

        .erp-page-btn.active {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }

        .erp-page-btn:disabled {
            opacity: .45;
            cursor: not-allowed;
        }

        .card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 18px !important;
            box-shadow: none;
            color: var(--text-main);
        }

        .form-control,
        .custom-select,
        select,
        textarea {
            background-color: #ffffff !important;
            border: 1px solid #cfd6dd !important;
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
            box-shadow: 0 0 0 0.18rem rgba(110, 160, 255, 0.15) !important;
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

        .btn-light {
            background: #fff;
            border-color: #d7dde4;
            color: #334155;
        }

        .btn-light:hover {
            background: #f5f7fa;
            border-color: #cfd6dd;
            color: #1f2937;
        }

        .badge {
            border-radius: 999px;
            padding: 6px 10px;
            font-weight: 700;
        }

        .badge-primary-soft {
            background: rgba(79, 140, 255, 0.12);
            color: #2e61b8;
        }

        .badge-success-soft {
            background: rgba(36, 180, 126, 0.12);
            color: #1f8b62;
        }

        .badge-warning-soft {
            background: rgba(228, 169, 59, 0.16);
            color: #a77916;
        }

        .badge-danger-soft {
            background: rgba(217, 107, 107, 0.14);
            color: #b24f4f;
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

        @media (max-width: 1399.98px) {
            .top-navbar .nav-link {
                padding: 9px 11px !important;
                font-size: 0.88rem;
            }

            .nav-right-tools {
                margin-left: 8px;
            }

            .system-badge {
                display: none;
            }
        }

        @media (max-width: 1199.98px) {
            .kpi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 991.98px) {
            .top-navbar .navbar {
                padding: 10px 14px;
            }

            .top-navbar .navbar-collapse {
                margin-top: 12px;
                padding-top: 12px;
                border-top: 1px solid rgba(255,255,255,0.10);
            }

            .top-navbar .navbar-nav {
                align-items: stretch;
            }

            .top-navbar .nav-item {
                margin: 0 0 6px 0;
            }

            .top-navbar .nav-link {
                justify-content: flex-start;
            }

            .top-navbar .dropdown-menu {
                box-shadow: none;
                border-radius: 12px;
                margin-top: 6px;
            }

            .nav-right-tools {
                flex-direction: column;
                align-items: stretch;
                margin-left: 0;
                margin-top: 8px;
                gap: 8px;
            }

            .logout-btn-top {
                justify-content: center;
            }

            .page-content {
                padding: 14px;
            }

            .content-card {
                padding: 16px;
                min-height: auto;
            }
        }

        @media (max-width: 767.98px) {
            .kpi-grid {
                grid-template-columns: 1fr;
            }

            .table-search {
                min-width: 100%;
            }

            .brand-text p {
                display: none;
            }
        }
    </style>
</head>
<body>
    <header class="top-navbar">
        <nav class="navbar navbar-expand-lg">
            <a href="{{ route('dashboard') }}" class="brand-box">
                <div class="brand-logo">OP</div>
                <div class="brand-text">
                    <h1>麗誠 OP 系統</h1>
                    <p>Enterprise Resource Platform</p>
                </div>
            </a>

            <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#topMenu" aria-controls="topMenu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="topMenu">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="menuCreate" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-folder-plus"></i>
                            <span>建檔管理</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="menuCreate">
                            <a class="dropdown-item" href="{{ route('group.index') }}"><i class="fas fa-users"></i>團體</a>
                            <a class="dropdown-item" href="{{ route('ticket.index') }}"><i class="fas fa-ticket-alt"></i>純票務</a>
                            <a class="dropdown-item" href="{{ route('visaonly.index') }}"><i class="fas fa-id-card"></i>純證件</a>
                            <a class="dropdown-item" href="{{ route('guestbook.index') }}"><i class="fas fa-tasks"></i>交辦事項</a>
                            <a class="dropdown-item" href="{{ route('flight.index') }}"><i class="fas fa-plane"></i>航班控位</a>
                            <a class="dropdown-item" href="{{ route('customer_inquiries.index') }}"><i class="fas fa-tasks"></i>團體詢問紀錄</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="menuSearch" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search"></i>
                            <span>檔案查詢</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="menuSearch">
                            <a class="dropdown-item" href="{{ route('ordersearch.index') }}"><i class="fas fa-folder-open"></i>檔案搜尋</a>
                            <a class="dropdown-item" href="{{ route('visasearch.index') }}"><i class="fas fa-passport"></i>證件查找</a>
                            <a class="dropdown-item" href="{{ route('temporder.index') }}"><i class="fas fa-file-invoice"></i>五吉訂單</a>
                            <a class="dropdown-item" href="{{ route('temporder2.index') }}"><i class="fas fa-briefcase"></i>業者訂單</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="menuInfo" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-list-alt"></i>
                            <span>資訊列表</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="menuInfo">
                            <a class="dropdown-item" href="{{ route('budai.index') }}"><i class="fas fa-ship"></i>船控明細</a>
                            <a class="dropdown-item" href="{{ route('buslist.index') }}"><i class="fas fa-bus"></i>接駁明細</a>
                            <a class="dropdown-item" href="{{ route('longdistance.index') }}"><i class="fas fa-clipboard-list"></i>接駁名單</a>
                            <a class="dropdown-item" href="{{ route('shortdistance.index') }}"><i class="fas fa-route"></i>接駁名單(嘉)</a>
                            <a class="dropdown-item" href="{{ route('shortdistance2.index') }}"><i class="fas fa-route"></i>接駁名單(新)</a>
                            <a class="dropdown-item" href="{{ route('hotelorderlist.index') }}"><i class="fas fa-hotel"></i>訂房單列表</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="menuFinance" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-calculator"></i>
                            <span>帳務管理</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="menuFinance">
                            <a class="dropdown-item" href="{{ route('finalpay.index', ['check' => 0]) }}"><i class="fas fa-coins"></i>團體尾款</a>
                            <a class="dropdown-item" href="{{ route('finalpay.index', ['check' => 2]) }}"><i class="fas fa-wallet"></i>票務尾款</a>
                            <a class="dropdown-item" href="{{ route('mbill.index') }}"><i class="fas fa-file-invoice-dollar"></i>月結票務</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="menuSystem" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-cogs"></i>
                            <span>系統管理</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="menuSystem">
                            <a class="dropdown-item" href="{{ route('schedulema.index') }}"><i class="fas fa-stream"></i>證件進度</a>
                            <a class="dropdown-item" href="{{ route('location.index') }}"><i class="fas fa-map-marker-alt"></i>地點管理</a>
                            <a class="dropdown-item" href="{{ route('trafficma.index') }}"><i class="fas fa-shuttle-van"></i>交通管理</a>
                            <a class="dropdown-item" href="{{ route('localts.index') }}"><i class="fas fa-building"></i>接待社</a>
                            <a class="dropdown-item" href="{{ route('accountsma.index') }}"><i class="fas fa-book"></i>帳款項目</a>
                            <a class="dropdown-item" href="{{ route('hotellist.index') }}"><i class="fas fa-concierge-bell"></i>飯店管理</a>
                            <a class="dropdown-item" href="{{ route('carinfo.index') }}"><i class="fas fa-car"></i>接駁車文字</a>
                            @if (session('permission') == 1)
                                <a class="dropdown-item" href="{{ route('usermanage.index') }}" ><i class="fas fa-globe"></i>使用者管理</a>
                            @endif
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="allSystem" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-globe"></i>
                            <span>全部系統</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="allSystem">
                            <a class="dropdown-item" href="https://carinfo.dmanager.mvp5-1.com/" target="_blank"><i class="fas fa-globe"></i>接駁車查詢</a>
                            <a class="dropdown-item" href="https://ticketmanager.dmanager.mvp5-1.com/index.php" target="_blank"><i class="fas fa-globe"></i>B2B</a>
                            <a class="dropdown-item" href="https://carmanager.dmanager.mvp5-1.com/" target="_blank"><i class="fas fa-globe"></i>船公司訂位</a>
                            <a class="dropdown-item" href="https://dragonins.synology.me:3710/dragonins/" target="_blank"><i class="fas fa-globe"></i>保險系統</a>
                            <a class="dropdown-item" href="https://dragonins.synology.me:3710/reserve/login.php" target="_blank"><i class="fas fa-globe"></i>控房系統</a>
                            <a class="dropdown-item" href="https://ttcda.dmanager.mvp5-1.com" target="_blank"><i class="fas fa-globe"></i>靠行系統</a>
                            @if (session('permission') == 1)
                                <a class="dropdown-item" href="https://m3.dmanager.mvp5-1.com" target="_blank"><i class="fas fa-globe"></i>麗誠行政</a>
                                <a class="dropdown-item" href="https://show.dmanager.mvp5-1.com" target="_blank"><i class="fas fa-globe"></i>錦秀行政</a>
                            @endif
                        </div>
                    </li>
                </ul>

                <div class="nav-right-tools">
                    <a href="#" class="logout-btn-top" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt mr-2"></i>登出系統
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
        @csrf
    </form>

    <main class="main-content">
        <div class="page-content">
            <div class="content-card">
                @yield('content')
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            initErpTables();
        });

        function initErpTables() {
            const tables = document.querySelectorAll('.erp-data-table');

            tables.forEach((tableWrapper) => {
                const table = tableWrapper.querySelector('table');
                if (!table) return;

                const tbody = table.querySelector('tbody');
                if (!tbody) return;

                const searchInput = tableWrapper.querySelector('.erp-search-input');
                const pageSizeSelect = tableWrapper.querySelector('.erp-page-size');
                const paginationInfo = tableWrapper.querySelector('.erp-pagination-info');
                const paginationControls = tableWrapper.querySelector('.erp-pagination-controls');
                const headers = table.querySelectorAll('thead th.sortable');

                let currentPage = 1;
                let pageSize = parseInt(pageSizeSelect ? pageSizeSelect.value : 10);
                let sortColumn = null;
                let sortDirection = 'asc';

                function getRows() {
                    return Array.from(tbody.querySelectorAll('tr'));
                }

                function getFilteredRows() {
                    const keyword = searchInput ? searchInput.value.trim().toLowerCase() : '';
                    return getRows().filter(row => {
                        const text = row.innerText.toLowerCase();
                        return text.includes(keyword);
                    });
                }

                function sortRows(rows) {
                    if (sortColumn === null) return rows;

                    return rows.sort((a, b) => {
                        const aText = a.children[sortColumn]?.innerText.trim() || '';
                        const bText = b.children[sortColumn]?.innerText.trim() || '';

                        const aNum = parseFloat(aText.replace(/[^0-9.-]/g, ''));
                        const bNum = parseFloat(bText.replace(/[^0-9.-]/g, ''));

                        let compare = 0;

                        if (!isNaN(aNum) && !isNaN(bNum) && aText !== '' && bText !== '') {
                            compare = aNum - bNum;
                        } else {
                            compare = aText.localeCompare(bText, 'zh-Hant');
                        }

                        return sortDirection === 'asc' ? compare : -compare;
                    });
                }

                function render() {
                    let rows = getFilteredRows();
                    rows = sortRows(rows);

                    const total = rows.length;
                    const totalPages = Math.max(1, Math.ceil(total / pageSize));
                    if (currentPage > totalPages) currentPage = totalPages;

                    const start = (currentPage - 1) * pageSize;
                    const end = start + pageSize;
                    const pageRows = rows.slice(start, end);

                    getRows().forEach(row => row.style.display = 'none');
                    pageRows.forEach(row => row.style.display = '');

                    if (paginationInfo) {
                        const startText = total === 0 ? 0 : start + 1;
                        const endText = Math.min(end, total);
                        paginationInfo.textContent = `顯示 ${startText} - ${endText} 筆，共 ${total} 筆`;
                    }

                    if (paginationControls) {
                        paginationControls.innerHTML = '';

                        const prevBtn = document.createElement('button');
                        prevBtn.className = 'erp-page-btn';
                        prevBtn.innerHTML = '&laquo;';
                        prevBtn.disabled = currentPage === 1;
                        prevBtn.addEventListener('click', () => {
                            currentPage--;
                            render();
                        });
                        paginationControls.appendChild(prevBtn);

                        for (let i = 1; i <= totalPages; i++) {
                            const btn = document.createElement('button');
                            btn.className = 'erp-page-btn' + (i === currentPage ? ' active' : '');
                            btn.textContent = i;
                            btn.addEventListener('click', () => {
                                currentPage = i;
                                render();
                            });
                            paginationControls.appendChild(btn);
                        }

                        const nextBtn = document.createElement('button');
                        nextBtn.className = 'erp-page-btn';
                        nextBtn.innerHTML = '&raquo;';
                        nextBtn.disabled = currentPage === totalPages || total === 0;
                        nextBtn.addEventListener('click', () => {
                            currentPage++;
                            render();
                        });
                        paginationControls.appendChild(nextBtn);
                    }

                    headers.forEach((th, i) => {
                        const indicator = th.querySelector('.sort-indicator');
                        if (!indicator) return;

                        if (sortColumn === i) {
                            indicator.textContent = sortDirection === 'asc' ? '▲' : '▼';
                        } else {
                            indicator.textContent = '⇅';
                        }
                    });
                }

                headers.forEach((th, i) => {
                    th.addEventListener('click', () => {
                        if (sortColumn === i) {
                            sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
                        } else {
                            sortColumn = i;
                            sortDirection = 'asc';
                        }
                        render();
                    });
                });

                if (searchInput) {
                    searchInput.addEventListener('input', () => {
                        currentPage = 1;
                        render();
                    });
                }

                if (pageSizeSelect) {
                    pageSizeSelect.addEventListener('change', () => {
                        pageSize = parseInt(pageSizeSelect.value);
                        currentPage = 1;
                        render();
                    });
                }

                render();
            });
        }
    </script>
</body>
</html>
@extends('layouts.app')

@push('styles')
<style>
    body {
        background: #c8d0d8; /* 加深整體背景，凸顯白底卡片 */
    }

    .page-wrap {
        padding: 24px 5% 36px;
    }

    .section-card {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 14px;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
        margin-bottom: 24px;
    }

    /* 區塊標題：顏色加深，拉高對比度 */
    .section-header {
        padding: 18px 22px 14px;
        border-bottom: 2px solid #cbd5e1;
        background: #f1f5f9;
        border-top-left-radius: 14px;
        border-top-right-radius: 14px;
    }

    .section-header h3 {
        margin: 0;
        font-size: 20px;
        font-weight: 800;
        color: #0f172a; /* 深色標題，更加醒目 */
    }

    .section-header p {
        margin: 6px 0 0;
        font-size: 13px;
        color: #475569; /* 次要說明文字調深 */
        font-weight: 500;
    }

    .section-body {
        padding: 18px 22px 22px;
    }

    /* 資訊方塊區塊：加強標籤對比 */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 18px;
    }

    .info-box {
        background: #f8fafc;
        border: 1.5px solid #cbd5e1;
        border-radius: 10px;
        padding: 14px 16px;
    }

    .info-box-label {
        font-size: 12.5px;
        color: #334155; /* 調深文字 */
        font-weight: 700;
        margin-bottom: 6px;
    }

    .info-box-value {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        word-break: break-word;
    }

    /* ====== 表格橫向滾動核心優化 ====== */
    .erp-table-wrap {
        border: 1px solid #94a3b8;
        border-radius: 12px;
        background: #ffffff;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        width: 100%;
    }

    /* 手機版滾動條提示 */
    .erp-table-wrap::-webkit-scrollbar {
        height: 6px;
    }
    .erp-table-wrap::-webkit-scrollbar-thumb {
        background-color: #94a3b8;
        border-radius: 4px;
    }
    .erp-table-wrap::-webkit-scrollbar-track {
        background-color: #f1f5f9;
    }

    .table.erp-table {
        margin-bottom: 0;
        vertical-align: middle;
        width: 100%;
        border-collapse: collapse;
    }

    .table.erp-table th, 
    .table.erp-table td {
        white-space: nowrap;
        min-width: 90px;
    }

    /* 主表頭：採用深藍灰底白字，提升強烈對比 */
    .table.erp-table thead th {
        background: #1e293b;
        color: #ffffff;
        font-size: 14px;
        font-weight: 700;
        padding: 12px 10px;
        border-bottom: 2px solid #0f172a;
        text-align: center;
    }

    .table.erp-table tbody td,
    .table.erp-table tbody th {
        padding: 10px;
        border-top: 1px solid #cbd5e1;
        color: #0f172a;
        font-size: 13.5px;
        background: #ffffff;
        vertical-align: middle;
    }

    .table.erp-table tbody tr:hover td,
    .table.erp-table tbody tr:hover th {
        background: #fef9c3; /* Hover 時顯眼黃底 */
    }

    /* 次級/交錯表頭 (Sub-header)：調深文字與背景 */
    .table.erp-table .sub-header td,
    .table.erp-table .sub-header th {
        background: #e2e8f0;
        color: #0f172a;
        font-weight: 800;
    }

    /* 新增列：藍色系提示，明確區隔輸入區域 */
    .table.erp-table .create-row td,
    .table.erp-table .create-row th {
        background: #eff6ff;
        border-bottom: 2px solid #bfdbfe;
    }

    /* ====== 控制元件樣式（輸入框/下拉選單）====== */
    .form-control,
    .form-select {
        min-height: 36px;
        border: 1.5px solid #64748b; /* 邊框加深 */
        border-radius: 7px;
        font-size: 13px;
        font-weight: 600;
        padding: 6px 10px;
        background: #ffffff;
        color: #0f172a;
        width: 100%;
    }

    .form-control:focus,
    .form-select:focus,
    textarea.form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
        outline: none;
    }

    textarea.form-control {
        min-height: 80px;
        resize: vertical;
        white-space: normal;
    }

    /* 按鈕樣式加強 */
    .btn-primary { background: #2563eb; border-color: #2563eb; color: #fff; font-weight: 700; }
    .btn-primary:hover { background: #1d4ed8; border-color: #1d4ed8; }

    .btn-success { background: #15803d; border-color: #15803d; color: #fff; font-weight: 700; }
    .btn-success:hover { background: #166534; border-color: #166534; }

    .btn-danger { background: #ffffff; border: 1.5px solid #dc2626; color: #dc2626; font-weight: 700; }
    .btn-danger:hover { background: #fef2f2; border-color: #b91c1c; color: #b91c1c; }

    .btn-light { background: #ffffff; border: 1.5px solid #64748b; color: #0f172a; font-weight: 700; }
    .btn-light:hover { background: #f1f5f9; border-color: #334155; }

    .btn-sm {
        min-height: 34px;
        padding: 6px 12px;
        font-size: 13px;
        border-radius: 7px;
    }

    .btn-icon {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 7px;
        border: 1.5px solid #64748b;
        background: #ffffff;
        color: #0f172a;
        text-decoration: none;
        font-size: 15px;
        cursor: pointer;
        font-weight: 700;
    }

    .btn-icon:hover {
        background: #fef08a;
        border-color: #ca8a04;
        color: #713f12;
    }

    .btn-icon-danger {
        border-color: #fca5a5;
        color: #dc2626;
    }

    .btn-icon-danger:hover {
        background: #fef2f2;
        border-color: #b91c1c;
        color: #b91c1c;
    }

    .action-group {
        display: flex;
        gap: 6px;
        align-items: center;
        justify-content: center;
    }

    .top-action-bar {
        display: flex;
        gap: 12px;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        padding: 16px 22px;
    }

    .top-action-left,
    .top-action-right {
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
    }

    .upload-inline {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .link-inline {
        color: #2563eb;
        font-weight: 700;
        text-decoration: underline;
    }

    .link-inline:hover {
        color: #1d4ed8;
    }

    /* ====== 響應式 RWD 斷點設定 ====== */
    @media (max-width: 1200px) {
        .info-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .page-wrap {
            padding: 12px 8px 24px;
        }

        .section-header, .section-body {
            padding: 14px 16px;
        }

        .info-grid {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .top-action-bar {
            flex-direction: column;
            align-items: stretch;
            padding: 14px 16px;
        }

        .top-action-left, .top-action-right {
            width: 100%;
            justify-content: space-between;
        }

        .upload-inline {
            width: 100%;
        }

        .upload-inline .form-control {
            flex: 1;
        }

        .table.erp-table td.allow-wrap {
            white-space: normal;
            min-width: 160px;
        }
    }
</style>
@endpush

@section('content')
<script>
    function openSearchWindow() {
        window.open('/search-continent', '搜尋洲別', 'width=800,height=600');
    }
</script>

<div class="page-wrap">

    <!-- 訂單主資料 -->
    <div class="section-card">
        <div class="section-header">
            <h3>訂單主資料</h3>
            <p>維護團體基本資訊、接待社、導遊、票務與出發日期。</p>
        </div>

        <div class="section-body">
            <div class="info-grid">
                <div class="info-box">
                    <div class="info-box-label">團體編號</div>
                    <div class="info-box-value">{{ $order->OrderId }}</div>
                </div>
                <div class="info-box">
                    <div class="info-box-label">訂單類型</div>
                    <div class="info-box-value">{{ $order->OrderType }}</div>
                </div>
                <div class="info-box">
                    <div class="info-box-label">修改人員</div>
                    <div class="info-box-value">{{ $order->username }}</div>
                </div>
                <div class="info-box">
                    <div class="info-box-label">總人數</div>
                    <div class="info-box-value">{{ $order->CusNum }}</div>
                </div>
            </div>

            <!-- 開啟橫向滑動容器 -->
            <div class="erp-table-wrap">
                <table class="table erp-table">
                    <tbody>
                        <form name="form1" action="{{ route('ordermore.update', ['ordermore' => $order->OrderId]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="form_type" value="form1">

                            <tr class="sub-header">
                                <th style="min-width: 100px;">團體編號</th>
                                <td style="min-width: 120px;">{{ $order->OrderId }}</td>
                                <th style="min-width: 100px;">名稱 / 專案</th>
                                <td colspan="3" style="min-width: 200px;">
                                    <input type="text" name="OrderName" class="form-control" value="{{ $order->GroupName }}">
                                </td>
                                <th style="min-width: 80px;">地區</th>
                                <td colspan="2" style="min-width: 140px;">
                                    <select name="ContinentID" class="form-select form-select-sm">
                                        @foreach ($continents as $ContinentID => $Country)
                                            <option value="{{ $ContinentID }}" {{ $order->ContinentID == $ContinentID ? 'selected' : '' }}>
                                                {{ $Country }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <th>聯絡人</th>
                                <td>
                                    <input type="text" name="OrderCus" class="form-control" value="{{ $order->OrderCus }}">
                                </td>
                                <th>連絡電話</th>
                                <td colspan="3">
                                    <input type="text" name="OrderTel" class="form-control" value="{{ $order->OrderTel }}">
                                </td>
                                <th>公司</th>
                                <td colspan="2">
                                    <input type="text" name="OrderBuss" class="form-control" value="{{ $order->OrderBuss }}">
                                </td>
                            </tr>

                            <tr>
                                <th>總人數</th>
                                <td>
                                    <input type="number" name="CusNum" min="1" class="form-control" value="{{ $order->CusNum }}">
                                </td>
                                <th>傳真</th>
                                <td colspan="3">
                                    <input type="text" name="OrderFax" class="form-control" value="{{ $order->OrderFax }}">
                                </td>
                                <th>修改</th>
                                <td colspan="2">{{ $order->username }}</td>
                            </tr>

                            @if ($order->OrderType != 2)
                                <tr class="sub-header">
                                    <th>國內接待社</th>
                                    <td>
                                        <select name="TaiwanTs" class="form-select form-select-sm">
                                            <option></option>
                                            @foreach ($local1 as $local)
                                                <option value="{{ $local->LocalTsId }}" {{ $order->TaiwanTs == $local->LocalTsId ? 'selected' : '' }}>
                                                    {{ $local->LocalTsName }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <th>導遊</th>
                                    <td>
                                        <input type="text" name="Guide1" class="form-control" value="{{ $order->Guide1 }}">
                                    </td>
                                    <th>電話</th>
                                    <td>
                                        <input type="text" name="Guide1Tel" class="form-control" value="{{ $order->Guide1Tel }}">
                                    </td>
                                    <th>票務</th>
                                    <td colspan="2">
                                        <select name="Ticket" class="form-select form-select-sm">
                                            <option></option>
                                            @foreach ($local1 as $local)
                                                <option value="{{ $local->LocalTsId }}" {{ $order->Ticket == $local->LocalTsId ? 'selected' : '' }}>
                                                    {{ $local->LocalTsName }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <th>國外接待社</th>
                                    <td>
                                        <select name="FTs" class="form-select form-select-sm">
                                            <option></option>
                                            @foreach ($local2 as $local)
                                                <option value="{{ $local->LocalTsId }}" {{ $order->FTs == $local->LocalTsId ? 'selected' : '' }}>
                                                    {{ $local->LocalTsName }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <th>導遊</th>
                                    <td>
                                        <input type="text" name="Guide2" class="form-control" value="{{ $order->Guide2 }}">
                                    </td>
                                    <th>電話</th>
                                    <td colspan="4">
                                        <input type="text" name="Guide2Tel" class="form-control" value="{{ $order->Guide2Tel }}">
                                    </td>
                                </tr>
                            @endif

                            <tr>
                                <th>備註</th>
                                <td colspan="8" class="allow-wrap">
                                    <textarea name="Ps" rows="3" class="form-control">{{ $order->Ps }}</textarea>
                                </td>
                            </tr>

                            <tr>
                                <th>出發日</th>
                                <td>
                                    <input type="date" name="OrderStart" class="form-control" value="{{ $order->OrderStart }}">
                                </td>
                                <th>回程日</th>
                                <td colspan="3">
                                    <input type="date" name="OrderCome" class="form-control" value="{{ $order->OrderCome }}">
                                </td>
                                <td colspan="3" class="text-center">
                                    <button type="submit" class="btn-icon" title="修改主資料">
                                        <span class="icon-pencil">✎</span>
                                    </button>
                                </td>
                            </tr>
                        </form>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 航班 / 交通安排 -->
    <div class="section-card">
        <div class="section-header">
            <h3>航班 / 交通安排</h3>
            <p>管理出發地、目的地、交通方式與名單設定。</p>
        </div>

        <div class="section-body">
            <div class="erp-table-wrap">
                <table class="table erp-table">
                    <thead>
                        <tr>
                            <th style="min-width:160px;">航班時間</th>
                            <th style="min-width:120px;">出發地</th>
                            <th style="min-width:120px;">目的地</th>
                            <th style="min-width:100px;">交通</th>
                            <th style="min-width:80px;">總人數</th>
                            <th style="min-width:150px;">備註</th>
                            <th style="min-width:60px;">名單</th>
                            <th style="min-width:90px;">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <form action="{{ route('ordermore.store') }}" method="post" name="form2">
                            @csrf
                            <input type="hidden" name="form_type" value="form2">
                            <input type="hidden" name="orderid" value="{{ $order->OrderId }}">
                            <tr class="create-row">
                                <td>
                                    <input type="text" name="Date" value="0000-00-00 00:00:00" class="form-control">
                                </td>
                                <td>
                                    <select name="location1" class="form-select form-select-sm">
                                        <option value="" selected></option>
                                        @foreach ($locations as $location)
                                            <option value="{{ $location->LocationId }}">{{ $location->LocationName }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="location2" class="form-select form-select-sm">
                                        <option value="" selected></option>
                                        @foreach ($locations as $location)
                                            <option value="{{ $location->LocationId }}">{{ $location->LocationName }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="traffic" class="form-select form-select-sm">
                                        <option value="" selected></option>
                                        @foreach ($traffics as $traffic)
                                            <option value="{{ $traffic->TrafficId }}">{{ $traffic->TrafficName }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="cusnum" min="1" max="{{ $order->CusNum }}" class="form-control">
                                </td>
                                <td>
                                    <input type="text" name="Ps" class="form-control">
                                </td>
                                <td class="text-center muted-text">-</td>
                                <td class="text-center">
                                    <button type="submit" class="btn btn-success btn-sm">新增</button>
                                </td>
                            </tr>
                        </form>

                        @foreach ($ordertraffics as $ordertraffic)
                            <tr>
                                <form name="form3" action="{{ route('ordermore.update', ['ordermore' => $ordertraffic->OrderTrafficId]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="form_type" value="form3">

                                    <td>
                                        <input type="text" name="date" value="{{ $ordertraffic->Date }}" class="form-control">
                                    </td>
                                    <td>
                                        <select name="LocationId" class="form-select form-select-sm">
                                            <option></option>
                                            @foreach ($locations as $location)
                                                <option value="{{ $location->LocationId }}" {{ $ordertraffic->LocationId == $location->LocationId ? 'selected' : '' }}>
                                                    {{ $location->LocationName }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select name="LocationId2" class="form-select form-select-sm">
                                            <option></option>
                                            @foreach ($locations as $location)
                                                <option value="{{ $location->LocationId }}" {{ $ordertraffic->LocationId2 == $location->LocationId ? 'selected' : '' }}>
                                                    {{ $location->LocationName }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select name="TrafficId" class="form-select form-select-sm">
                                            <option></option>
                                            @foreach ($traffics as $traffic)
                                                <option value="{{ $traffic->TrafficId }}" {{ $ordertraffic->TrafficId == $traffic->TrafficId ? 'selected' : '' }}>
                                                    {{ $traffic->TrafficName }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="cusnum" min="1" max="{{ $order->CusNum }}" value="{{ $ordertraffic->cusnum }}" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" name="Ps" value="{{ $ordertraffic->Ps }}" class="form-control">
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('cusselect.index', ['OrderTrafficId' => $ordertraffic->OrderTrafficId]) }}" target="_blank" class="link-inline">名單</a>
                                    </td>
                                    <td>
                                        <div class="action-group">
                                            <button type="submit" class="btn-icon" title="修改">
                                                <span class="icon-pencil">✎</span>
                                            </button>
                                </form>

                                            <form action="{{ route('ordermore.destroy', ['ordermore' => $ordertraffic->OrderTrafficId]) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="orderid" value="{{ $order->OrderId }}">
                                                <input type="hidden" name="tableId" value="OrderTrafficId">
                                                <input type="hidden" name="tableName" value="ordertraffic">
                                                <button type="submit" class="btn-icon btn-icon-danger" title="刪除" onclick="return confirm('確定要刪除嗎？')">🗑</button>
                                            </form>
                                        </div>
                                    </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 行程與飯店 -->
    @if ($order->OrderType != 2)
    <div class="section-card">
        <div class="section-header">
            <h3>行程與飯店</h3>
            <p>管理每日行程內容與住宿飯店。</p>
        </div>

        <div class="section-body">
            <div class="erp-table-wrap">
                <table class="table erp-table">
                    <thead>
                        <tr>
                            <th style="min-width: 130px;">日期</th>
                            <th style="min-width: 250px;">行程</th>
                            <th style="min-width: 160px;">飯店</th>
                            <th style="min-width: 80px;">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <form action="{{ route('ordermore.store') }}" method="post" name="tour_store_form">
                            @csrf
                            <input type="hidden" name="form_type" value="tour_store">
                            <input type="hidden" name="orderid" value="{{ $order->OrderId }}">
                            <tr class="create-row">
                                <td>
                                    <input type="date" name="Date" class="form-control">
                                </td>
                                <td class="allow-wrap">
                                    <textarea name="Tour" rows="2" class="form-control"></textarea>
                                </td>
                                <td>
                                    <input type="hidden" name="HotelId" id="HotelId" />
                                    <input type="text" name="HotelName" id="HotelName" readonly onclick="openSearchWindow()" class="form-control" placeholder="點擊搜尋飯店">
                                </td>
                                <td class="text-center">
                                    <button type="submit" class="btn btn-success btn-sm">新增</button>
                                </td>
                            </tr>
                        </form>

                        @foreach ($ordertours as $ordertour)
                            <tr>
                                <td>{{ $ordertour->Date }}</td>
                                <td class="allow-wrap">{{ $ordertour->Tour }}</td>
                                <td>{{ $ordertour->HotelName }}</td>
                                <td>
                                    <div class="action-group">
                                        <form action="{{ route('ordermore.destroy', ['ordermore' => $ordertour->OrderTourId]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="orderid" value="{{ $ordertour->OrderId }}">
                                            <input type="hidden" name="tableId" value="OrderTourId">
                                            <input type="hidden" name="tableName" value="ordertour">
                                            <button type="submit" class="btn-icon btn-icon-danger" title="刪除" onclick="return confirm('確定要刪除嗎？')">🗑</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success" role="alert">{{ session('status') }}</div>
    @endif

    @if ($errors->has('target_order_id'))
        <div class="alert alert-danger" role="alert">{{ $errors->first('target_order_id') }}</div>
    @endif

    <!-- 旅客名冊 -->
    <div class="section-card">
        <div class="section-header">
            <h3>旅客名冊</h3>
            <p>管理匯入、列印與旅客基本資料。</p>
        </div>

        <div class="top-action-bar">
            <div class="top-action-left">
                <a href="{{ route('printcus.index', ['type' => 1, 'OrderId' => $order->OrderId]) }}" class="btn btn-light btn-sm">名冊格式1</a>
                <a href="{{ route('printcus.index', ['type' => 2, 'OrderId' => $order->OrderId]) }}" class="btn btn-light btn-sm">名冊格式2</a>
            </div>

            <div class="top-action-right">
                <form id="form3" name="form3" enctype="multipart/form-data" method="POST" action="{{ route('ordermore.import', ['OrderId' => $order->OrderId, 'date' => $order->OrderStart]) }}">
                    @csrf
                    <div class="upload-inline">
                        <input type="file" name="file" class="form-control form-control-sm">
                        <button type="submit" class="btn-icon" title="上傳" style="width:38px;height:38px;">⬆</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="section-body" style="padding-top:0;">
            <div class="erp-table-wrap">
                <table class="table erp-table">
                    <thead>
                        <tr>
                            <th style="min-width: 50px;">編號</th>
                            <th style="min-width: 100px;">中文姓名</th>
                            <th style="min-width: 110px;">西元生日</th>
                            <th style="min-width: 120px;">身分證字號</th>
                            <th style="min-width: 60px;">性別</th>
                            <th style="min-width: 90px;">票種</th>
                            <th style="min-width: 110px;">連絡電話</th>
                            <th style="min-width: 150px;">備註</th>
                            <th style="min-width: 60px;">去程</th>
                            <th style="min-width: 60px;">回程</th>
                            <th style="min-width: 70px;">操作</th>
                            @if ($order->OrderType != 2)
                                <th style="min-width: 120px;">取消狀態</th>
                                <th style="min-width: 70px;">更新</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        <form action="{{ route('ordermore.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="form_type" value="cus_store">
                            <input type="hidden" name="orderid" value="{{ $order->OrderId }}">
                            <tr class="create-row">
                                <td></td>
                                <td><input type="text" name="Name" class="form-control"></td>
                                <td><input type="text" name="Birthday" class="form-control"></td>
                                <td><input type="text" name="ID" class="form-control"></td>
                                <td>
                                    <select name="Sex" class="form-select form-select-sm">
                                        <option value="1" selected>男</option>
                                        <option value="2">女</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="tickettype" class="form-select form-select-sm">
                                        <option value="" selected></option>
                                        @foreach ($tickettypes as $tickettype)
                                            <option value="{{ $tickettype->TypeId }}">{{ $tickettype->TypeName }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="text" name="Phone" class="form-control"></td>
                                <td><input type="text" name="Ps" class="form-control"></td>
                                <td colspan="2"></td>
                                <td class="text-center">
                                    <button type="submit" class="btn btn-success btn-sm">新增</button>
                                </td>
                                @if ($order->OrderType != 2)
                                    <td></td>
                                    <td></td>
                                @endif
                            </tr>
                        </form>

                        @foreach ($customers as $customer)
                            <tr>
                                <td class="text-center">
                                    <a href="{{ route('visa.index', ['CusId' => $customer->CusId]) }}" target="_blank" class="link-inline">
                                        {{ $loop->iteration }}
                                    </a>
                                </td>
                                <td>{{ $customer->Name }}</td>
                                <td>{{ $customer->Birthday }}</td>
                                <th style="background-color: {{ $customer->isValid ? 'inherit' : 'yellow' }};">{{ $customer->ID }}</th>
                                <td>{{ $customer->SexName }}</td>
                                <td>{{ $customer->TypeName }}</td>
                                <td>{{ $customer->Phone }}</td>
                                <td class="allow-wrap">{{ $customer->Ps }}</td>
                                <td>{{ $customer->CarNo }}</td>
                                <td>{{ $customer->CarNo2 }}</td>
                                <td>
                                    <div class="action-group">
                                        <button
                                            type="button"
                                            class="btn btn-outline-primary btn-sm"
                                            title="複製旅客到其他訂單"
                                            onclick="openCopyCustomerDialog({{ $customer->CusId }}, @js($customer->Name))">
                                            複製
                                        </button>
                                        @if ($customer->TM != 1)
                                            <form action="{{ route('ordermore.destroy', ['ordermore' => $customer->CusId]) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="orderid" value="{{ $customer->OrderId }}">
                                                <input type="hidden" name="tableId" value="CusId">
                                                <input type="hidden" name="tableName" value="customer">
                                                <button type="submit" class="btn-icon btn-icon-danger" title="刪除" onclick="return confirm('確定要刪除嗎？')">🗑</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>

                                @if ($order->OrderType != 2)
                                    @if ($customer->TM != 1)
                                        <form action="{{ route('ordermore.update', ['ordermore' => $customer->OrderId]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="form_type" value="cus_update">
                                            <input type="hidden" name="CusId" value="{{ $customer->CusId }}">
                                            <td>
                                                <select name="Cancel" class="form-select form-select-sm" style="background-color: {{ $customer->Cancel == 1 ? '#ffe4e4' : '#ffffff' }};">
                                                    <option value="0" {{ $customer->Cancel == 0 ? 'selected' : '' }}>正常</option>
                                                    <option value="1" {{ $customer->Cancel == 1 ? 'selected' : '' }}>辦證後取消</option>
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <button type="submit" class="btn-icon" title="修改">
                                                    <span class="icon-pencil">✎</span>
                                                </button>
                                            </td>
                                        </form>
                                    @else
                                        <td></td>
                                        <td></td>
                                    @endif
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- 複製旅客對話框 -->
<dialog id="copyCustomerDialog" style="width:min(520px, calc(100% - 32px));border:1px solid #d0d0d0;border-radius:8px;padding:24px;box-shadow:0 12px 40px rgba(0,0,0,.18);">
    <form method="POST" action="{{ route('ordermore.copyCustomer') }}">
        @csrf
        <h4 style="margin-top:0;">複製旅客資料</h4>
        <p>旅客：<strong id="copyCustomerName"></strong></p>
        <input type="hidden" name="customer_id" id="copyCustomerId">

        <label for="copyTargetOrder" style="display:block;margin-bottom:8px;">請輸入目標訂單編號</label>
        <input
            type="text"
            name="target_order_id"
            id="copyTargetOrder"
            class="form-control"
            maxlength="20"
            required
            autocomplete="off"
            placeholder="請輸入完整訂單編號"
            style="width:100%;margin-bottom:8px;">
        <small style="display:block;color:#475569;margin-bottom:18px;">送出後系統會先確認訂單存在；找不到訂單時不會複製資料。</small>

        <div style="display:flex;justify-content:flex-end;gap:8px;">
            <button type="button" class="btn btn-light" onclick="document.getElementById('copyCustomerDialog').close()">取消</button>
            <button type="submit" class="btn btn-primary" onclick="return confirm('確定要將這位旅客複製到所選訂單嗎？')">確認複製</button>
        </div>
    </form>
</dialog>

<script>
    function openCopyCustomerDialog(customerId, customerName) {
        document.getElementById('copyCustomerId').value = customerId;
        document.getElementById('copyCustomerName').textContent = customerName || '';
        document.getElementById('copyTargetOrder').value = '';
        document.getElementById('copyTargetOrder').setCustomValidity('');
        document.getElementById('copyCustomerDialog').showModal();
    }
</script>

@if (session('status'))
<script>
    window.addEventListener('DOMContentLoaded', function () {
        alert(@json(session('status')));
    });
</script>
@endif

@if ($errors->any())
<script>
    window.addEventListener('DOMContentLoaded', function () {
        alert(@json($errors->first()));
    });
</script>
@endif

@endsection
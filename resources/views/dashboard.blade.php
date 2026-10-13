@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color:#D0D0D0; min-height:100vh;">

    <!-- 標題 -->
    <div class="row mb-4">
        <div class="col-12">
            <div style="
                background:#ffffff;
                border:1px solid #b8c2cc;
                border-radius:6px;
                padding:18px 24px;
                box-shadow:0 1px 3px rgba(0,0,0,0.08);
            ">
                <h2 style="margin:0; font-size:24px; font-weight:700;">Dashboard</h2>
                <div style="margin-top:6px; color:#6b7280; font-size:14px;">
                    系統首頁
                </div>
            </div>
        </div>
    </div>

    <!-- 上方三卡 -->
    <div class="row g-4 mb-4">

        <!-- 今日出團 -->
        <div class="col-12 col-lg-4">
            <div class="card-box">
                <div class="card-title">今日出團</div>

                <div class="card-body">

                    <div class="card-info">
                        <span>日期：{{ $today }}</span>
                        <span>共 {{ $todayDepartures->count() }} 筆</span>
                    </div>

                    @php $list = $todayDepartures; @endphp

                    <div class="table-wrap">
                        <table class="table table-bordered table-sm mb-0 departure-table" style="table-layout:fixed;">
                            <thead>
                                <tr>
                                    <th style="width:30%;">公司</th>
                                    <th style="width:24%;">代表</th>
                                    <th style="width:12%;" class="text-center">人數</th>
                                    <th style="width:34%;">訂單編號</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($list as $item)
                                <tr class="hover-row">
                                    <td class="text-ellipsis strong" title="{{ $item->OrderBuss }}">
                                        {{ $item->OrderBuss }}
                                    </td>
                                    <td class="text-ellipsis" title="{{ $item->tmCustomer->Name ?? '-' }}">
                                        {{ $item->tmCustomer->Name ?? '-' }}
                                    </td>
                                    <td class="text-center number-cell">
                                        {{ $item->CusNum }}
                                    </td>
                                    <td>
                                        <a href="{{ route('ordermore.index', ['orderId' => $item->OrderId]) }}" target="_blank" class="link-order">
                                            {{ $item->OrderId }}
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted p-4">
                                        今日沒有出團資料
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <!-- 明日出團 -->
        <div class="col-12 col-lg-4">
            <div class="card-box">
                <div class="card-title">明日出團</div>

                <div class="card-body">

                    <div class="card-info">
                        <span>日期：{{ $tomorrow }}</span>
                        <span>共 {{ $tomorrowDepartures->count() }} 筆</span>
                    </div>

                    @php $list = $tomorrowDepartures; @endphp

                    <div class="table-wrap">
                        <table class="table table-bordered table-sm mb-0 departure-table" style="table-layout:fixed;">
                            <thead>
                                <tr>
                                    <th style="width:30%;">公司</th>
                                    <th style="width:24%;">代表</th>
                                    <th style="width:12%;" class="text-center">人數</th>
                                    <th style="width:34%;">訂單編號</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($list as $item)
                                <tr class="hover-row">
                                    <td class="text-ellipsis strong" title="{{ $item->OrderBuss }}">
                                        {{ $item->OrderBuss }}
                                    </td>
                                    <td class="text-ellipsis" title="{{ $item->tmCustomer->Name ?? '-' }}">
                                        {{ $item->tmCustomer->Name ?? '-' }}
                                    </td>
                                    <td class="text-center number-cell">
                                        {{ $item->CusNum }}
                                    </td>
                                    <td>
                                        <a href="{{ route('ordermore.index', ['orderId' => $item->OrderId]) }}" target="_blank" class="link-order">
                                            {{ $item->OrderId }}
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted p-4">
                                        明日沒有出團資料
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <!-- 五吉訂單 -->
        <div class="col-12 col-lg-4">
            <a href="{{ url('/temporder') }}" style="text-decoration:none;">
                <div class="card-box hover-card">
                    <div class="card-title">五吉訂單</div>

                    <div class="card-center">
                        <div class="big-number {{ $tempOrderCount > 0 ? 'text-danger' : 'text-success' }}">
                            {{ $tempOrderCount }}
                        </div>
                        <div class="text-muted mt-2">未完成訂單</div>
                    </div>
                </div>
            </a>
        </div>

    </div>

    <!-- 留言板 + 取消訂單 -->
<div class="row">

    <!-- 左：留言板 -->
    <div class="col-12 col-lg-8">
        <div class="card-box">
            <div class="card-title">留言板 / 交辦事項</div>

            <div class="card-body">

                <div class="table-wrap" style="max-height:420px;">
                    <table class="table table-bordered table-sm mb-0">
                        <thead>
                            <tr>
                                <th width="160">交辦時間</th>
                                <th>內容</th>
                                <th width="120">交辦人</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($guestbooks as $guestbook)
                            <tr class="hover-row">
                                <td>{{ $guestbook->S_Time }}</td>
                                <td>{{ $guestbook->Main }}</td>
                                <td>{{ $guestbook->Starter }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">
                                    目前沒有交辦事項
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="text-end mt-3">
                    <a href="{{ route('guestbook.index') }}">查看全部 →</a>
                </div>

            </div>
        </div>
    </div>

    <!-- 右：取消訂單 -->
    <div class="col-12 col-lg-4">
        <div class="card-box">
            <div class="card-title text-danger">⚠ 已取消還在系統</div>

            <div class="card-body">

                <div class="table-wrap" style="max-height:420px;">
                    <table class="table table-bordered table-sm mb-0">
                        <thead>
                            <tr>
                                <th>訂單</th>
                                <th>代表</th>
                                <th>人數</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cancelOrders as $order)
                            <tr class="hover-row">
                                <td>
                                    <a href="{{ route('ordermore.index', ['orderId' => $order->OrderId]) }}" target="_blank" class="link-order">
                                        {{ $order->OrderId }}
                                    </a>
                                </td>
                                <td>
                                    {{ $order->tmCustomer->Name ?? '-' }}
                                </td>
                                <td class="text-center">
                                    {{ $order->CusNum }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">
                                    沒有取消訂單
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</div>

</div>

<style>
.card-box {
    background:#fff;
    border:1px solid #b8c2cc;
    border-radius:6px;
    box-shadow:0 1px 3px rgba(0,0,0,0.08);
    overflow:hidden;
    min-height:320px;
}

.card-title {
    background:#e9ecef;
    border-bottom:1px solid #b8c2cc;
    padding:12px 16px;
    font-weight:700;
}

.card-body {
    padding:16px;
}

.card-info {
    display:flex;
    justify-content:space-between;
    margin-bottom:10px;
    font-size:13px;
    color:#6b7280;
}

.table-wrap {
    overflow-y:auto;
    max-height:220px;
    border:1px solid #d8dee6;
    border-radius:4px;
    background:#fff;
}

.departure-table th,
.departure-table td {
    vertical-align:middle;
    font-size:13px;
}

.departure-table thead th {
    background:#eef2f7;
    white-space:nowrap;
}

.text-ellipsis {
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}

.strong {
    font-weight:600;
}

.number-cell {
    font-weight:600;
    color:#111827;
}

.link-order {
    color:#2563eb;
    font-weight:600;
    text-decoration:none;
}

.link-order:hover {
    text-decoration:underline;
}

.hover-row:hover {
    background:#f1f5f9;
}

.hover-card:hover {
    transform:translateY(-2px);
    transition:0.2s;
}

.card-center {
    height:250px;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
}

.big-number {
    font-size:56px;
    font-weight:700;
}
</style>

@endsection
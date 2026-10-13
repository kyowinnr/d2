@extends('layouts.app')

@push('styles')
<style>
    body {
        background: #d0d0d0;
    }

    .page-wrap {
        padding: 24px 5% 36px;
    }

    .section-card {
        background: #ffffff;
        border: 1px solid #dde3e8;
        border-radius: 14px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
        overflow: hidden;
        margin-bottom: 24px;
    }

    .section-header {
        padding: 18px 22px 14px;
        border-bottom: 1px solid #e5eaf0;
        background: #f7f9fb;
    }

    .section-header h3 {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
        color: #1f2937;
    }

    .section-header p {
        margin: 6px 0 0;
        font-size: 13px;
        color: #6b7280;
    }

    .search-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
        padding: 14px 22px;
        border-bottom: 1px solid #e5eaf0;
        background: #ffffff;
    }

    .search-box {
        background: #f9fbfc;
        border: 1px solid #dde3e8;
        border-radius: 10px;
        padding: 10px 12px;
        min-width: 0;
    }

    .search-box-title {
        margin: 0 0 6px;
        font-size: 13px;
        font-weight: 700;
        color: #334155;
    }

    .search-row {
        display: flex;
        gap: 6px;
        align-items: center;
        flex-wrap: nowrap;
        min-width: 0;
    }

    .form-control,
    .form-select {
        height: 36px;
        font-size: 12px;
        border: 1px solid #cfd8e3;
        border-radius: 6px;
        padding: 4px 8px;
        min-width: 0;
    }

    .w-small {
        width: 85px;
    }

    .w-medium {
        width: 110px;
    }

    .w-keyword {
        width: 120px;
    }

    .flex-grow {
        flex: 1;
        min-width: 0;
    }

    .btn-icon {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        border: 1px solid #d6dee6;
        background: #f8fafc;
        color: #334155;
        padding: 0;
        flex: 0 0 36px;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-icon:hover {
        background: #fff8db;
        border-color: #f2e3a7;
        color: #92400e;
    }

    .btn-icon-danger:hover {
        background: #ffe4e4;
        border-color: #f5b5b5;
        color: #b91c1c;
    }

    .action-group {
        display: flex;
        gap: 6px;
        align-items: center;
        flex-wrap: wrap;
    }

    .table-wrap {
        padding: 0 22px 22px;
    }

    .table-responsive {
        border: 1px solid #dde3e8;
        border-radius: 12px;
        overflow-x: auto;
        overflow-y: hidden;
        background: #ffffff;
        -webkit-overflow-scrolling: touch;
    }

    .table.erp-table {
        margin-bottom: 0;
        min-width: 720px;
    }

    .table.erp-table thead th {
        background: #e9edf3;
        font-size: 13px;
        font-weight: 700;
        padding: 10px;
        white-space: nowrap;
        vertical-align: middle;
    }

    .table.erp-table tbody td {
        font-size: 13px;
        padding: 10px;
        vertical-align: middle;
    }

    .table.erp-table tbody tr:hover td {
        background: #fff8db;
    }

    .info-link {
        color: #2563eb;
        text-decoration: none;
        word-break: break-word;
    }

    .info-link:hover {
        text-decoration: underline;
    }

    .empty-state {
        text-align: center;
        padding: 20px;
        color: #64748b;
    }

    @media (max-width: 991.98px) {
        .search-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767.98px) {
        .page-wrap {
            padding: 14px 10px 24px;
        }

        .section-header {
            padding: 14px 14px 12px;
        }

        .section-header h3 {
            font-size: 18px;
        }

        .section-header p {
            font-size: 12px;
        }

        .search-grid {
            padding: 12px;
            gap: 10px;
        }

        .search-box {
            padding: 10px;
        }

        .search-row {
            flex-wrap: wrap;
        }

        .w-small,
        .w-medium,
        .w-keyword,
        .flex-grow {
            width: 100%;
            flex: 0 0 100%;
        }

        .btn-icon {
            width: 100%;
            flex: 0 0 100%;
            height: 38px;
            font-size: 16px;
        }

        .table-wrap {
            padding: 0 12px 12px;
        }

        .table.erp-table thead th,
        .table.erp-table tbody td {
            font-size: 12px;
            padding: 8px;
        }
    }
</style>
@endpush

@section('content')
<div class="page-wrap">
    <div class="section-card">

        <div class="section-header">
            <h3>訂單查詢</h3>
            <p>快速篩選訂單資料</p>
        </div>

        <div class="search-grid">

            <div class="search-box">
                <div class="search-box-title">日期查詢</div>
                <form action="{{ route('ordersearch.index') }}" method="GET">
                    <div class="search-row">
                        <select name="dateType" class="form-select w-small">
                            <option value="OrderStart">出發</option>
                            <option value="OrderCome">回程</option>
                        </select>
                        <input type="date" name="date" class="form-control flex-grow">
                        <button type="submit" class="btn-icon" title="查詢">🔍</button>
                    </div>
                </form>
            </div>

            <div class="search-box">
                <div class="search-box-title">關鍵字查詢</div>
                <form action="{{ route('ordersearch.index') }}" method="GET">
                    <div class="search-row">
                        <select name="year" class="form-select w-small">
                            @foreach(range(date('Y') + 1, 2019) as $year)
                                <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>

                        <select name="searchType" class="form-select w-medium">
                            <option value="OrderId">編號</option>
                            <option value="OrderBuss">同業</option>
                            <option value="bank">匯款</option>
                            <option value="Name">旅客</option>
                        </select>

                        <input type="text" name="keyword" class="form-control w-keyword" placeholder="關鍵字">
                        <button type="submit" class="btn-icon" title="查詢">🔍</button>
                    </div>
                </form>
            </div>

            <div class="search-box">
                <div class="search-box-title">月份分類</div>
                <form action="{{ route('ordersearch.index') }}" method="GET">
                    <div class="search-row">
                        <select name="year" class="form-select w-small">
                            @foreach(range(date('Y') + 1, 2019) as $year)
                                <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>

                        <select name="month" class="form-select w-small">
                            @for ($j = 1; $j <= 12; $j++)
                                <option value="{{ $j }}">{{ $j }}</option>
                            @endfor
                        </select>

                        <select name="category" class="form-select w-medium">
                            <option value="3">全部</option>
                            <option value="0">團體</option>
                            <option value="1">自由行</option>
                            <option value="2">票務</option>
                            <option value="4">訂房</option>
                        </select>

                        <button type="submit" class="btn-icon" title="查詢">🔍</button>
                    </div>
                </form>
            </div>

        </div>

        <div class="table-wrap">
            <div class="table-responsive">
                <table class="table erp-table">
                    <thead>
                        <tr>
                            <th>訂單編號</th>
                            <th>出發日</th>
                            <th>尾款</th>
                            <th>同業名</th>
                            <th>訂單資訊</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>{{ $order->OrderId }}</td>
                                <td>{{ $order->OrderStart }}</td>
                                <td>{{ $order->FinalPay }}</td>
                                <td>{{ $order->OrderBuss }}</td>
                                <td>
                                    <a href="{{ route('ordermore.index', ['orderId' => $order->OrderId]) }}" target="_blank" class="info-link">
                                        {{ $order->GroupName }} / {{ $order->Name }}
                                    </a>
                                </td>
                                <td>
                                    <div class="action-group">
                                        <a href="{{ route('tbill.index', ['orderId' => $order->OrderId]) }}"
                                           class="btn-icon"
                                           title="帳務"
                                           target="_blank">💰</a>

                                        <a href="{{ route('ordersearche.destroy', ['ordersearche' => $order->OrderId]) }}"
                                           class="btn-icon btn-icon-danger"
                                           title="刪除"
                                           onclick="event.preventDefault(); if(confirm('確定刪除？')) document.getElementById('d{{ $order->OrderId }}').submit();">
                                            🗑️
                                        </a>

                                        <form id="d{{ $order->OrderId }}"
                                              method="POST"
                                              action="{{ route('ordersearche.destroy', $order->OrderId) }}"
                                              style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-state">沒有資料</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
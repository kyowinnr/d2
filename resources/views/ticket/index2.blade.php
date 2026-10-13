@extends('layouts.app')

@section('title', '建檔 STEP2')

@push('styles')
<style>
    .erp-page {
        background: #d0d0d0;
        min-height: calc(100vh - 120px);
        padding: 24px 0;
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
        padding: 20px 24px 14px;
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
        font-size: 14px;
        color: #6b7280;
    }

    .section-body {
        padding: 20px 24px 24px;
    }

    .table-toolbar {
        display: flex;
        align-items: flex-end;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 18px;
        padding: 16px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
    }

    .table-toolbar .toolbar-group {
        min-width: 140px;
        flex: 1 1 140px;
    }

    .table-toolbar label,
    .form-block label {
        display: block;
        margin-bottom: 6px;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
    }

    .erp-table {
        margin-bottom: 0;
        vertical-align: middle;
        background: #ffffff;
    }

    .erp-table thead th {
        background: #e9edf3;
        color: #334155;
        font-weight: 700;
        font-size: 14px;
        border-bottom: 1px solid #d7dee7;
        padding: 12px 14px;
        white-space: nowrap;
        text-align: center;
    }

    .erp-table tbody td {
        padding: 12px 14px;
        border-color: #e5e7eb;
        vertical-align: middle;
        color: #1f2937;
        background: #ffffff;
    }

    .erp-table tbody tr:hover td {
        background: #f8fbff;
    }

    .erp-table .subhead-row td,
    .erp-table .subhead-row th {
        background: #f1f5f9;
        color: #334155;
        font-weight: 700;
        border-top: 1px solid #dde3e8;
        border-bottom: 1px solid #dde3e8;
    }

    .erp-table .section-mark {
        background: #eef4ff !important;
        color: #2f5ea8 !important;
        font-weight: 700;
    }

    .erp-table .summary-row td,
    .erp-table .summary-row th {
        background: #f8fafc;
        font-weight: 600;
    }

    .erp-table .empty-state {
        text-align: center;
        color: #6b7280;
        background: #f8fafc;
        padding: 20px;
    }

    .form-control,
    .form-select {
        border: 1px solid #cfd8e3;
        min-height: 40px;
        border-radius: 8px;
        width: 100%;
    }

    .form-control:focus,
    .form-select:focus,
    textarea:focus {
        border-color: #4f8cff;
        box-shadow: 0 0 0 0.15rem rgba(79, 140, 255, 0.15);
        outline: none;
    }

    textarea.form-control {
        min-height: 84px;
        resize: vertical;
    }

    .btn-primary {
        background: #4f8cff;
        border-color: #4f8cff;
    }

    .btn-primary:hover,
    .btn-primary:focus {
        background: #3f7ae6;
        border-color: #3f7ae6;
    }

    .btn-danger {
        background: #e35d5d;
        border-color: #e35d5d;
    }

    .btn-danger:hover,
    .btn-danger:focus {
        background: #cf4f4f;
        border-color: #cf4f4f;
    }

    .btn-light {
        background: #f8fafc;
        border-color: #d8e1e8;
        color: #334155;
    }

    .btn-light:hover,
    .btn-light:focus {
        background: #eef2f6;
        border-color: #cfd8e3;
        color: #1f2937;
    }

    .customer-grid {
        display: grid;
        grid-template-columns: repeat(6, minmax(0, 1fr));
        gap: 14px;
        padding: 16px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        margin-bottom: 14px;
    }

    .customer-grid .field-span-2 {
        grid-column: span 2;
    }

    .customer-grid .field-span-6 {
        grid-column: span 6;
    }

    .customer-card-title {
        margin: 0 0 10px;
        font-size: 14px;
        font-weight: 700;
        color: #334155;
    }

    .deposit-box {
        display: grid;
        grid-template-columns: 220px 220px 1fr;
        gap: 14px;
        align-items: end;
        padding: 16px;
        background: #fff8db;
        border: 1px solid #f1e3a5;
        border-radius: 12px;
    }

    .page-title-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .page-title-badge {
        display: inline-flex;
        align-items: center;
        min-height: 34px;
        padding: 6px 12px;
        border-radius: 999px;
        background: #eef4ff;
        color: #2f5ea8;
        font-size: 13px;
        font-weight: 700;
        border: 1px solid #cfe0ff;
    }

    @media (max-width: 1200px) {
        .customer-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .customer-grid .field-span-2,
        .customer-grid .field-span-6 {
            grid-column: span 2;
        }

        .deposit-box {
            grid-template-columns: 1fr 1fr;
        }

        .deposit-box .deposit-action {
            grid-column: span 2;
        }
    }

    @media (max-width: 768px) {
        .erp-page {
            padding: 16px 0;
        }

        .section-header,
        .section-body {
            padding-left: 16px;
            padding-right: 16px;
        }

        .customer-grid {
            grid-template-columns: 1fr;
        }

        .customer-grid .field-span-2,
        .customer-grid .field-span-6 {
            grid-column: span 1;
        }

        .deposit-box {
            grid-template-columns: 1fr;
        }

        .deposit-box .deposit-action {
            grid-column: span 1;
        }
    }
</style>
@endpush

@section('content')
<div class="erp-page">
    <div class="container-fluid">

        <div class="section-card">
            <div class="section-header">
                <div class="page-title-bar">
                    <div>
                        <h3>訂單建檔 STEP2</h3>
                        <p>維護交通資訊、應收費用、旅客資料與訂金期限。</p>
                    </div>
                    <div class="page-title-badge">編號：{{ $OrderId }}</div>
                </div>
            </div>
        </div>

        <div class="section-card">
            <div class="section-header">
                <h3>交通資料</h3>
                <p>新增與維護此訂單的航班 / 接駁 / 交通工具安排。</p>
            </div>

            <div class="section-body">
                <form action="{{ route('ticket.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="OrderId" value="{{ $OrderId }}">
                    <input type="hidden" name="type" value="ordertraffic">

                    <div class="table-toolbar">
                        <div class="toolbar-group">
                            <label>航班時間</label>
                            <input type="text" name="Date" value="2025-00-00 00:00:00" class="form-control">
                        </div>

                        <div class="toolbar-group">
                            <label>出發地</label>
                            <select name="location1" class="form-select">
                                <option value=""></option>
                                @foreach ($locations as $location)
                                    <option value="{{ $location->LocationId }}">{{ $location->LocationName }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="toolbar-group">
                            <label>目的地</label>
                            <select name="location2" class="form-select">
                                <option value=""></option>
                                @foreach ($locations as $location)
                                    <option value="{{ $location->LocationId }}">{{ $location->LocationName }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="toolbar-group">
                            <label>交通工具</label>
                            <select name="traffic" class="form-select">
                                <option value=""></option>
                                @foreach ($traffics as $traffic)
                                    <option value="{{ $traffic->TrafficId }}">{{ $traffic->TrafficName }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="toolbar-group">
                            <label>人數</label>
                            <input type="number" min="1" max="50" name="cusnum" class="form-control">
                        </div>

                        <div class="toolbar-group" style="flex: 2 1 240px;">
                            <label>備註</label>
                            <input type="text" name="Ps" class="form-control">
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary px-4">新增</button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table erp-table">
                        <thead>
                            <tr>
                                <th>航班時間</th>
                                <th>出發地</th>
                                <th>目的地</th>
                                <th>交通工具</th>
                                <th>人數</th>
                                <th>備註</th>
                                <th style="width: 110px;">修改</th>
                                <th style="width: 90px;">刪除</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ordertraffics as $ordertraffic)
                                <tr>
                                    <form action="{{ route('ticket.update', $ordertraffic->OrderTrafficId) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="type" value="ordertraffic">

                                        <td>
                                            <input type="text" name="date" value="{{ $ordertraffic->Date }}" class="form-control">
                                        </td>
                                        <td>
                                            <select name="LocationId" class="form-select">
                                                <option></option>
                                                @foreach ($locations as $location)
                                                    <option value="{{ $location->LocationId }}" {{ $ordertraffic->LocationId == $location->LocationId ? 'selected' : '' }}>
                                                        {{ $location->LocationName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="LocationId2" class="form-select">
                                                <option></option>
                                                @foreach ($locations as $location)
                                                    <option value="{{ $location->LocationId }}" {{ $ordertraffic->LocationId2 == $location->LocationId ? 'selected' : '' }}>
                                                        {{ $location->LocationName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="TrafficId" class="form-select">
                                                <option></option>
                                                @foreach ($traffics as $traffic)
                                                    <option value="{{ $traffic->TrafficId }}" {{ $ordertraffic->TrafficId == $traffic->TrafficId ? 'selected' : '' }}>
                                                        {{ $traffic->TrafficName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="cusnum" min="1" value="{{ $ordertraffic->cusnum }}" class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" name="Ps" value="{{ $ordertraffic->Ps }}" class="form-control">
                                        </td>
                                        <td class="text-center">
                                            <button type="submit" class="btn btn-primary btn-sm">修改</button>
                                        </td>
                                    </form>
                                    <td class="text-center">
                                        <form action="{{ route('ticket.destroy', $ordertraffic->OrderTrafficId) }}" method="POST" class="mb-0">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="tableId" value="OrderTrafficId">
                                            <input type="hidden" name="tableName" value="ordertraffic">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('確定要刪除嗎？')">刪除</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="empty-state">目前尚無交通資料</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="section-card">
            <div class="section-header">
                <h3>活動行程 / 應收費用</h3>
                <p>新增此訂單的行程項目與應收費用資料。</p>
            </div>

            <div class="section-body">
                <form action="{{ route('ticket.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="OrderId" value="{{ $OrderId }}">
                    <input type="hidden" name="type" value="receivable">

                    <div class="table-toolbar">
                        <div class="toolbar-group" style="min-width: 240px;">
                            <label>行程</label>
                            <select name="itemid" class="form-select">
                                <option></option>
                                @foreach ($items as $item)
                                    <option value="{{ $item->ItemId }}">{{ $item->ItemName }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="toolbar-group">
                            <label>單價</label>
                            <input type="text" name="price" class="form-control">
                        </div>

                        <div class="toolbar-group">
                            <label>人數</label>
                            <input type="number" name="number" class="form-control">
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary px-4">新增</button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table erp-table">
                        <thead>
                            <tr>
                                <th style="width: 90px;">序號</th>
                                <th>行程</th>
                                <th>單價</th>
                                <th>人數</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($receivables as $index => $receivable)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $receivable->ItemName }}</td>
                                    <td>{{ $receivable->Price }}</td>
                                    <td>{{ $receivable->Number }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="empty-state">目前尚無應收費用資料</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('ticketwork.step_final') }}">
            @csrf
            <input type="hidden" name="type" value="customer">
            <input type="hidden" name="OrderId" value="{{ $OrderId }}">

            <div class="section-card">
                <div class="section-header">
                    <h3>旅客資料</h3>
                    <p>依旅客人數建立旅客基本資料與票種設定。</p>
                </div>

                <div class="section-body">
                    @for ($i = 0; $i < $CusNum; $i++)
                        <div class="customer-grid">
                            <div class="field-span-6">
                                <div class="customer-card-title">旅客 {{ $i + 1 }}</div>
                            </div>

                            <div class="form-block">
                                <label>姓名</label>
                                <input type="text" name="Name[{{ $i }}]" class="form-control">
                            </div>

                            <div class="form-block">
                                <label>生日</label>
                                <input type="text" name="Birthday[{{ $i }}]" class="form-control">
                            </div>

                            <div class="form-block">
                                <label>身份證號</label>
                                <input type="text" name="ID[{{ $i }}]" class="form-control">
                            </div>

                            <div class="form-block">
                                <label>性別</label>
                                <select name="Sex[{{ $i }}]" class="form-select">
                                    <option value="1">男</option>
                                    <option value="2">女</option>
                                </select>
                            </div>

                            <div class="form-block">
                                <label>票種</label>
                                <select name="TicketType[{{ $i }}]" class="form-select">
                                    <option value="2">成人全票</option>
                                    <option value="1">兒童票</option>
                                    <option value="3">敬老票</option>
                                    <option value="4">嬰幼票</option>
                                    <option value="5">殘障票</option>
                                    <option value="5">殘陪票</option>
                                </select>
                            </div>

                            <div class="form-block">
                                <label>電話</label>
                                <input type="text" name="Phone[{{ $i }}]" class="form-control">
                            </div>

                            <div class="form-block field-span-6">
                                <label>備註</label>
                                <input type="text" name="Ps[{{ $i }}]" class="form-control">
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            <div class="section-card">
                <div class="section-header">
                    <h3>訂金期限</h3>
                    <p>設定訂金到期日與金額後完成建檔。</p>
                </div>

                <div class="section-body">
                    <div class="deposit-box">
                        <div class="form-block">
                            <label>日期</label>
                            <input type="date" name="date" class="form-control">
                        </div>

                        <div class="form-block">
                            <label>金額</label>
                            <input type="number" name="price" class="form-control">
                        </div>

                        <div class="deposit-action text-md-right">
                            <button type="submit" class="btn btn-primary px-4">完成建檔</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>
@endsection
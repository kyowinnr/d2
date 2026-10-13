@extends('layouts.app')

@section('title', '布袋車趟統計')

@push('styles')
<style>
    /* ===== 凍結表頭 ===== */
.erp-table thead th {
    position: sticky;
    top: 0;
    z-index: 20;
}

/* ===== 凍結最左欄（日期） ===== */
.erp-table .date-cell,
.erp-table thead th:first-child,
.erp-table tfoot th:first-child {
    position: sticky;
    left: 0;
    z-index: 25;
    background: #f8fafc;
}

/* 表頭左上角要最高層 */
.erp-table thead th:first-child {
    z-index: 30;
}

/* 避免被覆蓋的陰影效果（可選，會更像ERP） */
.erp-table .date-cell::after,
.erp-table thead th:first-child::after {
    content: '';
    position: absolute;
    right: -4px;
    top: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(to right, rgba(0,0,0,0.08), transparent);
}

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
        min-width: 180px;
        flex: 0 0 180px;
    }

    .table-toolbar label {
        display: block;
        margin-bottom: 6px;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
    }

    .form-control {
        border: 1px solid #cfd8e3;
        min-height: 40px;
    }

    .form-control:focus {
        border-color: #4f8cff;
        box-shadow: 0 0 0 0.15rem rgba(79, 140, 255, 0.15);
    }

    .erp-table {
        margin-bottom: 0;
        vertical-align: middle;
        background: #ffffff;
    }

    .erp-table thead th,
    .erp-table tfoot th {
        background: #e9edf3;
        color: #334155;
        font-weight: 700;
        font-size: 14px;
        border-bottom: 1px solid #d7dee7;
        padding: 12px 10px;
        text-align: center;
        white-space: nowrap;
    }

    .erp-table tbody td {
        padding: 11px 10px;
        border-color: #e5e7eb;
        vertical-align: middle;
        color: #1f2937;
        text-align: center;
        background: #ffffff;
    }

    .erp-table tbody tr:hover td {
        background: #f8fbff;
    }

    .erp-table .date-cell {
        font-weight: 600;
        color: #334155;
        background: #f8fafc;
        white-space: nowrap;
    }

    .erp-table .group-separator {
        width: 14px;
        min-width: 14px;
        background: #f1f5f9 !important;
        border-left: 1px solid #dbe3ea;
        border-right: 1px solid #dbe3ea;
        padding: 0;
    }

    .group-header {
        font-weight: 700;
        border-bottom: 1px solid #d7dee7 !important;
    }

    .group-bumah {
        background: #edf7e8 !important;
        color: #355e2b !important;
    }

    .group-mabu {
        background: #f4edf7 !important;
        color: #654a6c !important;
    }

    .group-longbu {
        background: #fff8db !important;
        color: #7a6300 !important;
    }

    .count-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        min-height: 32px;
        padding: 4px 8px;
        border-radius: 8px;
        text-decoration: none;
        color: #1f2937;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .count-link:hover {
        text-decoration: none;
        color: #2563eb;
        background: rgba(79, 140, 255, 0.08);
    }

    .empty-state {
        text-align: center;
        padding: 28px 16px;
        color: #6b7280;
        background: #f8fafc;
    }

    .legend-text {
        font-size: 13px;
        color: #64748b;
        margin-top: 8px;
    }

    @media (max-width: 992px) {
        .section-header,
        .section-body {
            padding-left: 16px;
            padding-right: 16px;
        }

        .table-toolbar {
            padding: 14px;
        }
    }
</style>
@endpush

@section('content')
<div class="erp-page">
    <div class="container-fluid">
        <div class="section-card">
            <div class="section-header">
                <h3>布袋車趟統計</h3>
                <p>依年份與月份查看各路線車趟數量，點擊數字可開啟對應明細資料。</p>
            </div>

            <div class="section-body">
                <form action="{{ route('budai.index') }}" method="GET" class="table-toolbar">
                    <div class="toolbar-group">
                        <label for="year">年份</label>
                        <select name="year" id="year" class="form-control" onchange="this.form.submit()">
                            @foreach(range(date('Y'), 2011) as $year)
                                <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="toolbar-group">
                        <label for="month">月份</label>
                        <select name="month" id="month" class="form-control" onchange="this.form.submit()">
                            @foreach(range(3, 10) as $month)
                                <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                                    {{ $month }} 月
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>

                @if(isset($results))
                    <div class="table-responsive">
                        <table class="table erp-table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th colspan="5" class="group-header group-bumah">布馬</th>
                                    <th class="group-separator"></th>
                                    <th colspan="5" class="group-header group-mabu">馬布</th>
                                    <th class="group-separator"></th>
                                    <th colspan="5" class="group-header group-longbu">龍布</th>
                                </tr>
                                <tr>
                                    <th style="width: 110px;">日期</th>
                                    <th>鵲</th>
                                    <th>豹</th>
                                    <th>凱</th>
                                    <th>滿</th>
                                    <th>太</th>
                                    <th class="group-separator"></th>
                                    <th>鵲</th>
                                    <th>豹</th>
                                    <th>凱</th>
                                    <th>滿</th>
                                    <th>太</th>
                                    <th class="group-separator"></th>
                                    <th>鵲</th>
                                    <th>豹</th>
                                    <th>凱</th>
                                    <th>滿</th>
                                    <th>太</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($results as $date => $locations)
                                    <tr>
                                        <td class="date-cell">{{ $date }}</td>

                                        @foreach (['Location29'] as $location)
                                            @foreach ([32, 35, 34, 33, 74] as $trafficId)
                                                <td title="{{ ${'title' . $trafficId} }}" class="bg-{{ $trafficId }}">
                                                    <a href="{{ url('/output?traffic=' . $trafficId . '&location=29&date=' . $date . '&check=1') }}" target="_blank" class="count-link">
                                                        {{ $locations[$location][$trafficId] ?? 0 }}
                                                    </a>
                                                </td>
                                            @endforeach
                                        @endforeach

                                        <td class="group-separator"></td>

                                        @foreach (['Location30'] as $location)
                                            @foreach ([32, 35, 34, 33, 74] as $trafficId)
                                                <td title="{{ ${'title' . $trafficId} }}" class="bg-{{ $trafficId }}">
                                                    <a href="{{ url('/output?traffic=' . $trafficId . '&location=30&date=' . $date . '&check=1') }}" target="_blank" class="count-link">
                                                        {{ $locations[$location][$trafficId] ?? 0 }}
                                                    </a>
                                                </td>
                                            @endforeach
                                        @endforeach

                                        <td class="group-separator"></td>

                                        @foreach (['Location140'] as $location)
                                            @foreach ([32, 35, 34, 33, 74] as $trafficId)
                                                <td title="{{ ${'title' . $trafficId} }}" class="bg-{{ $trafficId }}">
                                                    <a href="{{ url('/output?traffic=' . $trafficId . '&location=140&date=' . $date . '&check=1') }}" target="_blank" class="count-link">
                                                        {{ $locations[$location][$trafficId] ?? 0 }}
                                                    </a>
                                                </td>
                                            @endforeach
                                        @endforeach
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="18" class="empty-state">目前查無資料</td>
                                    </tr>
                                @endforelse
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th>日期</th>
                                    <th>鵲</th>
                                    <th>豹</th>
                                    <th>凱</th>
                                    <th>滿</th>
                                    <th>太</th>
                                    <th class="group-separator"></th>
                                    <th>鵲</th>
                                    <th>豹</th>
                                    <th>凱</th>
                                    <th>滿</th>
                                    <th>太</th>
                                    <th class="group-separator"></th>
                                    <th>鵲</th>
                                    <th>豹</th>
                                    <th>凱</th>
                                    <th>滿</th>
                                    <th>太</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')

@push('styles')
<style>
    .table-responsive.sticky-table-wrap {
        position: relative;
        overflow: auto;
        max-height: 75vh;
    }

    .table-responsive.sticky-table-wrap .erp-table {
        min-width: 1200px;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-responsive.sticky-table-wrap .erp-table thead th {
        position: sticky;
        top: 0;
        z-index: 50;
        background: #e9edf3 !important;
    }

    .table-responsive.sticky-table-wrap .erp-table thead tr:nth-child(2) th {
        top: 49px;
        z-index: 55;
    }

    .table-responsive.sticky-table-wrap .erp-table th:first-child,
    .table-responsive.sticky-table-wrap .erp-table td:first-child {
        position: sticky;
        left: 0;
        z-index: 60;
        background: #f8fafc !important;
    }

    .table-responsive.sticky-table-wrap .erp-table thead tr:first-child th:first-child {
        z-index: 90;
        top: 0;
    }

    .table-responsive.sticky-table-wrap .erp-table thead tr:nth-child(2) th:first-child {
        z-index: 95;
        top: 49px;
    }

    .table-responsive.sticky-table-wrap .erp-table tfoot td:first-child,
    .table-responsive.sticky-table-wrap .erp-table tfoot th:first-child {
        position: sticky;
        left: 0;
        z-index: 40;
        background: #e9edf3 !important;
    }

    .table-responsive.sticky-table-wrap .erp-table th,
    .table-responsive.sticky-table-wrap .erp-table td {
        position: relative;
        white-space: nowrap;
    }

    .table-responsive.sticky-table-wrap .erp-table th:first-child::after,
    .table-responsive.sticky-table-wrap .erp-table td:first-child::after {
        content: '';
        position: absolute;
        top: 0;
        right: -4px;
        width: 4px;
        height: 100%;
        background: linear-gradient(to right, rgba(15, 23, 42, 0.14), transparent);
        pointer-events: none;
    }

    .table-responsive.sticky-table-wrap .erp-table tbody tr:hover td {
        background: #F9F900 !important;
    }

    .table-responsive.sticky-table-wrap .erp-table tbody tr:hover td:first-child {
        background: #F9F900 !important;
    }

    .table-responsive.sticky-table-wrap .erp-table tfoot tr td,
    .table-responsive.sticky-table-wrap .erp-table tfoot tr th {
        background: #e9edf3 !important;
        font-weight: 700;
    }

    .bus-gap-cell {
        background: #ffffff !important;
        border: none !important;
        min-width: 18px;
        width: 18px;
        z-index: 1 !important;
    }

    .table-responsive.sticky-table-wrap .erp-table thead .bus-gap-cell {
        background: #ffffff !important;
        z-index: 45 !important;
    }

    .table-responsive.sticky-table-wrap .erp-table tbody tr:hover .bus-gap-cell,
    .table-responsive.sticky-table-wrap .erp-table tfoot tr:hover .bus-gap-cell {
        background: #ffffff !important;
    }
</style>
@endpush

<div class="container-fluid px-0">

    <div class="section-card">
        <div class="section-header">
            <div class="section-title">
                <h3>接駁明細查詢</h3>
                <p>依年份與月份篩選接駁統計資料</p>
            </div>
        </div>

        <form action="{{ route('buslist.store') }}" method="POST">
            @csrf

            <div class="table-toolbar">
                <div class="table-toolbar-left">
                    <div style="min-width: 140px;">
                        <select name="year" id="year" class="form-control">
                            @foreach(range(date('Y'), 2014) as $y)
                                <option value="{{ $y }}" {{ (isset($year) && $year == $y) ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div style="min-width: 140px;">
                        <select name="month" id="month" class="form-control">
                            @foreach ($months as $m)
                                <option value="{{ $m }}" {{ (isset($month) && $month == $m) ? 'selected' : '' }}>
                                    {{ $m }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        送出
                    </button>
                </div>
            </div>
        </form>
    </div>

    @if (isset($dateRange36) && isset($dateRange37) && isset($dateRange39) && isset($dateRange40))
        <div class="section-card">
            <div class="section-header">
                <div class="section-title">
                    <h3>接駁統計總表</h3>
                    <p>南下 / 北上 / 嘉義 / 新營 數量彙整</p>
                </div>
            </div>

            <div class="table-responsive sticky-table-wrap">
                <table class="table erp-table mb-0">
                    <thead>
                        <tr>
                            <th rowspan="2" class="text-center align-middle">日期</th>

                            <th colspan="4" class="text-center">南下</th>
                            <th rowspan="2" class="bus-gap-cell"></th>

                            <th colspan="4" class="text-center">北上</th>
                            <th rowspan="2" class="bus-gap-cell"></th>

                            <th colspan="3" class="text-center">南下</th>
                            <th rowspan="2" class="bus-gap-cell"></th>

                            <th colspan="3" class="text-center">北上</th>
                        </tr>
                        <tr>
                            <th class="text-center">台中</th>
                            <th class="text-center">台北</th>
                            <th class="text-center">合計</th>
                            <th class="text-center">RQ</th>

                            <th class="text-center">台中</th>
                            <th class="text-center">台北</th>
                            <th class="text-center">合計</th>
                            <th class="text-center">RQ</th>

                            <th class="text-center">嘉義</th>
                            <th class="text-center">新營</th>
                            <th class="text-center">合計</th>

                            <th class="text-center">嘉義</th>
                            <th class="text-center">新營</th>
                            <th class="text-center">合計</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($dateRange36 as $date => $cusnum36)
                            <tr>
                                <td class="text-center font-weight-bold">{{ $date }}</td>

                                <td class="text-center" style="background-color:#e8f5e9; font-weight:700;">{{ $dateRange36[$date] ?? 0 }}</td>
                                <td class="text-center" style="background-color:#e8f5e9; font-weight:700;">{{ $dateRange39[$date] ?? 0 }}</td>
                                <td class="text-center" style="background-color:#fff8db; font-weight:700;">{{ ($dateRange36[$date] ?? 0) + ($dateRange39[$date] ?? 0) }}</td>
                                <td class="text-center" style="background-color:#eef4ff; font-weight:700;">{{ $dateRange1[$date] ?? 0 }}</td>

                                <td class="bus-gap-cell"></td>

                                <td class="text-center" style="background-color:#e8f5e9; font-weight:700;">{{ $dateRange37[$date] ?? 0 }}</td>
                                <td class="text-center" style="background-color:#e8f5e9; font-weight:700;">{{ $dateRange40[$date] ?? 0 }}</td>
                                <td class="text-center" style="background-color:#fff8db; font-weight:700;">{{ ($dateRange37[$date] ?? 0) + ($dateRange40[$date] ?? 0) }}</td>
                                <td class="text-center" style="background-color:#eef4ff; font-weight:700;">{{ $dateRange7[$date] ?? 0 }}</td>

                                <td class="bus-gap-cell"></td>

                                <td class="text-center" style="background-color:#e8f5e9; font-weight:700;">{{ $dateRange108[$date] ?? 0 }}</td>
                                <td class="text-center" style="background-color:#e8f5e9; font-weight:700;">{{ $dateRange113[$date] ?? 0 }}</td>
                                <td class="text-center" style="background-color:#fff8db; font-weight:700;">{{ ($dateRange108[$date] ?? 0) + ($dateRange113[$date] ?? 0) }}</td>

                                <td class="bus-gap-cell"></td>

                                <td class="text-center" style="background-color:#e8f5e9; font-weight:700;">{{ $dateRange109[$date] ?? 0 }}</td>
                                <td class="text-center" style="background-color:#e8f5e9; font-weight:700;">{{ $dateRange114[$date] ?? 0 }}</td>
                                <td class="text-center" style="background-color:#fff8db; font-weight:700;">{{ ($dateRange109[$date] ?? 0) + ($dateRange114[$date] ?? 0) }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <td class="text-center font-weight-bold">合計</td>

                            <td class="text-center font-weight-bold">{{ array_sum($dateRange36) }}</td>
                            <td class="text-center font-weight-bold">{{ array_sum($dateRange39) }}</td>
                            <td class="text-center font-weight-bold">{{ array_sum($dateRange36) + array_sum($dateRange39) }}</td>
                            <td class="text-center font-weight-bold">{{ array_sum($dateRange1) }}</td>

                            <td class="bus-gap-cell"></td>

                            <td class="text-center font-weight-bold">{{ array_sum($dateRange37) }}</td>
                            <td class="text-center font-weight-bold">{{ array_sum($dateRange40) }}</td>
                            <td class="text-center font-weight-bold">{{ array_sum($dateRange37) + array_sum($dateRange40) }}</td>
                            <td class="text-center font-weight-bold">{{ array_sum($dateRange7) }}</td>

                            <td class="bus-gap-cell"></td>

                            <td class="text-center font-weight-bold">{{ array_sum($dateRange108) }}</td>
                            <td class="text-center font-weight-bold">{{ array_sum($dateRange113) }}</td>
                            <td class="text-center font-weight-bold">{{ array_sum($dateRange108) + array_sum($dateRange113) }}</td>

                            <td class="bus-gap-cell"></td>

                            <td class="text-center font-weight-bold">{{ array_sum($dateRange109) }}</td>
                            <td class="text-center font-weight-bold">{{ array_sum($dateRange114) }}</td>
                            <td class="text-center font-weight-bold">{{ array_sum($dateRange109) + array_sum($dateRange114) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @endif

</div>
@endsection
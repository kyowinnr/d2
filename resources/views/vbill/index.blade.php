@extends('layouts.app')

@push('styles')
<style>
    body {
        background: #d0d0d0;
        font-family: "Microsoft JhengHei", sans-serif;
    }

    .page-wrap {
        margin: 20px 5%;
    }

    .report-shell {
        background: #ffffff;
        border: 1px solid #dde3e8;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
    }

    .report-toolbar {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 14px 16px;
        border-bottom: 1px solid #e5eaf0;
        background: #f7f9fb;
    }

    .report-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 36px;
        padding: 0 12px;
        border: 1px solid #d6dee6;
        border-radius: 8px;
        background: #f8fafc;
        color: #334155;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
    }

    .report-btn:hover {
        background: #fff8db;
        border-color: #f2e3a7;
        color: #92400e;
    }

    .report-area {
        background: #ffffff;
        padding: 26px 28px 30px;
    }

    .report-header {
        margin-bottom: 18px;
        text-align: center;
    }

    .report-title {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
        letter-spacing: 1px;
    }

    .report-subtitle {
        margin-top: 8px;
        font-size: 14px;
        color: #475569;
    }

    .report-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: 16px;
        padding: 12px 14px;
        border: 1px solid #dde3e8;
        background: #f9fbfc;
        border-radius: 10px;
        font-size: 13px;
        color: #334155;
    }

    .report-meta-left,
    .report-meta-right {
        display: flex;
        gap: 18px;
        align-items: center;
        flex-wrap: wrap;
    }

    .meta-label {
        color: #64748b;
        margin-right: 6px;
    }

    .erp-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        font-size: 13px;
        color: #1f2937;
    }

    .erp-table th,
    .erp-table td {
        border: 1px solid #bfc8d2;
        padding: 8px 6px;
        text-align: center;
        vertical-align: middle;
        word-break: break-word;
    }

    .erp-table thead th {
        background: #e9edf3;
        color: #334155;
        font-weight: 700;
    }

    .erp-table tbody td.text-left,
    .erp-table tfoot td.text-left {
        text-align: left;
    }

    .erp-table tfoot td {
        background: #f4f7fb;
        font-weight: 700;
    }

    .number-cell {
        text-align: right;
        padding-right: 10px !important;
        font-variant-numeric: tabular-nums;
    }

    @media print {
        @page {
            size: A4 portrait;
            margin: 10mm;
        }

        html, body {
            background: #ffffff !important;
            margin: 0;
            padding: 0;
        }

        body * {
            visibility: hidden;
        }

        .report-area,
        .report-area * {
            visibility: visible;
        }

        .report-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            padding: 0;
            margin: 0;
        }

        .report-shell {
            border: none;
            box-shadow: none;
        }

        .report-toolbar {
            display: none !important;
        }

        .report-title {
            font-size: 22px;
        }

        .report-subtitle {
            font-size: 12px;
        }

        .report-meta {
            border: 1px solid #999;
            background: #fff !important;
            border-radius: 0;
            padding: 8px 10px;
            font-size: 12px;
        }

        .erp-table {
            font-size: 12px;
        }

        .erp-table th,
        .erp-table td {
            border: 1px solid #666 !important;
            padding: 6px 4px;
        }

        .erp-table thead th,
        .erp-table tfoot td {
            background: #fff !important;
        }
    }
</style>
@endpush

@section('content')
<div class="page-wrap">
    <div class="report-shell">
        <div class="report-toolbar">
            <button type="button" class="report-btn" onclick="downloadJPG()">下載 JPG</button>
            <button type="button" class="report-btn" onclick="window.print()">列印</button>
        </div>

        <div class="report-area" id="printArea">
            <div class="report-header">
                <h1 class="report-title">證件費用明細表</h1>
                <div class="report-subtitle">
                    {{ $order->OrderStart }} 至 {{ $order->OrderCome }}　{{ $order->GroupName }}
                </div>
            </div>

            <div class="report-meta">
                <div class="report-meta-left">
                    <div><span class="meta-label">團號</span>{{ $order->OrderId ?? '' }}</div>
                    <div><span class="meta-label">類型</span>{{ $type == 1 ? '完整帳務' : '應收明細' }}</div>
                </div>
                <div class="report-meta-right">
                    <div><span class="meta-label">列印日期</span>{{ now()->format('Y-m-d') }}</div>
                </div>
            </div>

            <table class="erp-table">
                <thead>
                    <tr>
                        <th style="width:8%;">序號</th>
                        <th style="width:20%;">姓名</th>
                        <th style="width:24%;">辦證種類</th>
                        <th style="width:16%;">應收</th>
                        @if ($type == 1)
                            <th style="width:16%;">已收</th>
                            <th style="width:16%;">已付</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $customer->Name }}</td>
                        <td class="text-left">{{ $customer->visa ?? '' }}</td>
                        <td class="number-cell">{{ isset($customer->total_income2) ? number_format($customer->total_income2, 0) : '' }}</td>
                        @if ($type == 1)
                            <td class="number-cell">{{ isset($customer->total_income) ? number_format($customer->total_income, 0) : '' }}</td>
                            <td class="number-cell">{{ isset($customer->total_exp) ? number_format($customer->total_exp, 0) : '' }}</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3">總計</td>
                        <td class="number-cell">{{ number_format($customers->sum('total_income2'), 0) }}</td>
                        @if ($type == 1)
                            <td class="number-cell">{{ number_format($customers->sum('total_income'), 0) }}</td>
                            <td class="number-cell">{{ number_format($customers->sum('total_exp'), 0) }}</td>
                        @endif
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
function downloadJPG() {
    const target = document.getElementById('printArea');

    html2canvas(target, {
        scale: 2,
        useCORS: true,
        backgroundColor: '#ffffff'
    }).then(canvas => {
        const link = document.createElement('a');
        link.download = 'visa-report-{{ $order->OrderId ?? "export" }}.jpg';
        link.href = canvas.toDataURL('image/jpeg', 0.95);
        link.click();
    });
}
</script>
@endsection
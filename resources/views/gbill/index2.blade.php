@extends('layouts.app')

@push('styles')
<style>
    body {
        background: #d0d0d0;
        font-family: "PMingLiU", "MingLiU", "Microsoft JhengHei", serif;
        color: #222;
    }

    .page-wrap {
        padding: 24px 5% 36px;
    }

    .print-shell {
        max-width: 920px;
        margin: 0 auto;
        background: #ffffff;
        border: 1px solid #cfcfcf;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.06);
    }

    .print-toolbar {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 12px 16px;
        border-bottom: 1px solid #d9d9d9;
        background: #f7f7f7;
    }

    .btn-print {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 88px;
        height: 36px;
        padding: 0 14px;
        border: 1px solid #c8c8c8;
        background: #fff;
        color: #222;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
    }

    .btn-print:hover {
        background: #fff8db;
    }

    .invoice-area {
        padding: 22px 26px 28px;
        background: #fff;
    }

    .company-header {
        text-align: center;
        line-height: 1.45;
        margin-bottom: 10px;
    }

    .company-name {
        font-size: 28px;
        font-weight: 700;
        letter-spacing: 2px;
    }

    .company-address,
    .company-contact {
        font-size: 14px;
    }

    .doc-title {
        text-align: center;
        font-size: 22px;
        font-weight: 700;
        letter-spacing: 10px;
        margin: 8px 0 12px;
    }

    .header-grid {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 18px;
        margin-bottom: 8px;
    }

    .left-meta,
    .right-meta {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .left-meta td,
    .right-meta td {
        padding: 2px 4px;
        vertical-align: top;
    }

    .label {
        width: 54px;
        white-space: nowrap;
    }

    .line-box {
        min-height: 18px;
        border-bottom: 1px solid #999;
    }

    .main-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        margin-top: 8px;
        font-size: 14px;
    }

    .main-table th,
    .main-table td {
        border-top: 1px solid #888;
        border-bottom: 1px solid #888;
        padding: 6px 8px;
        vertical-align: top;
    }

    .main-table thead th {
        text-align: center;
        font-weight: 700;
    }

    .col-item { width: 44%; }
    .col-desc { width: 20%; }
    .col-amount { width: 14%; }
    .col-note { width: 22%; }

    .amount {
        text-align: right;
        white-space: nowrap;
        font-variant-numeric: tabular-nums;
    }

    .note-cell {
        white-space: pre-line;
        line-height: 1.35;
    }

    .dash {
        letter-spacing: 1px;
        color: #444;
    }

    .summary-row td {
        font-weight: 700;
    }

    .bottom-block {
        margin-top: 18px;
        font-size: 14px;
    }

    .bottom-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .bottom-table td {
        padding: 4px 6px;
        border-bottom: 1px solid #999;
        vertical-align: middle;
    }

    .bank-line {
        padding: 8px 0 10px;
        border-bottom: 1px solid #999;
        line-height: 1.7;
    }

    .sign-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        margin-top: 10px;
        font-size: 14px;
    }

    .sign-table td {
        padding: 8px 6px;
        border-bottom: 1px solid #999;
        text-align: center;
    }

    .footer-meta {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr;
        gap: 10px;
        margin-top: 16px;
        font-size: 14px;
    }

    .footer-meta div {
        border-bottom: 1px solid #999;
        padding-bottom: 6px;
    }

    @media print {
        @page {
            size: A4 portrait;
            margin: 8mm;
        }

        html, body {
            background: #fff !important;
            margin: 0;
            padding: 0;
        }

        body * {
            visibility: hidden;
        }

        .invoice-area,
        .invoice-area * {
            visibility: visible;
        }

        .invoice-area {
            position: absolute;
            inset: 0;
            padding: 0;
            margin: 0;
        }

        .print-shell {
            border: none;
            box-shadow: none;
        }

        .print-toolbar {
            display: none !important;
        }

        .company-name { font-size: 24px; }
        .doc-title { font-size: 20px; }
        .company-address,
        .company-contact,
        .left-meta,
        .right-meta,
        .main-table,
        .bottom-block,
        .sign-table,
        .footer-meta {
            font-size: 12px;
        }
    }
</style>
@endpush

@section('content')
@php
    $safeTotalIncome2 = (float)($total_income2 ?? 0);
    $safeEnd = (float)($total['end'] ?? 0);

    $noteLines = [];
    foreach ($receivableoffs as $receivableoff) {
        $itemLabel = '';
        foreach ($items as $itemId => $itemName) {
            if ($receivableoff->RItemId == $itemId) {
                $itemLabel = $itemName;
                break;
            }
        }
        $noteLines[] = $itemLabel . ' ' . $receivableoff->Price . '×' . $receivableoff->Number;
    }

    foreach ($okreces as $okrece) {
        $noteLines[] = ($okrece->Date ?? '') . ' ' . ($okrece->Ps ?? '') . ' ' . number_format((float)($okrece->Price ?? 0), 0);
    }

    $noteLines[] = '----------------';
    $noteLines[] = '餘額 ' . number_format($safeEnd, 0);
@endphp

<div class="page-wrap">
    <div class="print-shell">
        <div class="print-toolbar">
            <button type="button" class="btn-print" onclick="downloadJPG()">下載 JPG</button>
            <button type="button" class="btn-print" onclick="window.print()">列印</button>
        </div>

        <div class="invoice-area" id="printArea">
            <div class="company-header">
                <div class="company-name">麗誠旅行社有限公司</div>
                <div class="company-address">台中市南屯區五權西路二段666號14F-5</div>
                <div class="company-contact">TEL: 04-3704-0306　FAX: 04-2381-5775</div>
            </div>

            <div class="doc-title">請　款　單</div>

            <div class="header-grid">
                <table class="left-meta">
                    <tr>
                        <td class="label">客戶:</td>
                        <td><div class="line-box">{{ $moneys->GroupName ?? '' }}</div></td>
                    </tr>
                    <tr>
                        <td class="label">電話:</td>
                        <td><div class="line-box">{{ $moneys->OrderTel ?? '' }}</div></td>
                    </tr>
                    <tr>
                        <td class="label">地址:</td>
                        <td><div class="line-box">{{ $moneys->OrderBuss ?? '' }}</div></td>
                    </tr>
                </table>

                <table class="right-meta">
                    <tr>
                        <td class="label">單　號:</td>
                        <td>{{ $moneys->OrderId ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">日　期:</td>
                        <td>{{ $moneys->OrderStart ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">團　號:</td>
                        <td>{{ $moneys->OrderId ?? '' }}</td>
                    </tr>
                </table>
            </div>

            <table class="main-table">
                <thead>
                    <tr>
                        <th class="col-item">摘　　　　要</th>
                        <th class="col-desc">數　　　量</th>
                        <th class="col-amount">金　　　額</th>
                        <th class="col-note">備　　　　　註</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($receivables as $receivable)
                        @php
                            $itemLabel = '';
                            foreach ($items as $itemId => $itemName) {
                                if ($receivable->RItemId == $itemId) {
                                    $itemLabel = $itemName;
                                    break;
                                }
                            }
                            $subtotal = (float)($receivable->subtotal ?? 0);
                        @endphp
                        <tr>
                            <td>{{ $itemLabel }}</td>
                            <td>({{ $receivable->Number }}) {{ (float)$receivable->Price }}</td>
                            <td class="amount">{{ number_format($subtotal, 0) }}</td>
                            @if ($loop->first)
                                <td class="note-cell" rowspan="{{ max(count($receivables), 1) }}">{{ implode("\n", $noteLines) }}</td>
                            @endif
                        </tr>
                    @endforeach

                    @if(count($receivables) === 0)
                        <tr>
                            <td>證件費用</td>
                            <td></td>
                            <td class="amount">{{ number_format($safeTotalIncome2, 0) }}</td>
                            <td class="note-cell">{{ implode("\n", $noteLines) }}</td>
                        </tr>
                    @endif

                    <tr class="summary-row">
                        <td>證件費合計</td>
                        <td></td>
                        <td class="amount">{{ number_format($safeTotalIncome2, 0) }}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

            <div class="bottom-block">
                <table class="bottom-table">
                    <tr>
                        <td style="width:18%;">到期日:</td>
                        <td style="width:18%;">支票號碼:</td>
                        <td style="width:18%;">付款行別:</td>
                        <td style="width:18%;">信用卡號:</td>
                        <td style="width:28%; text-align:right;">應收金額: {{ number_format($safeEnd, 0) }}</td>
                    </tr>
                </table>

                <div class="bank-line">
                    支票付款請開立：麗誠旅行社有限公司 或 禁止背書轉讓
                </div>

                <table class="sign-table">
                    <tr>
                        <td>製　表</td>
                        <td>覆　核</td>
                        <td>客戶確認</td>
                    </tr>
                </table>

                <div class="footer-meta">
                    <div>現　金日</div>
                    <div>匯　款日</div>
                </div>
            </div>
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
        link.download = 'invoice-{{ $moneys->OrderId ?? "report" }}.jpg';
        link.href = canvas.toDataURL('image/jpeg', 0.95);
        link.click();
    });
}
</script>
@endsection
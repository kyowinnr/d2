```php
@extends('layouts.app')

@push('styles')
<style>
    body {
        background: #d0d0d0;
        font-family: "Microsoft JhengHei", "PingFang TC", sans-serif;
        color: #1f2937;
    }

    .page-wrap {
        padding: 24px 5% 36px;
    }

    .print-shell {
        max-width: 960px;
        margin: 0 auto;
        background: #ffffff;
        border: 1px solid #d8e1ea;
        border-radius: 14px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .print-toolbar {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 14px 18px;
        border-bottom: 1px solid #e5eaf0;
        background: #f7f9fb;
    }

    .btn-print {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 88px;
        height: 38px;
        padding: 0 16px;
        border: 1px solid #d6dee6;
        border-radius: 8px;
        background: #f8fafc;
        color: #334155;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
    }

    .btn-print:hover {
        background: #fff8db;
        border-color: #f2e3a7;
        color: #92400e;
    }

    .print-area {
        padding: 34px 38px 40px;
        background: #ffffff;
    }

    .report-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 24px;
        padding-bottom: 18px;
        border-bottom: 2px solid #cfd8e3;
        margin-bottom: 18px;
    }

    .company-block {
        flex: 1;
    }

    .company-name {
        font-size: 28px;
        font-weight: 700;
        letter-spacing: 2px;
        color: #111827;
        margin-bottom: 6px;
    }

    .company-en {
        font-size: 13px;
        color: #64748b;
        letter-spacing: 1px;
        margin-bottom: 10px;
    }

    .company-sub {
        font-size: 14px;
        color: #334155;
        line-height: 1.8;
    }

    .doc-block {
        min-width: 220px;
        text-align: right;
    }

    .doc-title {
        font-size: 24px;
        font-weight: 700;
        color: #0f172a;
        letter-spacing: 2px;
        margin-bottom: 10px;
    }

    .doc-meta {
        font-size: 13px;
        color: #475569;
        line-height: 1.8;
    }

    .info-panel {
        border: 1px solid #d8e1ea;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .info-panel-header {
        background: #eef3f8;
        padding: 10px 14px;
        font-size: 14px;
        font-weight: 700;
        color: #334155;
        border-bottom: 1px solid #d8e1ea;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0;
    }

    .info-item {
        display: flex;
        min-height: 46px;
        border-right: 1px solid #e5eaf0;
        border-bottom: 1px solid #e5eaf0;
    }

    .info-item:nth-child(2n) {
        border-right: none;
    }

    .info-item:nth-last-child(-n+2) {
        border-bottom: none;
    }

    .info-label {
        width: 120px;
        flex-shrink: 0;
        background: #f8fafc;
        padding: 12px 14px;
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        border-right: 1px solid #e5eaf0;
    }

    .info-value {
        flex: 1;
        padding: 12px 14px;
        font-size: 14px;
        font-weight: 700;
        color: #1f2937;
    }

    .report-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        margin-top: 8px;
        border: 1px solid #cfd8e3;
    }

    .report-table th,
    .report-table td {
        border: 1px solid #cfd8e3;
        padding: 10px 12px;
        font-size: 14px;
        vertical-align: middle;
    }

    .report-table thead th {
        background: #e9edf3;
        color: #334155;
        font-weight: 700;
        text-align: center;
    }

    .section-row th {
        background: #f4f7fb;
        color: #1f2937;
        text-align: left;
        font-size: 15px;
        font-weight: 700;
    }

    .text-right {
        text-align: right;
    }

    .text-center {
        text-align: center;
    }

    .amount {
        font-variant-numeric: tabular-nums;
        letter-spacing: 0.3px;
    }

    .amount-negative {
        color: #b42318;
        font-weight: 700;
    }

    .amount-positive {
        color: #111827;
        font-weight: 700;
    }

    .summary-row td {
        background: #f8fafc;
        font-weight: 700;
    }

    .highlight-row td {
        background: #fffdf1;
        font-weight: 700;
    }

    .bank-box {
        margin-top: 22px;
        border: 1px solid #d8e1ea;
        border-radius: 12px;
        overflow: hidden;
    }

    .bank-title {
        background: #eef3f8;
        padding: 10px 14px;
        font-size: 14px;
        font-weight: 700;
        color: #334155;
        border-bottom: 1px solid #d8e1ea;
    }

    .bank-content {
        padding: 16px 18px;
        font-size: 14px;
        line-height: 1.9;
        font-weight: 700;
        color: #1f2937;
    }

    .sign-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-top: 36px;
    }

    .sign-box {
        padding-top: 26px;
        border-top: 1px solid #94a3b8;
        text-align: center;
        font-size: 14px;
        color: #334155;
        font-weight: 700;
    }

    @media print {
        @page {
            size: A4 portrait;
            margin: 10mm;
        }

        html,
        body {
            background: #ffffff !important;
            margin: 0;
            padding: 0;
        }

        body * {
            visibility: hidden;
        }

        .print-area,
        .print-area * {
            visibility: visible;
        }

        .print-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
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

        .company-name {
            font-size: 24px;
        }

        .doc-title {
            font-size: 22px;
        }

        .report-table th,
        .report-table td {
            font-size: 12px;
            padding: 8px 9px;
            border-color: #666 !important;
        }

        .report-table thead th,
        .section-row th,
        .info-panel-header,
        .bank-title {
            background: #ffffff !important;
        }

        .info-panel,
        .bank-box,
        .report-table {
            border-color: #666 !important;
        }

        .info-item,
        .info-label,
        .info-value {
            border-color: #999 !important;
        }

        .summary-row td,
        .highlight-row td {
            background: #ffffff !important;
        }

        .amount-negative,
        .amount-positive {
            color: #111827 !important;
        }
    }
</style>
@endpush

@section('content')

@php
    $safeTotalIncome2 = (float)($total_income2 ?? 0);
    $safeEnd = (float)($total['end'] ?? 0);

    /*
     * 計算應收款項合計
     * = 所有應收款 subtotal + 證件費
     */
    $receivablesTotal = $receivables->sum(function ($receivable) {
        return (float)($receivable->subtotal ?? 0);
    });

    $receivablesGrandTotal = $receivablesTotal + $safeTotalIncome2;

    function amountClass($value) {
        return ((float)$value < 0)
            ? 'amount-negative'
            : 'amount-positive';
    }
@endphp

<div class="page-wrap">
    <div class="print-shell">

        <div class="print-toolbar">
            <button type="button" class="btn-print" onclick="downloadJPG()">
                下載 JPG
            </button>

            <button type="button" class="btn-print" onclick="window.print()">
                列印
            </button>
        </div>

        <div class="print-area" id="printArea">

            <div class="report-head">

                <div class="company-block">
                    <div class="company-name">
                        麗誠旅行社有限公司
                    </div>

                    <div class="company-en">
                        LI CHENG TRAVEL SERVICE CO., LTD.
                    </div>

                    <div class="company-sub">
                        專業旅遊規劃｜團體行程設計｜證件代辦服務
                    </div>
                </div>

                <div class="doc-block">
                    <div class="doc-title">
                        團體請款明細
                    </div>

                    <div class="doc-meta">
                        文件日期：{{ now()->format('Y-m-d') }}<br>
                        訂單編號：{{ $moneys->OrderId ?? '' }}
                    </div>
                </div>

            </div>


            <div class="info-panel">

                <div class="info-panel-header">
                    案件資訊
                </div>

                <div class="info-grid">

                    <div class="info-item">
                        <div class="info-label">
                            團體名稱
                        </div>

                        <div class="info-value">
                            {{ $moneys->GroupName }}
                        </div>
                    </div>


                    <div class="info-item">
                        <div class="info-label">
                            出團日期
                        </div>

                        <div class="info-value">
                            {{ $moneys->OrderStart }}
                            至
                            {{ $moneys->OrderCome }}
                        </div>
                    </div>


                    <div class="info-item">
                        <div class="info-label">
                            聯絡人
                        </div>

                        <div class="info-value">
                            {{ $moneys->OrderCus }}
                        </div>
                    </div>


                    <div class="info-item">
                        <div class="info-label">
                            聯絡電話
                        </div>

                        <div class="info-value">
                            {{ $moneys->OrderTel }}
                        </div>
                    </div>


                    <div class="info-item">
                        <div class="info-label">
                            團體人數
                        </div>

                        <div class="info-value">
                            {{ $moneys->CusNum }} 人
                        </div>
                    </div>


                    <div class="info-item">
                        <div class="info-label">
                            請款項目
                        </div>

                        <div class="info-value">
                            團體旅遊 / 證件 / 帳務結算
                        </div>
                    </div>

                </div>
            </div>


            <table class="report-table">

                <thead>
                    <tr>
                        <th style="width:44%;">
                            摘要
                        </th>

                        <th style="width:24%;">
                            說明
                        </th>

                        <th style="width:32%;">
                            金額
                        </th>
                    </tr>
                </thead>


                <tbody>

                    {{-- 一、應收款項 --}}
                    <tr class="section-row">
                        <th colspan="3">
                            一、應收款項
                        </th>
                    </tr>


                    @foreach ($receivables as $receivable)

                        @php
                            $subtotal = (float)($receivable->subtotal ?? 0);
                        @endphp

                        <tr>

                            <td>
                                @foreach ($items as $itemId => $itemName)

                                    @if ($receivable->RItemId == $itemId)
                                        {{ $itemName }}
                                    @endif

                                @endforeach
                            </td>


                            <td class="text-center">
                                {{ $receivable->Price }}
                                ×
                                {{ $receivable->Number }}
                            </td>


                            <td class="text-right amount {{ amountClass($subtotal) }}">
                                {{ number_format($subtotal, 0) }}
                            </td>

                        </tr>

                    @endforeach


                    {{-- 證件費 --}}
                    <tr class="highlight-row">

                        <td>
                            證件費
                        </td>

                        <td class="text-center">
                        </td>

                        <td class="text-right amount {{ amountClass($safeTotalIncome2) }}">
                            {{ number_format($safeTotalIncome2, 0) }}
                        </td>

                    </tr>


                    {{-- 應收款項合計 --}}
                    <tr class="summary-row">

                        <td colspan="2">
                            應收款項合計
                        </td>

                        <td class="text-right amount">
                            {{ number_format($receivablesGrandTotal, 0) }}
                        </td>

                    </tr>


                    {{-- 二、應扣款項 --}}
                    <tr class="section-row">

                        <th colspan="3">
                            二、應扣款項
                        </th>

                    </tr>


                    @foreach ($receivableoffs as $receivableoff)

                        @php
                            $subtotalOff = (float)($receivableoff->subtotal ?? 0);
                        @endphp

                        <tr>

                            <td>

                                @foreach ($items as $itemId => $itemName)

                                    @if ($receivableoff->RItemId == $itemId)
                                        {{ $itemName }}
                                    @endif

                                @endforeach

                            </td>


                            <td class="text-center">
                                {{ $receivableoff->Price }}
                                ×
                                {{ $receivableoff->Number }}
                            </td>


                            <td class="text-right amount {{ amountClass($subtotalOff) }}">
                                {{ number_format($subtotalOff, 0) }}
                            </td>

                        </tr>

                    @endforeach


                    {{-- 三、已收帳款 --}}
                    <tr class="section-row">

                        <th colspan="3">
                            三、已收帳款
                        </th>

                    </tr>


                    @foreach ($okreces as $okrece)

                        @php
                            $okrecePrice = (float)($okrece->Price ?? 0);
                        @endphp

                        <tr>

                            <td>
                                {{ $okrece->Date }}
                            </td>

                            <td>
                                {{ $okrece->Ps }}
                            </td>

                            <td class="text-right amount {{ amountClass($okrecePrice) }}">
                                {{ number_format($okrecePrice, 0) }}
                            </td>

                        </tr>

                    @endforeach


                    {{-- 剩餘應收款 --}}
                    <tr class="summary-row">

                        <td colspan="2">
                            剩餘應收款
                        </td>

                        <td class="text-right amount">
                            {{ number_format($safeEnd, 0) }}
                        </td>

                    </tr>

                </tbody>

            </table>


            <div class="bank-box">

                <div class="bank-title">
                    匯款資訊
                </div>

                <div class="bank-content">

                    國泰世華銀行－文心分行（013）<br>

                    帳號：2150-3500-9988<br>

                    戶名：麗誠旅行社有限公司

                    <br><br>

                    匯款完成後，請來電通知，以利本公司儘速完成帳款核對與入帳作業。

                </div>

            </div>


            <div class="sign-row">

                <div class="sign-box">
                    客戶簽認
                </div>

                <div class="sign-box">
                    麗誠旅行社承辦
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

            link.download =
                'invoice-{{ $moneys->OrderId ?? "report" }}.jpg';

            link.href =
                canvas.toDataURL('image/jpeg', 0.95);

            link.click();

        });
    }
</script>

@endsection
```

這版的計算邏輯是：

**應收款項合計 = 原本所有應收款明細合計 + 證件費**

所以不會把「應扣款項」或「已收帳款」算進去。原程式的應收款明細本來就是逐筆使用 `subtotal` 顯示。

如果後面你要讓「剩餘應收款」也直接依照「應收款合計 − 應扣款 − 已收款」自動重新計算，我也可以再幫你把這個邏輯接起來。

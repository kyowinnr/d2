@extends('layouts.app')

@push('styles')
<style>
    body {
        background: #fff;
    }

    .print-wrap {
        width: 900px;
        margin: 20px auto;
        font-family: "Microsoft JhengHei", sans-serif;
        color: #000;
    }

    .print-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .print-table th,
    .print-table td {
        border: 1px solid #000;
        padding: 6px 8px;
    }

    .print-table th {
        background: #f5f5f5;
        font-weight: bold;
    }

    .section-title td,
    .section-title th {
        background: #eee;
        font-weight: bold;
        text-align: left;
    }

    .text-right {
        text-align: right;
    }

    .text-left {
        text-align: left;
    }

    .highlight td,
    .highlight th {
        background: #f0f0f0;
        font-weight: bold;
    }

    .total-final td,
    .total-final th {
        background: #e6f4ea;
        font-weight: bold;
    }

    .danger {
        color: #c00;
    }

    .btn-print {
        margin-bottom: 12px;
    }

    @media print {
        .no-print {
            display: none;
        }

        body {
            background: #fff;
        }
    }
</style>
@endpush

@section('content')
<div class="print-wrap">
    <table class="print-table">
        <tr>
            <th colspan="4" class="text-left">
                {{ $order->OrderStart }} 至 {{ $order->OrderCome }}
                &nbsp;&nbsp;&nbsp;
                {{ $order->GroupName }} - {{ $order->Name }}
            </th>
        </tr>

        <!-- 應收 -->
        <tr class="section-title">
            <td colspan="4">應收款項</td>
        </tr>
        <tr>
            <th class="text-left">品項</th>
            <th class="text-right">單價</th>
            <th class="text-right">數量</th>
            <th class="text-right">小計</th>
        </tr>

        @foreach ($receivables as $receivable)
        @php
            $receivablePrice = (float) ($receivable->Price ?? 0);
            $receivableNumber = (float) ($receivable->Number ?? 0);
            $receivableSubtotal = (float) ($receivable->subtotal ?? 0);
        @endphp
        <tr>
            <td>{{ $receivable->ItemName ?? '' }}</td>
            <td class="text-right">{{ number_format($receivablePrice, 0) }}</td>
            <td class="text-right">{{ rtrim(rtrim(number_format($receivableNumber, 2, '.', ''), '0'), '.') }}</td>
            <td class="text-right">{{ number_format($receivableSubtotal, 0) }}</td>
        </tr>
        @endforeach

        <tr>
            <td>證件費</td>
            <td></td>
            <td></td>
            <td class="text-right">{{ number_format((float)($total_income2 ?? 0), 0) }}</td>
        </tr>

        <tr class="highlight">
            <td>小計</td>
            <td></td>
            <td></td>
            <td class="text-right">{{ $total['rece'] ?? '0' }}</td>
        </tr>

        <!-- 應扣 -->
        <tr class="section-title">
            <td colspan="4">應扣款項</td>
        </tr>

        @foreach ($receivableoffs as $receivableoff)
        @php
            $receivableoffPrice = (float) ($receivableoff->Price ?? 0);
            $receivableoffNumber = (float) ($receivableoff->Number ?? 0);
            $receivableoffSubtotal = (float) ($receivableoff->subtotal ?? 0);
        @endphp
        <tr>
            <td>{{ $receivableoff->ItemName ?? '' }}</td>
            <td class="text-right">{{ number_format($receivableoffPrice, 0) }}</td>
            <td class="text-right">{{ rtrim(rtrim(number_format($receivableoffNumber, 2, '.', ''), '0'), '.') }}</td>
            <td class="text-right">{{ number_format($receivableoffSubtotal, 0) }}</td>
        </tr>
        @endforeach

        <tr class="highlight">
            <td>小計</td>
            <td></td>
            <td></td>
            <td class="text-right">{{ $total['receoff'] ?? '0' }}</td>
        </tr>

        <tr class="highlight">
            <td colspan="3" class="text-right">應收總團費合計</td>
            <td class="text-right">{{ $total['all'] ?? '0' }}</td>
        </tr>

        <!-- 已收 -->
        <tr class="section-title">
            <td colspan="4">已收帳款</td>
        </tr>

        @foreach ($okreces as $okrece)
        @php
            $okrecePrice = (float) ($okrece->Price ?? 0);
        @endphp
        <tr>
            <td>{{ $okrece->Date }}</td>
            <td colspan="2">{{ $okrece->Ps }}</td>
            <td class="text-right">{{ number_format($okrecePrice, 0) }}</td>
        </tr>
        @endforeach

        <tr class="highlight">
            <td>小計</td>
            <td colspan="2"></td>
            <td class="text-right">{{ $total['okrece'] ?? '0' }}</td>
        </tr>

        <tr class="total-final">
            <td colspan="3">剩餘應收款</td>
            <td class="text-right">{{ $total['end'] ?? '0' }}</td>
        </tr>

        <!-- 應付 -->
        <tr class="section-title">
            <td colspan="4">應付帳款</td>
        </tr>

        @foreach ($payables as $payable)
        @php
            $payablePrice = (float) ($payable->Price ?? 0);
            $payableNumber = (float) ($payable->Number ?? 0);
            $payableSubtotal = (float) ($payable->subtotal ?? 0);
        @endphp
        <tr>
            <td>{{ $payable->ItemName ?? '' }}</td>
            <td class="text-right">{{ number_format($payablePrice, 0) }}</td>
            <td class="text-right">{{ rtrim(rtrim(number_format($payableNumber, 2, '.', ''), '0'), '.') }}</td>
            <td class="text-right">{{ number_format($payableSubtotal, 0) }}</td>
        </tr>
        @endforeach

        <!-- 已付 -->
        <tr class="section-title">
            <td colspan="4">已付帳款</td>
        </tr>

        @foreach ($okpays as $okpay)
        @php
            $okpayPrice = (float) ($okpay->Price ?? 0);
        @endphp
        <tr>
            <td>{{ $okpay->Date }}</td>
            <td colspan="2">{{ $okpay->Ps }}</td>
            <td class="text-right">{{ number_format($okpayPrice, 0) }}</td>
        </tr>
        @endforeach

        <tr class="highlight">
            <td>小計</td>
            <td colspan="2"></td>
            <td class="text-right">{{ $total['okpay'] ?? '0' }}</td>
        </tr>

        <tr class="total-final">
            <td></td>
            <td colspan="2" class="text-right">本團結餘</td>
            <td class="text-right">{{ $total['all_over'] ?? '0' }}</td>
        </tr>
    </table>
</div>
@endsection
@extends('layouts.app')

@push('styles')
<style>
    body {
        background: #c8d0d8; /* 加深整體背景，突顯白色 Card */
    }

    .page-wrap {
        padding: 24px 5% 36px;
    }

    .section-card {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 14px;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
        margin-bottom: 20px;
        overflow: hidden;
    }

    /* 區塊標題：顏色加深，拉高對比度 */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        padding: 18px 22px 14px;
        border-bottom: 2px solid #cbd5e1;
        background: #f1f5f9;
    }

    .section-header h3 {
        margin: 0;
        font-size: 20px;
        font-weight: 800;
        color: #0f172a; /* 顏色調深，提高閱讀品質 */
    }

    .section-header p {
        margin: 6px 0 0;
        font-size: 13px;
        color: #475569; /* 調深次要文字 */
        font-weight: 500;
    }

    .order-summary {
        padding: 18px 22px;
        display: grid;
        grid-template-columns: 1.8fr 1fr;
        gap: 16px;
        border-bottom: 1px solid #cbd5e1;
        background: #ffffff;
    }

    .summary-main {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .summary-title {
        font-size: 19px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.4;
    }

    .summary-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .meta-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        border: 1px solid #94a3b8;
        background: #e2e8f0;
        color: #1e293b;
    }

    .summary-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .action-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 34px;
        padding: 0 12px;
        border-radius: 8px;
        border: 1px solid #94a3b8;
        background: #ffffff;
        color: #0f172a;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
    }

    .action-link:hover {
        background: #fef08a;
        border-color: #ca8a04;
        color: #713f12;
    }

    .section-body {
        padding: 18px 22px 22px;
    }

    .subsection-title {
        margin: 0 0 12px;
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
    }

    .erp-table-wrap {
        border: 1px solid #94a3b8;
        border-radius: 12px;
        overflow: hidden;
        background: #ffffff;
    }

    .table.erp-table {
        margin-bottom: 0;
        vertical-align: middle;
    }

    /* 表頭：改為深色高對比，強烈區隔內容與欄位標題 */
    .table.erp-table thead th {
        background: #1e293b;
        color: #ffffff;
        font-size: 14px;
        font-weight: 700;
        padding: 12px 10px;
        border-bottom: 2px solid #0f172a;
        white-space: nowrap;
    }

    .table.erp-table tbody td {
        padding: 10px;
        border-top: 1px solid #cbd5e1;
        color: #0f172a;
        font-size: 13.5px;
        background: #ffffff;
    }

    .table.erp-table tbody tr:hover td {
        background: #fef9c3;
    }

    /* 新增資料列背景色 */
    .table.erp-table .new-row td {
        background: #eff6ff;
        border-bottom: 2px solid #bfdbfe;
    }

    /* 輸入框與下拉選單：強化邊框對比度 */
    .table.erp-table .form-control,
    .table.erp-table .form-select,
    .money-form .form-control,
    .money-form .form-select {
        min-height: 36px;
        border: 1.5px solid #64748b; /* 邊框加深 */
        border-radius: 7px;
        font-size: 13px;
        font-weight: 600;
        color: #0f172a;
        padding: 6px 8px;
        background: #ffffff;
    }

    /* Focus 狀態高亮對比 */
    .table.erp-table .form-control:focus,
    .table.erp-table .form-select:focus,
    .money-form .form-control:focus,
    .money-form .form-select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
        outline: none;
    }

    /* 按鈕顏色調深，提升可讀性 */
    .btn-primary {
        background: #2563eb;
        border-color: #2563eb;
        font-weight: 700;
    }

    .btn-primary:hover,
    .btn-primary:focus {
        background: #1d4ed8;
        border-color: #1d4ed8;
    }

    .btn-success {
        background: #15803d;
        border-color: #15803d;
        font-weight: 700;
    }

    .btn-success:hover,
    .btn-success:focus {
        background: #166534;
        border-color: #166534;
    }

    .btn-danger {
        background: #ffffff;
        border: 1.5px solid #dc2626;
        color: #dc2626;
        font-weight: 700;
    }

    .btn-danger:hover,
    .btn-danger:focus {
        background: #fef2f2;
        border-color: #b91c1c;
        color: #b91c1c;
    }

    .btn-sm {
        min-height: 32px;
        font-size: 12px;
        padding: 5px 12px;
        border-radius: 7px;
    }

    .btn-icon {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 7px;
        border: 1px solid #94a3b8;
        background: #ffffff;
        color: #334155;
        text-decoration: none;
        padding: 0;
        font-size: 14px;
    }

    .btn-icon:hover {
        background: #fef08a;
        border-color: #ca8a04;
        color: #713f12;
    }

    .btn-icon-danger:hover {
        background: #fef2f2;
        border-color: #b91c1c;
        color: #b91c1c;
    }

    .action-group {
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .money-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 16px;
    }

    .money-box {
        border: 1.5px solid #cbd5e1;
        border-radius: 12px;
        background: #f8fafc;
        padding: 14px;
    }

    .money-box-label {
        font-size: 12px;
        color: #334155; /* 調深說明文字 */
        font-weight: 700;
        margin-bottom: 6px;
    }

    .money-box-value {
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
    }

    .money-form {
        border: 1.5px solid #cbd5e1;
        border-radius: 12px;
        background: #ffffff;
        padding: 16px;
    }

    .money-form-grid {
        display: grid;
        grid-template-columns: 1.1fr 1.1fr 1.1fr 1fr auto;
        gap: 12px;
        align-items: end;
    }

    /* 表單欄位標題：加深並粗體，明確指引輸入框類型 */
    .field-label {
        display: block;
        margin-bottom: 6px;
        font-size: 13px;
        color: #1e293b;
        font-weight: 800;
    }

    .inline-field {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .empty-state {
        padding: 24px 12px;
        text-align: center;
        color: #475569;
        font-weight: 600;
        background: #ffffff;
    }

    @media (max-width: 1200px) {
        .money-form-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 991.98px) {
        .order-summary,
        .money-grid,
        .money-form-grid {
            grid-template-columns: 1fr;
        }

        .summary-actions {
            justify-content: flex-start;
        }
    }
</style>
@endpush

@section('content')
<div class="page-wrap">

    <div class="section-card">
        <div class="section-header">
            <div>
                <h3>帳務管理</h3>
                <p>維持 ERP 風格的應收、應付、已收與已付款資料管理。</p>
            </div>
        </div>

        <div class="order-summary">
            <div class="summary-main">
                <div class="summary-title">
                    @if ($moneys->OrderType == 0)
                        {{ $moneys->OrderStart }} - {{ $moneys->GroupName }} - {{ $moneys->Name }}
                    @else
                        {{ $moneys->OrderStart }} - {{ $moneys->OrderBuss }} - {{ $moneys->Name }}
                    @endif
                </div>
                <div class="summary-meta">
                    <span class="meta-badge">訂單編號：{{ $orderId }}</span>
                    <span class="meta-badge">訂金付款：{{ $moneys->DepositPay ?? 'N' }}</span>
                    <span class="meta-badge">尾款付款：{{ $moneys->FinalPay ?? 'N' }}</span>
                </div>
            </div>

            <div class="summary-actions">
                @if (session('permission') == 1)
                    <a href="{{ route('gbill2', ['orderId' => $orderId]) }}" class="action-link" target="_blank">團體總帳務報表</a>
                @endif

                @if ($moneys->OrderType == 0)
                    <a href="{{ route('gbill', ['orderId' => $orderId, 'type' => 1]) }}" class="action-link" target="_blank">請款單</a>
                    <a href="{{ route('gbill', ['orderId' => $orderId, 'type' => 2]) }}" class="action-link" target="_blank">請款單2</a>
                    <a href="{{ route('vbill', ['orderId' => $orderId, 'type' => 1]) }}" class="action-link" target="_blank">證件請款單</a>
                    <a href="{{ route('vbill', ['orderId' => $orderId, 'type' => 2]) }}" class="action-link" target="_blank">證件報表</a>
                @else
                    <a href="{{ route('tbill.show', ['tbill' => $orderId]) }}" class="action-link" target="_blank">請款單</a>
                @endif
            </div>
        </div>
    </div>

    <div class="section-card">
        <div class="section-header">
            <div>
                <h3>應收款項</h3>
                <p>新增與維護應收項目。</p>
            </div>
        </div>

        <div class="section-body">
            <div class="erp-table-wrap">
                <table class="table erp-table">
                    <thead>
                        <tr>
                            <th style="width: 28%;">項目</th>
                            <th style="width: 18%;">價格</th>
                            <th style="width: 18%;">數量</th>
                            <th style="width: 18%;">修改</th>
                            <th style="width: 18%;">刪除</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="new-row">
                            <form action="{{ route('tbill.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="orderid" value="{{ $orderId }}">
                                <input type="hidden" name="tableName" value="receivable">
                                <td>
                                    <select name="RItemId" class="form-select form-select-sm">
                                        <option value="" selected></option>
                                        @foreach ($items as $itemId => $itemName)
                                            <option value="{{ $itemId }}">{{ $itemName }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="Price" class="form-control form-control-sm" step="0.01" placeholder="價格">
                                </td>
                                <td>
                                    <input type="number" name="Number" class="form-control form-control-sm" step="1" placeholder="數量">
                                </td>
                                <td colspan="2">
                                    <button type="submit" class="btn btn-success btn-sm">新增</button>
                                </td>
                            </form>
                        </tr>

                        @forelse ($receivables as $receivable)
                            <tr>
                                <form action="{{ route('tbill.update', ['tbill' => $receivable->ReceivableId]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="tableName" value="receivable">
                                    <input type="hidden" name="tableId" value="ReceivableId">
                                    <input type="hidden" name="orderid" value="{{ $orderId }}">

                                    <td>
                                        <select name="RItemId" class="form-select form-select-sm">
                                            @foreach ($items as $itemId => $itemName)
                                                <option value="{{ $itemId }}" {{ $receivable->RItemId == $itemId ? 'selected' : '' }}>
                                                    {{ $itemName }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="Price" value="{{ $receivable->Price }}" class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <input type="number" name="Number" value="{{ $receivable->Number }}" class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-primary btn-sm">修改</button>
                                    </td>
                                </form>
                                <td>
                                    <form action="{{ route('tbill.destroy', ['tbill' => $receivable->ReceivableId]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="orderid" value="{{ $orderId }}">
                                        <input type="hidden" name="tableId" value="ReceivableId">
                                        <input type="hidden" name="tableName" value="receivable">
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('確定要刪除嗎？')">刪除</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">目前沒有應收款項資料。</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="section-card">
        <div class="section-header">
            <div>
                <h3>應扣款項</h3>
                <p>維護應收扣除項目。</p>
            </div>
        </div>

        <div class="section-body">
            <div class="erp-table-wrap">
                <table class="table erp-table">
                    <thead>
                        <tr>
                            <th style="width: 28%;">項目</th>
                            <th style="width: 18%;">價格</th>
                            <th style="width: 18%;">數量</th>
                            <th style="width: 18%;">修改</th>
                            <th style="width: 18%;">刪除</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="new-row">
                            <form action="{{ route('tbill.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="orderid" value="{{ $orderId }}">
                                <input type="hidden" name="tableName" value="receivableoff">
                                <td>
                                    <select name="RItemId" class="form-select form-select-sm">
                                        <option value="" selected></option>
                                        @foreach ($items as $itemId => $itemName)
                                            <option value="{{ $itemId }}">{{ $itemName }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="Price" class="form-control form-control-sm" step="0.01" placeholder="價格">
                                </td>
                                <td>
                                    <input type="number" name="Number" class="form-control form-control-sm" step="1" placeholder="數量">
                                </td>
                                <td colspan="2">
                                    <button type="submit" class="btn btn-success btn-sm">新增</button>
                                </td>
                            </form>
                        </tr>

                        @forelse ($receivableoffs as $receivableoff)
                            <tr>
                                <form action="{{ route('tbill.update', ['tbill' => $receivableoff->ReceivableOffId]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="tableName" value="receivableoff">
                                    <input type="hidden" name="tableId" value="ReceivableOffId">
                                    <input type="hidden" name="orderid" value="{{ $orderId }}">

                                    <td>
                                        <select name="RItemId" class="form-select form-select-sm">
                                            @foreach ($items as $itemId => $itemName)
                                                <option value="{{ $itemId }}" {{ $receivableoff->RItemId == $itemId ? 'selected' : '' }}>
                                                    {{ $itemName }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="Price" value="{{ $receivableoff->Price }}" class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <input type="number" name="Number" value="{{ $receivableoff->Number }}" class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-primary btn-sm">修改</button>
                                    </td>
                                </form>
                                <td>
                                    <form action="{{ route('tbill.destroy', ['tbill' => $receivableoff->ReceivableOffId]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="orderid" value="{{ $orderId }}">
                                        <input type="hidden" name="tableId" value="ReceivableOffId">
                                        <input type="hidden" name="tableName" value="receivableoff">
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('確定要刪除嗎？')">刪除</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">目前沒有應扣款項資料。</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="section-card">
        <div class="section-header">
            <div>
                <h3>已收帳款</h3>
                <p>管理已收帳款紀錄。</p>
            </div>
        </div>

        <div class="section-body">
            <div class="erp-table-wrap">
                <table class="table erp-table">
                    <thead>
                        <tr>
                            <th style="width: 22%;">日期</th>
                            <th style="width: 22%;">金額</th>
                            <th>備註</th>
                            <th style="width: 14%;">修改</th>
                            <th style="width: 14%;">刪除</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="new-row">
                            <form action="{{ route('rece.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="orderid" value="{{ $orderId }}">
                                <input type="hidden" name="tableName" value="okrece">
                                <td>
                                    <input type="text" name="Date" class="form-control form-control-sm" placeholder="日期">
                                </td>
                                <td>
                                    <input type="number" name="Price" class="form-control form-control-sm" step="0.01" placeholder="金額">
                                </td>
                                <td>
                                    <input type="text" name="Ps" class="form-control form-control-sm" placeholder="備註">
                                </td>
                                <td colspan="2">
                                    <button type="submit" class="btn btn-success btn-sm">新增</button>
                                </td>
                            </form>
                        </tr>

                        @forelse ($okreces as $okrece)
                            <tr>
                                <form action="{{ route('rece.update', ['rece' => $okrece->OId]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="tableName" value="okrece">
                                    <input type="hidden" name="tableId" value="OId">
                                    <input type="hidden" name="orderid" value="{{ $orderId }}">

                                    <td>
                                        <input type="date" min="1911-01-01" max="2125-12-31" name="Date" value="{{ $okrece->Date }}" class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <input type="number" name="Price" value="{{ $okrece->Price }}" class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <input type="text" name="Ps" value="{{ $okrece->Ps }}" class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-primary btn-sm">修改</button>
                                    </td>
                                </form>
                                <td>
                                    <form action="{{ route('tbill.destroy', ['tbill' => $okrece->OId]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="orderid" value="{{ $orderId }}">
                                        <input type="hidden" name="tableId" value="OId">
                                        <input type="hidden" name="tableName" value="okrece">
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('確定要刪除嗎？')">刪除</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">目前沒有已收帳款資料。</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if (session('permission') == 1)
        <div class="section-card">
            <div class="section-header">
                <div>
                    <h3>應付帳款</h3>
                    <p>管理應付供應商或相關單位的費用項目。</p>
                </div>
            </div>

            <div class="section-body">
                <div class="erp-table-wrap">
                    <table class="table erp-table">
                        <thead>
                            <tr>
                                <th style="width: 28%;">項目</th>
                                <th style="width: 18%;">價格</th>
                                <th style="width: 18%;">數量</th>
                                <th style="width: 18%;">修改</th>
                                <th style="width: 18%;">刪除</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="new-row">
                                <form action="{{ route('tbill.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="orderid" value="{{ $orderId }}">
                                    <input type="hidden" name="tableName" value="payable">
                                    <td>
                                        <select name="RItemId" class="form-select form-select-sm">
                                            <option value="" selected></option>
                                            @foreach ($items as $itemId => $itemName)
                                                <option value="{{ $itemId }}">{{ $itemName }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="Price" class="form-control form-control-sm" step="0.01" placeholder="價格">
                                    </td>
                                    <td>
                                        <input type="number" name="Number" class="form-control form-control-sm" step="1" placeholder="數量">
                                    </td>
                                    <td colspan="2">
                                        <button type="submit" class="btn btn-success btn-sm">新增</button>
                                    </td>
                                </form>
                            </tr>

                            @forelse ($payables as $payable)
                                <tr>
                                    <form action="{{ route('tbill.update', ['tbill' => $payable->PayableId]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="tableName" value="payable">
                                        <input type="hidden" name="tableId" value="PayableId">
                                        <input type="hidden" name="orderid" value="{{ $orderId }}">

                                        <td>
                                            <select name="RItemId" class="form-select form-select-sm">
                                                @foreach ($items as $itemId => $itemName)
                                                    <option value="{{ $itemId }}" {{ $payable->RItemId == $itemId ? 'selected' : '' }}>
                                                        {{ $itemName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="Price" value="{{ $payable->Price }}" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <input type="number" name="Number" value="{{ $payable->Number }}" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-primary btn-sm">修改</button>
                                        </td>
                                    </form>
                                    <td>
                                        <form action="{{ route('tbill.destroy', ['tbill' => $payable->PayableId]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="orderid" value="{{ $orderId }}">
                                            <input type="hidden" name="tableId" value="PayableId">
                                            <input type="hidden" name="tableName" value="payable">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('確定要刪除嗎？')">刪除</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="empty-state">目前沒有應付帳款資料。</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="section-card">
            <div class="section-header">
                <div>
                    <h3>已付帳款</h3>
                    <p>管理付款完成的帳款紀錄。</p>
                </div>
            </div>

            <div class="section-body">
                <div class="erp-table-wrap">
                    <table class="table erp-table">
                        <thead>
                            <tr>
                                <th style="width: 22%;">日期</th>
                                <th style="width: 22%;">金額</th>
                                <th>備註</th>
                                <th style="width: 14%;">修改</th>
                                <th style="width: 14%;">刪除</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="new-row">
                                <form action="{{ route('rece.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="orderid" value="{{ $orderId }}">
                                    <input type="hidden" name="tableName" value="okpay">
                                    <td>
                                        <input type="date" min="1911-01-01" max="2125-12-31" name="Date" class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <input type="number" name="Price" class="form-control form-control-sm" step="0.01" placeholder="金額">
                                    </td>
                                    <td>
                                        <input type="text" name="Ps" class="form-control form-control-sm" placeholder="備註">
                                    </td>
                                    <td colspan="2">
                                        <button type="submit" class="btn btn-success btn-sm">新增</button>
                                    </td>
                                </form>
                            </tr>

                            @forelse ($okpays as $okpay)
                                <tr>
                                    <form action="{{ route('rece.update', ['rece' => $okpay->OId]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="tableName" value="okpay">
                                        <input type="hidden" name="tableId" value="OId">
                                        <input type="hidden" name="orderid" value="{{ $orderId }}">

                                        <td>
                                            <input type="text" name="Date" value="{{ $okpay->Date }}" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <input type="number" name="Price" value="{{ $okpay->Price }}" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <input type="text" name="Ps" value="{{ $okpay->Ps }}" class="form-control form-control-sm">
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-primary btn-sm">修改</button>
                                        </td>
                                    </form>
                                    <td>
                                        <form action="{{ route('tbill.destroy', ['tbill' => $okpay->OId]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="orderid" value="{{ $orderId }}">
                                            <input type="hidden" name="tableId" value="OId">
                                            <input type="hidden" name="tableName" value="okpay">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('確定要刪除嗎？')">刪除</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="empty-state">目前沒有已付帳款資料。</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <div class="section-card">
        <div class="section-header">
            <div>
                <h3>訂金與尾款</h3>
                <p>更新訂金、尾款日期與付款狀態。</p>
            </div>
        </div>

        <div class="section-body">
            <div class="money-grid">
                <div class="money-box">
                    <div class="money-box-label">訂金日期</div>
                    <div class="money-box-value">{{ $moneys->DepositDate ?: '-' }}</div>
                </div>
                <div class="money-box">
                    <div class="money-box-label">訂金金額 / 付款</div>
                    <div class="money-box-value">{{ $moneys->Deposit ?: 0 }} / {{ $moneys->DepositPay ?: 'N' }}</div>
                </div>
                <div class="money-box">
                    <div class="money-box-label">尾款日期</div>
                    <div class="money-box-value">{{ $moneys->FinalDate ?: '-' }}</div>
                </div>
                <div class="money-box">
                    <div class="money-box-label">尾款付款</div>
                    <div class="money-box-value">{{ $moneys->FinalPay ?: 'N' }}</div>
                </div>
            </div>

            <form action="{{ route('tbill.editmoney', ['id' => $orderId]) }}" method="POST" class="money-form">
                @csrf
                <div class="money-form-grid">
                    <div>
                        <label class="field-label">訂金日期</label>
                        <input type="date" min="2024-01-01" max="2125-12-31" name="DepositDate" value="{{ $moneys->DepositDate }}" class="form-control form-control-sm">
                    </div>

                    <div>
                        <label class="field-label">訂金金額</label>
                        <input type="number" name="Deposit" value="{{ $moneys->Deposit }}" class="form-control form-control-sm">
                    </div>

                    <div>
                        <label class="field-label">訂金付款</label>
                        <select name="DepositPay" class="form-select form-select-sm" required>
                            <option value="N" {{ $moneys->DepositPay == 'N' ? 'selected' : '' }}>N</option>
                            <option value="Y" {{ $moneys->DepositPay == 'Y' ? 'selected' : '' }}>Y</option>
                        </select>
                    </div>

                    <div>
                        <label class="field-label">尾款日期 / 付款</label>
                        <div class="inline-field">
                            <input type="date" min="2024-01-01" max="2125-12-31" name="FinalDate" value="{{ $moneys->FinalDate }}" class="form-control form-control-sm">
                            <select name="FinalPay" class="form-select form-select-sm" required>
                                <option value="N" {{ $moneys->FinalPay == 'N' ? 'selected' : '' }}>N</option>
                                <option value="Y" {{ $moneys->FinalPay == 'Y' ? 'selected' : '' }}>Y</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary btn-sm">修改</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
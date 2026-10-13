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
        max-width: 1100px;
        margin: 0 auto 24px;
        background: #ffffff;
        border: 1px solid #dde3e8;
        border-radius: 14px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
        overflow: hidden;
    }

    .section-header {
        padding: 18px 22px 14px;
        background: #f7f9fb;
        border-bottom: 1px solid #e5eaf0;
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

    .customer-card {
        border-bottom: 1px solid #e5eaf0;
    }

    .customer-card:last-child {
        border-bottom: none;
    }

    .customer-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding: 14px 22px;
        background: #eef3f8;
        border-bottom: 1px solid #dde3e8;
    }

    .customer-title-left {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .customer-index {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 30px;
        height: 30px;
        padding: 0 10px;
        border-radius: 999px;
        background: #4f8cff;
        color: #ffffff;
        font-size: 12px;
        font-weight: 700;
    }

    .customer-name {
        font-size: 16px;
        font-weight: 700;
        color: #1f2937;
    }

    .customer-sub {
        font-size: 12px;
        color: #64748b;
    }

    .customer-body {
        padding: 20px 22px 22px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(12, minmax(0, 1fr));
        gap: 14px 16px;
    }

    .field-12 { grid-column: span 12; }
    .field-9 { grid-column: span 9; }
    .field-8 { grid-column: span 8; }
    .field-6 { grid-column: span 6; }
    .field-4 { grid-column: span 4; }
    .field-3 { grid-column: span 3; }

    .field-block label {
        display: block;
        margin-bottom: 6px;
        font-size: 13px;
        font-weight: 700;
        color: #475569;
    }

    .form-control,
    .form-select {
        min-height: 40px;
        border: 1px solid #cfd8e3;
        border-radius: 8px;
        font-size: 14px;
        color: #1f2937;
        background: #ffffff;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #4f8cff;
        box-shadow: 0 0 0 0.15rem rgba(79, 140, 255, 0.12);
    }

    .subsection {
        margin-top: 18px;
        padding-top: 18px;
        border-top: 1px solid #e5eaf0;
    }

    .subsection-title {
        margin: 0 0 14px;
        font-size: 14px;
        font-weight: 700;
        color: #334155;
    }

    .visa-check-list,
    .sign-check-list {
        display: flex;
        flex-wrap: wrap;
        gap: 10px 14px;
    }

    .visa-check-item,
    .sign-check-item {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border: 1px solid #d8e0e8;
        border-radius: 10px;
        background: #f8fafc;
        min-height: 40px;
    }

    .visa-check-item input[type="checkbox"],
    .sign-check-item input[type="checkbox"] {
        width: 16px;
        height: 16px;
    }

    .table-wrap {
        overflow-x: auto;
        border: 1px solid #dde3e8;
        border-radius: 12px;
    }

    .erp-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 920px;
        margin: 0;
    }

    .erp-table thead th {
        padding: 12px 10px;
        background: #eef3f8;
        border-bottom: 1px solid #dde3e8;
        color: #334155;
        font-size: 13px;
        font-weight: 700;
        text-align: center;
        white-space: nowrap;
    }

    .erp-table tbody td {
        padding: 10px;
        border-bottom: 1px solid #edf2f7;
        font-size: 13px;
        color: #1f2937;
        vertical-align: middle;
        background: #ffffff;
    }

    .erp-table tbody tr:hover td {
        background: #fffde8;
    }

    .mini-form-grid {
        display: grid;
        grid-template-columns: repeat(12, minmax(0, 1fr));
        gap: 14px 16px;
        margin-bottom: 16px;
    }

    .mini-field-3 { grid-column: span 3; }
    .mini-field-4 { grid-column: span 4; }
    .mini-field-6 { grid-column: span 6; }
    .mini-field-12 { grid-column: span 12; }

    .action-bar {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
        margin-top: 20px;
        padding-top: 18px;
        border-top: 1px solid #e5eaf0;
    }

    .btn-primary {
        background: #4f8cff;
        border-color: #4f8cff;
        color: #fff;
    }

    .btn-primary:hover,
    .btn-primary:focus {
        background: #3f7ae6;
        border-color: #3f7ae6;
        color: #fff;
    }

    .btn-success {
        color: #fff;
    }

    .btn-danger {
        color: #fff;
    }

    @media (max-width: 992px) {
        .field-9,
        .field-8,
        .field-6,
        .field-4,
        .field-3,
        .mini-field-3,
        .mini-field-4,
        .mini-field-6 {
            grid-column: span 12;
        }

        .customer-title {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')
<div class="page-wrap">
    <div class="section-card">
        <div class="section-header">
            <h3>證件 / 旅客資料維護</h3>
            <p>維護旅客基本資料、護照、台胞證、簽證、已收證件與證件進度。</p>
        </div>

        @foreach($customers as $customer)
            <div class="customer-card">
                <div class="customer-title">
                    <div class="customer-title-left">
                        <span class="customer-index">{{ $loop->iteration }}</span>
                        <span class="customer-name">{{ $customer->Name }}</span>
                        <span class="customer-sub">{{ $customer->EName }}</span>
                    </div>
                </div>

                <div class="customer-body">
                    <form action="{{ route('visa.update', ['visa' => $customer->CusId]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-grid">
                            <div class="field-block field-3">
                                <label>中文姓名</label>
                                <input type="text" name="Name" value="{{ $customer->Name }}" class="form-control">
                            </div>

                            <div class="field-block field-3">
                                <label>英文姓名</label>
                                <input type="text" name="EName" value="{{ $customer->EName }}" class="form-control">
                            </div>

                            <div class="field-block field-3">
                                <label>身分證字號</label>
                                <input type="text" name="ID" value="{{ $customer->ID }}" class="form-control">
                            </div>

                            <div class="field-block field-3">
                                <label>生日</label>
                                <input type="date" name="Birthday" value="{{ $customer->Birthday }}" class="form-control">
                            </div>

                            <div class="field-block field-3">
                                <label>聯絡電話</label>
                                <input type="text" name="Phone" value="{{ $customer->Phone }}" class="form-control">
                            </div>

                            <div class="field-block field-3">
                                <label>票種</label>
                                <select name="TicketType" class="form-select">
                                    @foreach ($tickets as $ticket)
                                        <option value="{{ $ticket->TypeId }}" {{ $customer->TicketType == $ticket->TypeId ? 'selected' : '' }}>
                                            {{ $ticket->TypeName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="field-block field-3">
                                <label>性別</label>
                                <select name="Sex" class="form-select">
                                    @foreach ($sexs as $sex)
                                        <option value="{{ $sex->SexId }}" {{ $customer->Sex == $sex->SexId ? 'selected' : '' }}>
                                            {{ $sex->SexName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="field-block field-3">
                                <label>備註</label>
                                <input type="text" name="Ps" value="{{ $customer->Ps }}" class="form-control">
                            </div>
                        </div>

                        <div class="subsection">
                            <div class="subsection-title">護照資料</div>
                            <div class="form-grid">
                                <div class="field-block field-4">
                                    <label>護照號碼</label>
                                    <input type="text" name="PpNumber" value="{{ $customer->PpNumber }}" class="form-control">
                                </div>

                                <div class="field-block field-4">
                                    <label>發照日</label>
                                    <input type="date" name="PpDate" value="{{ $customer->PpDate }}" class="form-control">
                                </div>

                                <div class="field-block field-4">
                                    <label>到期日</label>
                                    <input type="date" name="PpDate1" value="{{ $customer->PpDate1 }}" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="subsection">
                            <div class="subsection-title">證件與分車</div>
                            <div class="form-grid">
                                <div class="field-block field-3">
                                    <label>台胞證號</label>
                                    <input type="text" name="TbNumber" value="{{ $customer->TbNumber }}" class="form-control">
                                </div>

                                <div class="field-block field-3">
                                    <label>台胞效期</label>
                                    <input type="date" name="TbDate" value="{{ $customer->TbDate }}" class="form-control">
                                </div>

                                <div class="field-block field-3">
                                    <label>去程分車</label>
                                    <input type="text" name="CarNo" value="{{ $customer->CarNo }}" class="form-control">
                                </div>

                                <div class="field-block field-3">
                                    <label>回程分車</label>
                                    <input type="text" name="CarNo2" value="{{ $customer->CarNo2 }}" class="form-control">
                                </div>

                                <div class="field-block field-12">
                                    <label>簽證類型</label>
                                    <div class="visa-check-list">
                                        @foreach($visaTypes as $visaType)
                                            <label class="visa-check-item">
                                                <input type="checkbox"
                                                       name="visa_types[]"
                                                       value="{{ $visaType->V1_Id }}"
                                                       {{ in_array($visaType->V1_Id, $visas) ? 'checked' : '' }}>
                                                <span>{{ $visaType->V1_Name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="subsection">
                            <div class="subsection-title">已收證件</div>
                            <div class="form-grid">
                                <div class="field-block field-12">
                                    <div class="sign-check-list">
                                        @if(isset($sign1s))
                                            @foreach($sign1s as $sign1)
                                                <label class="sign-check-item">
                                                    <input type="checkbox"
                                                           name="sign_types[]"
                                                           value="{{ $sign1->S1_Id }}"
                                                           {{ in_array($sign1->S1_Id, $signs) ? 'checked' : '' }}>
                                                    <span>{{ $sign1->S1_Name }}</span>
                                                </label>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="subsection">
                            <div class="subsection-title">機票資訊</div>
                            <div class="form-grid">
                                <div class="field-block field-3">
                                    <label>去程 PNR</label>
                                    <input type="text" name="StartPNR" value="{{ $customer->StartPNR }}" class="form-control">
                                </div>

                                <div class="field-block field-3">
                                    <label>去程 ETicket</label>
                                    <input type="text" name="StartETicket" value="{{ $customer->StartETicket }}" class="form-control">
                                </div>

                                <div class="field-block field-3">
                                    <label>回程 PNR</label>
                                    <input type="text" name="ComePNR" value="{{ $customer->ComePNR }}" class="form-control">
                                </div>

                                <div class="field-block field-3">
                                    <label>回程 ETicket</label>
                                    <input type="text" name="ComeETicket" value="{{ $customer->ComeETicket }}" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="action-bar">
                            <button type="submit" class="btn btn-primary">儲存修改</button>
                        </div>
                    </form>

                    <div class="subsection">
                        <div class="subsection-title">新增證件進度</div>

                        <form action="{{ route('visa.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="CusId" value="{{ $customer->CusId }}">

                            <div class="mini-form-grid">
                                <div class="field-block mini-field-3">
                                    <label>日期</label>
                                    <input type="date" name="L_date" class="form-control">
                                </div>

                                <div class="field-block mini-field-3">
                                    <label>進度項目</label>
                                    <select name="schedule" class="form-select">
                                        @foreach($schedules as $schedule)
                                            <option value="{{ $schedule->S_Id }}">{{ $schedule->S_Name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="field-block mini-field-3">
                                    <label>窗口</label>
                                    <select name="window" class="form-select">
                                        @foreach($windows as $window)
                                            <option value="{{ $window->W_Id }}">{{ $window->W_Name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="field-block mini-field-3">
                                    <label>支出</label>
                                    <input type="number" step="0.01" name="Exp" value="0" class="form-control">
                                </div>

                                <div class="field-block mini-field-3">
                                    <label>應收</label>
                                    <input type="number" step="0.01" name="Income2" value="0" class="form-control">
                                </div>

                                <div class="field-block mini-field-3">
                                    <label>已收</label>
                                    <input type="number" step="0.01" name="Income" value="0" class="form-control">
                                </div>

                                <div class="field-block mini-field-6">
                                    <label>備註</label>
                                    <input type="text" name="Ps" class="form-control">
                                </div>

                                <div class="field-block mini-field-12">
                                    <button type="submit" class="btn btn-success">新增進度</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="subsection">
                        <div class="subsection-title">證件進度紀錄</div>

                        <div class="table-wrap">
                            <table class="erp-table">
                                <thead>
                                    <tr>
                                        <th>日期</th>
                                        <th>進度項目</th>
                                        <th>窗口</th>
                                        <th>備註</th>
                                        <th>應收</th>
                                        <th>已收</th>
                                        <th>支出</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($lists as $list)
                                        <tr>
                                            <td>{{ $list->L_date }}</td>
                                            <td>{{ $list->S_Name ?? '' }}</td>
                                            <td>{{ $list->W_Name ?? '' }}</td>
                                            <td>{{ $list->Ps }}</td>
                                            <td>{{ $list->Income2}}</td> <!-- 應收 /-->
                                            <td>{{ $list->Income }}</td> <!-- 已收 /-->
                                            <td>{{ $list->Exp }}</td>
                                            <td>
                                                <form action="{{ route('visa.destroy', $list->L_Id) }}" method="POST" onsubmit="return confirm('確定要刪除這筆進度嗎？');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="CusId" value="{{ $customer->CusId }}">
                                                    <button type="submit" class="btn btn-danger btn-sm">刪除</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" style="text-align:center;">目前尚無證件進度資料</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
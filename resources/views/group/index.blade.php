@extends('layouts.app')

@push('styles')
<style>
    body {
        background: #d0d0d0;
        font-family: "Microsoft JhengHei", sans-serif;
    }

    .erp-page {
        padding: 24px 5% 36px;
    }

    .erp-card {
        max-width: 1080px;
        margin: 0 auto;
        background: #ffffff;
        border: 1px solid #dde3e8;
        border-radius: 14px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
        overflow: hidden;
    }

    .erp-card-header {
        padding: 18px 22px 14px;
        background: #f7f9fb;
        border-bottom: 1px solid #e5eaf0;
    }

    .erp-card-header h3 {
        margin: 0;
        font-size: 22px;
        font-weight: 700;
        color: #1f2937;
    }

    .erp-card-header p {
        margin: 6px 0 0;
        font-size: 13px;
        color: #6b7280;
    }

    .erp-card-body {
        padding: 22px;
    }

    .erp-section {
        border: 1px solid #dde3e8;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 18px;
        background: #fff;
    }

    .erp-section:last-child {
        margin-bottom: 0;
    }

    .erp-section-title {
        padding: 12px 16px;
        background: #e9edf3;
        color: #334155;
        font-size: 14px;
        font-weight: 700;
        border-bottom: 1px solid #dde3e8;
    }

    .erp-section-body {
        padding: 18px 16px 16px;
    }

    .erp-grid {
        display: grid;
        grid-template-columns: repeat(12, minmax(0, 1fr));
        gap: 14px 16px;
    }

    .field-12 { grid-column: span 12; }
    .field-8 { grid-column: span 8; }
    .field-6 { grid-column: span 6; }
    .field-4 { grid-column: span 4; }
    .field-3 { grid-column: span 3; }
    .field-2 { grid-column: span 2; }

    .erp-field label {
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

    textarea.form-control {
        min-height: 110px;
        resize: vertical;
    }

    .erp-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
        margin-top: 22px;
        padding-top: 18px;
        border-top: 1px solid #e5eaf0;
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

    .btn-success {
        background: #52b36c;
        border-color: #52b36c;
    }

    .btn-success:hover,
    .btn-success:focus {
        background: #44985a;
        border-color: #44985a;
    }

    .summary-row {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
        margin-bottom: 18px;
    }

    .summary-box {
        border: 1px solid #dde3e8;
        border-radius: 10px;
        background: #f9fbfc;
        padding: 12px 14px;
    }

    .summary-label {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 4px;
    }

    .summary-value {
        font-size: 16px;
        font-weight: 700;
        color: #1f2937;
    }

    @media (max-width: 992px) {
        .field-8,
        .field-6,
        .field-4,
        .field-3,
        .field-2 {
            grid-column: span 12;
        }

        .summary-row {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 576px) {
        .erp-page {
            padding: 14px 10px 24px;
        }

        .erp-card-body {
            padding: 14px;
        }

        .summary-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    function check() {
        const form = document.forms['groupForm'];

        if (form.GroupName.value === "") {
            alert("請輸入出團名稱");
            form.GroupName.focus();
            return false;
        }

        if (form.startdate.value === "") {
            alert("請輸入出發日期");
            form.startdate.focus();
            return false;
        }

        if (form.comedate.value === "") {
            alert("請輸入回程日期");
            form.comedate.focus();
            return false;
        }

        if (form.OrderBuss.value === "") {
            alert("請輸入公司名稱");
            form.OrderBuss.focus();
            return false;
        }

        if (form.OrderCus.value === "") {
            alert("請輸入聯絡人");
            form.OrderCus.focus();
            return false;
        }

        if (form.OrderTel.value === "") {
            alert("請輸入連絡電話");
            form.OrderTel.focus();
            return false;
        }

        if (form.CusNum.value === "") {
            alert("請輸入人數");
            form.CusNum.focus();
            return false;
        }

        return true;
    }
</script>
@endpush

@section('content')
<div class="erp-page">
    <div class="erp-card">
        <div class="erp-card-header">
            <h3>團體訂單建檔</h3>
            <p>建立團體主資料、聯絡資訊與接待安排</p>
        </div>

        <div class="erp-card-body">
            <div class="summary-row">
                <div class="summary-box">
                    <div class="summary-label">作業類型</div>
                    <div class="summary-value">團體訂單</div>
                </div>
                <div class="summary-box">
                    <div class="summary-label">建檔模式</div>
                    <div class="summary-value">新建資料</div>
                </div>
                <div class="summary-box">
                    <div class="summary-label">必填重點</div>
                    <div class="summary-value">日期 / 聯絡人 / 人數</div>
                </div>
                <div class="summary-box">
                    <div class="summary-label">流程</div>
                    <div class="summary-value">建檔後下一步</div>
                </div>
            </div>

            <form action="{{ route('group.store') }}" method="post" name="groupForm" onsubmit="return check();">
                @csrf

                <div class="erp-section">
                    <div class="erp-section-title">基本資料</div>
                    <div class="erp-section-body">
                        <div class="erp-grid">
                            <div class="erp-field field-6">
                                <label for="GroupName">出團名稱</label>
                                <input type="text" name="GroupName" id="GroupName" class="form-control">
                            </div>

                            <div class="erp-field field-3">
                                <label for="continent">地區</label>
                                <select name="continent" id="continent" class="form-select">
                                    <option value="0"></option>
                                    @foreach ($continents as $continent)
                                        <option value="{{ $continent->ContinentID }}">{{ $continent->Country }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="erp-field field-3">
                                <label for="CusNum">人數</label>
                                <input type="number" class="form-control" min="1" name="CusNum" id="CusNum">
                            </div>

                            <div class="erp-field field-3">
                                <label for="startdate">出發日</label>
                                <input type="date" class="form-control" name="startdate" id="startdate" min="1901-01-01" max="3000-11-11">
                            </div>

                            <div class="erp-field field-3">
                                <label for="comedate">回程日</label>
                                <input type="date" class="form-control" name="comedate" id="comedate" min="1901-01-01" max="3000-11-11">
                            </div>

                            <div class="erp-field field-6">
                                <label for="OrderBuss">公司名稱</label>
                                <input type="text" name="OrderBuss" id="OrderBuss" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="erp-section">
                    <div class="erp-section-title">聯絡資訊</div>
                    <div class="erp-section-body">
                        <div class="erp-grid">
                            <div class="erp-field field-4">
                                <label for="OrderCus">聯絡人</label>
                                <input type="text" name="OrderCus" id="OrderCus" class="form-control">
                            </div>

                            <div class="erp-field field-4">
                                <label for="OrderTel">電話</label>
                                <input type="text" name="OrderTel" id="OrderTel" class="form-control">
                            </div>

                            <div class="erp-field field-4">
                                <label for="OrderFax">傳真</label>
                                <input type="text" name="OrderFax" id="OrderFax" class="form-control">
                            </div>

                            <div class="erp-field field-6">
                                <label for="OrderMail">E-Mail</label>
                                <input type="text" name="OrderMail" id="OrderMail" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="erp-section">
                    <div class="erp-section-title">接待與票務</div>
                    <div class="erp-section-body">
                        <div class="erp-grid">
                            <div class="erp-field field-4">
                                <label for="TaiwanTs">台灣接待社</label>
                                <select name="TaiwanTs" id="TaiwanTs" class="form-select">
                                    <option></option>
                                    @foreach ($Taiwan as $twts)
                                        <option value="{{ $twts->LocalTsId }}">{{ $twts->LocalTsName }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="erp-field field-4">
                                <label for="Guide1">導遊</label>
                                <input type="text" name="Guide1" id="Guide1" class="form-control">
                            </div>

                            <div class="erp-field field-4">
                                <label for="FTs">國外接待社</label>
                                <select name="FTs" id="FTs" class="form-select">
                                    <option></option>
                                    @foreach ($Foreign as $fts)
                                        <option value="{{ $fts->LocalTsId }}">{{ $fts->LocalTsName }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="erp-field field-4">
                                <label for="Ticket">票務</label>
                                <select name="Ticket" id="Ticket" class="form-select">
                                    <option></option>
                                    @foreach ($Taiwan as $twts)
                                        <option value="{{ $twts->LocalTsId }}">{{ $twts->LocalTsName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="erp-section">
                    <div class="erp-section-title">附加資訊</div>
                    <div class="erp-section-body">
                        <div class="erp-grid">
                            <div class="erp-field field-6">
                                <label for="Shopping">購物站</label>
                                <input type="text" name="Shopping" id="Shopping" class="form-control">
                            </div>

                            <div class="erp-field field-6">
                                <label for="OTour">自費行程</label>
                                <input type="text" name="OTour" id="OTour" class="form-control">
                            </div>

                            <div class="erp-field field-12">
                                <label for="orderps">備註</label>
                                <textarea name="orderps" id="orderps" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="erp-actions">
                    <button type="submit" class="btn btn-success">下一步</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
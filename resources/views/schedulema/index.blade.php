@extends('layouts.app')

@section('title', '證件進度管理')

@push('styles')
<style>
    .erp-page {
        background: #ffffff;
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
        min-width: 240px;
        flex: 1 1 240px;
    }

    .table-toolbar label {
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

    .erp-table .action-cell {
        width: 140px;
        white-space: nowrap;
    }

    .empty-state {
        text-align: center;
        padding: 28px 16px;
        color: #6b7280;
        background: #f8fafc;
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
        background: #4f8cff;
        border-color: #4f8cff;
    }

    .btn-success:hover,
    .btn-success:focus {
        background: #3f7ae6;
        border-color: #3f7ae6;
    }

    .form-control {
        border: 1px solid #cfd8e3;
        min-height: 40px;
    }

    .form-control:focus {
        border-color: #4f8cff;
        box-shadow: 0 0 0 0.15rem rgba(79, 140, 255, 0.15);
    }

    @media (max-width: 768px) {
        .section-header,
        .section-body {
            padding-left: 16px;
            padding-right: 16px;
        }

        .table-toolbar {
            padding: 14px;
        }

        .erp-table thead th,
        .erp-table tbody td {
            padding: 10px 12px;
        }
    }
</style>
@endpush

@section('content')
<div class="erp-page">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8 col-xl-7">
                <div class="section-card">
                    <div class="section-header">
                        <h3>證件進度管理</h3>
                        <p>維護證件流程名稱，提供後續訂單與作業流程統一使用。</p>
                    </div>

                    <div class="section-body">
                        <form action="{{ route('schedulema.store') }}" method="POST" class="table-toolbar">
                            @csrf
                            <div class="toolbar-group">
                                <label for="S_Name">新增流程名稱</label>
                                <input type="text" id="S_Name" name="S_Name" class="form-control" placeholder="請輸入證件流程名稱" required>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary px-4">新增</button>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table erp-table">
                                <thead>
                                    <tr>
                                        <th>流程名稱</th>
                                        <th class="action-cell">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($schedules as $schedule)
                                        <tr>
                                            <form action="{{ route('schedulema.update', $schedule->S_Id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <td>
                                                    <input type="text" name="S_Name" value="{{ $schedule->S_Name }}" class="form-control" required>
                                                </td>
                                                <td class="action-cell">
                                                    <button type="submit" class="btn btn-primary">修改</button>
                                                </td>
                                            </form>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="empty-state">目前尚無證件流程資料</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
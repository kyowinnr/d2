@extends('layouts.app')

@section('title', '車次說明管理')

@push('styles')
<style>
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
        margin-bottom: 24px;
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

    .mode-banner {
        display: inline-flex;
        align-items: center;
        min-height: 34px;
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: .2px;
        border: 1px solid transparent;
    }

    .mode-banner.mode-standard {
        background: #eef4ff;
        border-color: #cfe0ff;
        color: #2f5ea8;
    }

    .mode-banner.mode-transfer {
        background: #fff8db;
        border-color: #f1e3a5;
        color: #7c5a00;
    }

    .mode-banner.mode-charter {
        background: #e8f5e9;
        border-color: #cfe8d2;
        color: #2f6b39;
    }

    .mode-banner.mode-transfer-charter {
        background: #fdf0f0;
        border-color: #efcaca;
        color: #a33c3c;
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
        text-align: center;
    }

    .erp-table tbody td {
        padding: 14px;
        border-color: #e5e7eb;
        vertical-align: top;
        color: #1f2937;
        background: #ffffff;
    }

    .erp-table tbody tr:hover td {
        background: #f9f900 !important;
    }

    .erp-table .location-cell {
        width: 180px;
        min-width: 180px;
        font-weight: 700;
        color: #334155;
        background: #f8fafc;
    }

    .erp-table .action-cell {
        width: 120px;
        min-width: 120px;
        text-align: center;
    }

    .narrate-box {
        min-height: 160px;
        resize: vertical;
        border: 1px solid #cfd8e3;
        border-radius: 8px;
        padding: 10px 12px;
        width: 100%;
        font-size: 14px;
        line-height: 1.7;
        color: #1f2937;
        background: #ffffff;
    }

    .narrate-box:focus {
        border-color: #4f8cff;
        box-shadow: 0 0 0 0.15rem rgba(79, 140, 255, 0.15);
        outline: none;
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

    .empty-state {
        text-align: center;
        padding: 28px 16px;
        color: #6b7280;
        background: #f8fafc;
    }

    .table-note {
        margin-top: 10px;
        font-size: 13px;
        color: #64748b;
    }

    @media (max-width: 768px) {
        .section-header,
        .section-body {
            padding-left: 16px;
            padding-right: 16px;
        }

        .erp-table thead th,
        .erp-table tbody td {
            padding: 10px 12px;
        }

        .erp-table .location-cell,
        .erp-table .action-cell {
            min-width: unset;
            width: auto;
        }
    }
</style>
@endpush

@section('content')
<div class="erp-page">
    <div class="container-fluid">

        @foreach ([4, 6, 8, 10] as $carNumber)
            <div class="section-card">
                <div class="section-header">
                    <h3>
                        @if ($carNumber == 4)
                            <span class="mode-banner mode-standard">1-4車 一般模式</span>
                        @elseif ($carNumber == 6)
                            <span class="mode-banner mode-transfer">5-6車 特殊時間 + 換車</span>
                        @elseif ($carNumber == 8)
                            <span class="mode-banner mode-charter">7-8車 原時間 + 專車</span>
                        @elseif ($carNumber == 10)
                            <span class="mode-banner mode-transfer-charter">9-10車 特殊時間 + 專車</span>
                        @endif
                    </h3>
                    <p>維護各地點的車次說明內容，提供接駁作業查詢與現場調度使用。</p>
                </div>

                <div class="section-body">
                    <div class="table-responsive">
                        <table class="table erp-table">
                            <thead>
                                <tr>
                                    <th style="width: 180px;">地點</th>
                                    <th>說明內容</th>
                                    <th style="width: 120px;">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $filteredCarinfos = $carinfos->filter(function ($carinfo) use ($carNumber) {
                                        return $carinfo->CarNO == $carNumber;
                                    });
                                @endphp

                                @forelse ($filteredCarinfos as $carinfo)
                                    <tr>
                                        <form action="{{ route('carinfo.update', $carinfo->InfoID) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <td class="location-cell">
                                                {{ $carinfo->location->LocationName ?? '未設定' }}
                                            </td>
                                            <td>
                                                <textarea name="Narrate" class="narrate-box">{!! $carinfo->Narrate !!}</textarea>
                                            </td>
                                            <td class="action-cell">
                                                <button type="submit" class="btn btn-primary btn-sm px-3">更新</button>
                                            </td>
                                        </form>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="empty-state">目前尚無此車次模式資料</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="table-note">建議統一以簡潔段落維護文字內容，方便司機與調度快速閱讀。</div>
                </div>
            </div>
        @endforeach

    </div>
</div>
@endsection
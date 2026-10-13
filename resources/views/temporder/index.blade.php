@extends('layouts.app')

@push('styles')
<style>
    .temporder-page{
        display:flex;
        flex-direction:column;
        gap:16px;
        min-width:0;
    }

    .section-card{
        background:#fff;
        border:1px solid #d8cde4;
        border-radius:14px;
        box-shadow:0 10px 28px rgba(67,45,101,.10);
        padding:16px;
        overflow:visible !important;
        min-width:0;
    }

    .section-header{
        display:flex;
        justify-content:space-between;
        align-items:flex-end;
        gap:12px;
        margin-bottom:14px;
        flex-wrap:wrap;
    }

    .section-title h3{
        margin:0;
        font-size:24px;
        font-weight:700;
        color:#53357f;
    }

    .section-title p{
        margin:6px 0 0 0;
        font-size:13px;
        color:#6c6077;
    }

    .erp-table-wrap{
    width:100%;
    overflow-x:auto;
    overflow-y:auto;
    max-height:calc(100vh - 220px);

    border:1px solid #d8dee8;
    border-radius:12px;
    background:#fff;

    -webkit-overflow-scrolling:touch;
}

    .erp-table{
        width:max-content;
        min-width:1550px;
        border-collapse:collapse;
        table-layout:auto;
        background:#fff;
    }

    .erp-table th,
    .erp-table td{
        border:1px solid #ddd;
        padding:6px 8px;
        font-size:13px;
        text-align:center;
        vertical-align:middle;
        box-sizing:border-box;
    }

    .erp-table thead th{
        background:#e9edf3;
        font-weight:700;
        color:#334155;
        white-space:nowrap;
    }

    .erp-table td{
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis;
    }

    .wrap-text{
        white-space:normal !important;
        text-align:left;
        word-break:break-word;
        overflow-wrap:anywhere;
        line-height:1.45;
    }

    .col-action{ width:64px; min-width:64px; }
    .col-xs{ width:70px; min-width:70px; }
    .col-sm{ width:95px; min-width:95px; }
    .col-md{ width:125px; min-width:125px; }
    .col-lg{ width:260px; min-width:260px; }

    .action-cell{
        white-space:nowrap !important;
        text-align:center;
        overflow:visible !important;
    }

    .action-cell form{
        margin:0;
    }

    .btn-light{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        width:34px;
        height:34px;
        padding:0;
        border:1px solid #d6dee6;
        background:#f8fafc;
        border-radius:8px;
        transition:all .2s ease;
    }

    .btn-light:hover{
        background:#fff8db;
        border-color:#f2e3a7;
    }

    .btn-light img{
        display:block;
        width:16px;
        height:16px;
    }

    .empty-row{
        text-align:center;
        color:#64748b;
        padding:18px 10px !important;
        background:#fff;
    }

    /* ===== 狀態色系 ===== */
    .status-normal td{
        background:#ffffff;
    }

    .status-processing td{
        background:#fff8db;
    }

    .status-closed td{
        background:#eceff3;
    }

    .status-success td{
        background:#e8f5ec;
    }

    .status-error td{
        background:#fdecec;
    }

    /* 左側狀態條 */
    .status-normal td:first-child{
        border-left:4px solid #94a3b8;
    }

    .status-processing td:first-child{
        border-left:4px solid #f59e0b;
    }

    .status-closed td:first-child{
        border-left:4px solid #64748b;
    }

    .status-success td:first-child{
        border-left:4px solid #16a34a;
    }

    .status-error td:first-child{
        border-left:4px solid #dc2626;
    }

    /* Hover 不破壞原狀態 */
    .erp-table tbody tr:hover td{
        filter:brightness(0.97);
    }

    .status-badge{
        display:inline-block;
        padding:3px 8px;
        border-radius:999px;
        font-size:11px;
        font-weight:700;
        line-height:1.2;
    }

    .badge-normal{
        background:#f1f5f9;
        color:#475569;
    }

    .badge-processing{
        background:#fff7ed;
        color:#c2410c;
    }

    .badge-closed{
        background:#e2e8f0;
        color:#334155;
    }

    .badge-success{
        background:#dcfce7;
        color:#166534;
    }

    .badge-error{
        background:#fee2e2;
        color:#991b1b;
    }

    @media (max-width: 1600px){
        .erp-table th,
        .erp-table td{
            font-size:12px;
            padding:5px 6px;
        }

        .col-lg{
            width:220px;
            min-width:220px;
        }
    }

    @media (max-width: 768px){
        .section-card{
            padding:10px;
        }

        .section-title h3{
            font-size:20px;
        }

        .erp-table{
            min-width:1550px;
        }

        .erp-table th,
        .erp-table td{
            font-size:11px;
            padding:4px 5px;
        }

        .col-lg{
            width:240px;
            min-width:240px;
        }
    }
</style>
@endpush

@section('content')
<div class="temporder-page">

    <div class="section-card">
        <div class="section-header">
            <div class="section-title">
                <h3>五吉訂單列表</h3>
                <p>顯示所有五吉訂單資料與目前處理狀態</p>
            </div>
        </div>

        <div class="erp-table-wrap">
            <table class="erp-table">
                <thead>
                    <tr>
                        <th class="col-action" colspan="2">操作</th>
                        <th class="col-xs">編號</th>
                        <th class="col-md">出發日</th>
                        <th class="col-sm">地點</th>
                        <th class="col-md">回程日</th>
                        <th class="col-sm">地點</th>
                        <th class="col-xs">人數</th>
                        <th class="col-sm">代表1</th>
                        <th class="col-sm">電話1</th>
                        <th class="col-sm">代表2</th>
                        <th class="col-sm">電話2</th>
                        <th class="col-lg">需求</th>
                        <th class="col-md">入單時間</th>
                        <th class="col-sm">訂位人</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($temps as $temp)
                        <tr class="
                            @if ($temp->Close == 0)
                                status-normal
                            @elseif ($temp->Close == 1)
                                status-processing
                            @elseif ($temp->Close == 2)
                                status-closed
                            @endif
                        ">
                            <td class="action-cell">
                                @if ($temp->Close == 0)
                                    <form action="{{ route('temporder.update', ['temporder' => $temp->T_ID]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn-light" title="修改">
                                            <img src="{{ asset('images/change.png') }}" alt="修改">
                                        </button>
                                    </form>
                                @endif
                            </td>

                            <td class="action-cell">
                                <a href="{{ route('temporder.show', ['temporder' => $temp->T_ID]) }}" class="btn-light" title="查看">
                                    <img src="{{ asset('images/delete.gif') }}" alt="查看">
                                </a>
                            </td>
                            <td>{{ $temp->T_ID }}</td>

                            <td>
                                {{ $temp->Startdate }}<br>
                                <small>{{ $temp->PS1 }}</small>
                            </td>

                            <td>{{ $temp->Location1Name }}</td>

                            <td>
                                {{ $temp->Enddate }}<br>
                                <small>{{ $temp->PS2 }}</small>
                            </td>

                            <td>{{ $temp->Location2Name }}</td>

                            <td>{{ $temp->Number }}</td>

                            <td>{{ $temp->CusName1 }}</td>
                            <td>{{ $temp->CusPhone1 }}</td>
                            <td>{{ $temp->CusName2 }}</td>
                            <td>{{ $temp->CusPhone2 }}</td>

                            <td class="wrap-text">{{ $temp->Ps }}</td>

                            <td>{{ $temp->sign }}</td>
                            <td>{{ $temp->username }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="16" class="empty-row">目前沒有資料</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
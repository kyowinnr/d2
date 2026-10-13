@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">

    <div class="section-card">
        <div class="section-header">
            <div class="section-title">
                <h3>接駁名單查詢</h3>
                <p>查詢指定日期與車次的南下、北上名單與司機資料</p>
            </div>
        </div>

        <form method="GET" action="{{ route('longdistance.index') }}">
            <div class="table-toolbar">
                <div class="table-toolbar-left">
                    <div style="min-width: 180px;">
                        <input type="date" id="date" name="date" value="{{ $date }}" class="form-control" required>
                    </div>

                    <div style="min-width: 140px;">
                        <select id="carNumber" name="carNumber" class="form-control" required>
                            @for ($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}" {{ ($selectedCarNumber ?? old('carNumber')) == $i ? 'selected' : '' }}>
                                    {{ $i }}車
                                </option>
                            @endfor
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">查詢</button>
                </div>
            </div>
        </form>

        <div class="p-4">
            <div class="row">
                <div class="col-lg-8 mb-3 mb-lg-0">
                    <div class="p-3 rounded" style="background:#f8fafc; border:1px solid #dde3e8; color:#475569; line-height:1.9;">
                        <strong>車次說明：</strong>
                        <span class="mr-3">1-4 一般模式</span>
                        <span class="mr-3" style="color:#dc2626; font-weight:700;">5-6 特殊時間+換車</span>
                        <span class="mr-3">7-8 原時間+專車</span>
                        <span style="color:#dc2626; font-weight:700;">9-10 特殊時間+專車</span>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="p-3 rounded" style="background:#fff8db; border:1px solid #f1e3a5;">
                        <div style="font-weight:700; color:#7c5a00; margin-bottom:6px;">今日包車</div>
                        <div style="color:#5b6470;">
                            @forelse($charters as $charter)
                                <span class="badge badge-warning-soft mr-1 mb-1">{{ $charter->OrderId }}</span>
                            @empty
                                <span class="text-muted">無包車資料</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 南下 --}}
    <div class="section-card">
        <div class="section-header">
            <div class="section-title">
                <h3>{{ $date }} 南下名單</h3>
                <p>
                    南下共 <strong>{{ $total }}</strong> 人　
                    第 <strong>{{ $carNumber }}</strong> 車共 <strong>{{ $today_num }}</strong> 人
                </p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table erp-table mb-0">
                <thead>
                    <tr>
                        <th class="text-center">發車時間</th>
                        <th class="text-center">北段</th>
                        <th class="text-center">中段</th>
                        <th class="text-center">旅客代表</th>
                        <th class="text-center">人數</th>
                        <th class="text-center">電話</th>
                        <th class="text-center">回程</th>
                        <th class="text-center">備註</th>
                        <th class="text-center">查詢</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($results as $result)
                        @foreach($result['customers'] as $customer)
                            <tr>
                                <td class="text-center">{{ $result['order']->TimeOnly }}</td>
                                <td class="text-center">{{ $result['northName'] }}</td>
                                <td class="text-center">{{ $result['order']->LocationName }}</td>
                                <td class="text-center">
                                    <a href="{{ route('visa.index', ['CusId' => $customer->CusId]) }}" target="_blank" style="font-weight:700;">
                                        {{ $customer->Name }}
                                    </a>
                                </td>
                                <td class="text-center">{{ $result['order']->cusnum }}</td>
                                <td class="text-center">{{ $customer->Phone ?? '' }}</td>
                                <td class="text-center">{{ $result['comeDate'] }}</td>
                                <td>{{ $result['order']->Ps }}</td>
                                <td class="text-center">{{ $customer->TbNumber }}</td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">查無南下資料</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- 北上 --}}
    <div class="section-card">
        <div class="section-header">
            <div class="section-title">
                <h3>北上名單</h3>
                <p>
                    北上共 <strong>{{ $total2 }}</strong> 人　
                    第 <strong>{{ $carNumber }}</strong> 車共 <strong>{{ $today_num2 }}</strong> 人
                </p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table erp-table mb-0">
                <thead>
                    <tr>
                        <th class="text-center">發車時間</th>
                        <th class="text-center">北段</th>
                        <th class="text-center">中段</th>
                        <th class="text-center">旅客代表</th>
                        <th class="text-center">人數</th>
                        <th class="text-center">電話</th>
                        <th class="text-center">備註</th>
                        <th class="text-center">查詢</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($results2 as $result)
                        @foreach($result['customers'] as $customer)
                            <tr>
                                <td class="text-center">18:00</td>
                                <td class="text-center">{{ $result['northName'] }}</td>
                                <td class="text-center">{{ $result['order']->LocationName }}</td>
                                <td class="text-center">
                                    <a href="{{ route('visa.index', ['CusId' => $customer->CusId]) }}" target="_blank" style="font-weight:700;">
                                        {{ $customer->Name }}
                                    </a>
                                </td>
                                <td class="text-center">{{ $result['order']->cusnum }}</td>
                                <td class="text-center">{{ $customer->Phone ?? '' }}</td>
                                <td>{{ $result['order']->Ps }}</td>
                                <td class="text-center">{{ $customer->TbNumber }}</td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">查無北上資料</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- 司機資料 --}}
    <div class="section-card">
        <div class="section-header">
            <div class="section-title">
                <h3>司機資料管理</h3>
                <p>新增、修改與刪除司機資料</p>
            </div>
        </div>

        <form action="{{ route('longdistance.store') }}" method="POST">
            @csrf
            <div class="table-toolbar">
                <div class="table-toolbar-left">
                    <div style="min-width: 120px;">
                        <input type="number" name="Number" value="1" min="1" max="10" required class="form-control" placeholder="車次">
                    </div>

                    <div style="min-width: 360px; max-width: 520px; width: 100%;">
                        <input type="text" name="Main" placeholder="司機資料" class="form-control" required>
                    </div>

                    <input type="hidden" name="date" value="{{ $date }}">

                    <button type="submit" class="btn btn-primary">新增司機</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table erp-table mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 120px;">車次</th>
                        <th>司機資料</th>
                        <th class="text-center" style="width: 120px;">修改</th>
                        <th class="text-center" style="width: 120px;">刪除</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($busdata as $bus)
                        <tr>
                            <td class="text-center">
                                <form action="{{ route('longdistance.update', $bus->BusId) }}" method="POST" class="d-flex align-items-center justify-content-center mb-0">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="Number" value="{{ $bus->Number }}" min="1" max="10" required class="form-control text-center" style="max-width: 90px;">
                            </td>
                            <td>
                                    <input type="text" name="Main" value="{{ $bus->Main }}" class="form-control">
                            </td>
                            <td class="text-center">
                                    <button type="submit" class="btn btn-primary btn-sm">修改</button>
                                </form>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('longdistance.destroy', $bus->BusId) }}" method="POST" class="mb-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('確定要刪除此司機資料嗎？')">刪除</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">尚無司機資料</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- 南下候補 --}}
    @if ($reserve1->isNotEmpty())
        <div class="section-card">
            <div class="section-header">
                <div class="section-title">
                    <h3>南下候補資料</h3>
                    <p>待安排或候補中的南下名單</p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table erp-table mb-0">
                    <thead>
                        <tr>
                            <th>訂單編號</th>
                            <th class="text-center">人數</th>
                            <th>備註</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reserve1 as $item)
                            <tr>
                                <td>{{ $item->OrderId }}</td>
                                <td class="text-center">{{ $item->cusnum }}</td>
                                <td>{{ $item->Ps }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- 北上候補 --}}
    @if ($reserve2->isNotEmpty())
        <div class="section-card">
            <div class="section-header">
                <div class="section-title">
                    <h3>北上候補資料</h3>
                    <p>待安排或候補中的北上名單</p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table erp-table mb-0">
                    <thead>
                        <tr>
                            <th>訂單編號</th>
                            <th class="text-center">人數</th>
                            <th>備註</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reserve2 as $item)
                            <tr>
                                <td>{{ $item->OrderId }}</td>
                                <td class="text-center">{{ $item->cusnum }}</td>
                                <td>{{ $item->Ps }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>
@endsection
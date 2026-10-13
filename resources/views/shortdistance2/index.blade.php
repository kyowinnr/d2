@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">

    <div class="section-card">
        <div class="section-header">
            <div class="section-title">
                <h3>新營接駁名單查詢</h3>
                <p>查詢指定日期與車次的新營 ⇄ 布袋接駁名單與司機資料</p>
            </div>
        </div>

        <form method="GET" action="{{ route('shortdistance2.index') }}">
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
    </div>

    {{-- 新營 -> 布袋 --}}
    <div class="section-card">
        <div class="section-header">
            <div class="section-title">
                <h3>{{ $date }} 新營 → 布袋</h3>
                <p>
                    新營→布袋共 <strong>{{ $total }}</strong> 人　
                    第 <strong>{{ $carNumber }}</strong> 車共 <strong>{{ $today_num }}</strong> 人
                </p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table erp-table mb-0">
                <thead>
                    <tr>
                        <th class="text-center">發車時間</th>
                        <th class="text-center">站別</th>
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
                                <td class="text-center">{{ $result['order']->LocationName }}</td>
                                <td class="text-center" style="font-weight:700;">{{ $customer->Name }}</td>
                                <td class="text-center">{{ $result['order']->cusnum }}</td>
                                <td class="text-center">{{ $customer->Phone ?? '' }}</td>
                                <td class="text-center">{{ $result['comeDate'] }}</td>
                                <td>{{ $result['order']->Ps }}</td>
                                <td class="text-center">{{ $customer->TbNumber }}</td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">查無新營→布袋資料</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- 布袋 -> 新營 --}}
    <div class="section-card">
        <div class="section-header">
            <div class="section-title">
                <h3>布袋 → 新營</h3>
                <p>
                    布袋→新營共 <strong>{{ $total2 }}</strong> 人　
                    第 <strong>{{ $carNumber }}</strong> 車共 <strong>{{ $today_num2 }}</strong> 人
                </p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table erp-table mb-0">
                <thead>
                    <tr>
                        <th class="text-center">發車時間</th>
                        <th class="text-center">站別</th>
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
                                <td class="text-center">{{ $result['order']->LocationName }}</td>
                                <td class="text-center" style="font-weight:700;">{{ $customer->Name }}</td>
                                <td class="text-center">{{ $result['order']->cusnum }}</td>
                                <td class="text-center">{{ $customer->Phone ?? '' }}</td>
                                <td>{{ $result['order']->Ps }}</td>
                                <td class="text-center">{{ $customer->TbNumber }}</td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">查無布袋→新營資料</td>
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

        <form action="{{ route('shortdistance2.store') }}" method="POST">
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
                                <form action="{{ route('shortdistance2.update', $bus->BusId) }}" method="POST" class="d-flex align-items-center justify-content-center mb-0">
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
                                <form action="{{ route('shortdistance2.destroy', $bus->BusId) }}" method="POST" class="mb-0">
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

</div>
@endsection
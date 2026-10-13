@extends('layouts.app')

@section('content')
<div class="container">
    <h2>住宿訂單列表</h2>

    <form method="GET" action="{{ route('chotelorder.index') }}" class="mb-4">
        <div class="row g-2 align-items-center">
            <div class="col-auto">
                <label for="filter" class="col-form-label">資料篩選：</label>
            </div>
            <div class="col-auto">
            <select name="filter" id="filter" class="form-select" onchange="this.form.submit()">
                <option value="unfinished" {{ $filter === 'unfinished' ? 'selected' : '' }}>顯示未完成</option>
                <option value="not_closed" {{ $filter === 'not_closed' ? 'selected' : '' }}>只顯示未取消</option>
                <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>顯示全部</option>
            </select>
        </div>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th></th>
                <th>狀態</th>
                <th>訂金日期</th>
                <th>住宿日</th>
                <th>出團日</th>
                <th>客戶名稱</th>
                <th>電話</th>    
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $i => $order)
                <tr>
                    <td><a href="{{ route('chotelorder.show', ['chotelorder' => $order->Cid]) }}" target="_blank">{{ $i + 1 }}</a></td>
                    <td>{!! $order->close_type_badge !!}</td>
                    <td>{{ $order->DateLine }}</td>
                    <td>{{ $order->HotelDate }}</td>
                    <td>{{ $order->TourDate }}</td>
                    <td>{{ $order->Customer }}</td>
                    <td>{{ $order->Phone }}</td>     
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">查無資料</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection


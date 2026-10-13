@extends('layouts.app')

@section('content')
<div class="container">
    <!-- 表格顯示訂單資料 -->
    <table class="table table-bordered" class="table-responsive" style="width: 70%; margin: 0 auto;">
        <thead>
            <tr>
                <th>訂單編號</th>
                <th>訂單日期</th>
                <th>業者</th>
                <th>旅客代表</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->OrderId }}</td>
                    <td>{{ $order->OrderStart }}</td>
                    <td>{{ $order->OrderBuss }}</td>
                    <td>{{ $order->Name }}</td>
                    <td>
                        <!-- 資料與帳務超連結 -->
                        <a href="{{ route('ordermore.index', ['orderId' => $order->OrderId]) }}" target="_blank" class="btn btn-info btn-sm">資料</a>
                        <a href="{{ route('tbill.index', ['orderId' => $order->OrderId]) }}" class="btn btn-primary btn-sm">帳務</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection


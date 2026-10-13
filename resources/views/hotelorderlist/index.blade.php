@extends('layouts.app')

@section('content')
<div class="container">
    <table class="table" style="width: 50%; margin: auto;">
        <thead>
            <tr>
                <th>訂單日期</th>
                <th>飯店名稱</th>     
            </tr>
        </thead>
        <tbody>
            @foreach($hotelOrders as $order)
            <tr>
                <td>{{ $order->OrderDate }}</td>
                    <td>
                        <!-- 設定超連結到 HotelOrderId -->
                        <a href="{{ route('hotelorderlist.show', $order->HotelOrderId) }}" class="text-primary">
                            {{ $order->HotelName }}
                        </a>
                    </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection


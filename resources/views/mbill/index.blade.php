@extends('layouts.app')

@section('content')
<div class="container mt-5">
 <!-- 搜尋表單 -->
    <form action="{{ route('mbill.store') }}" method="POST" class="mb-4">
     @csrf
    <table class="table table-bordered">
      <tr>
        <td><input type="text" class="form-control" id="orderBuss" name="orderBuss" value="{{ $orderBuss ?? '' }}" placeholder="名稱"></td>
        <td><input type="date" class="form-control" id="startDate" name="startDate" value="{{ $startDate ?? '' }}"></td>
        <td><input type="date" class="form-control" id="endDate" name="endDate" value="{{ $endDate ?? '' }}"></td>
        <td><button type="submit" class="btn btn-primary">搜尋</button></td>
      </tr>
    </table>
    </form>

    <!-- 搜尋結果表格 -->
    @if(isset($orders) && count($orders) > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>訂單編號</th>
                    <th>訂單日期</th>
                    <th>人數</th>
                    <th>代表人</th>
                    <th>應收總金額</th>
                    <th>扣除總金額</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->OrderId }}</td>
                        <td>{{ $order->OrderStart }}</td>
                        <td align="center">{{ $order->CusNum }}</td>
                        <td>{{ $order->Name }}</td>
                        <td>{{ number_format($order->total_receivable, 0) }}</td>
                        <td>{{ number_format($order->total_deduction, 0) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- 合計資訊 -->
        <div class="mt-3 d-flex justify-content-end">
          <div>
            <p><strong>全部合計應收金額：</strong> {{ number_format($total_receivable, 0) }}</p>
            <p><strong>全部合計扣除金額：</strong> {{ number_format($total_deduction, 0) }}</p>
            <p><strong>應收淨額：</strong> {{ number_format($net_amount, 0) }}</p>
          </div>  
        </div>
    @endif
</div>
@endsection


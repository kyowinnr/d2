@extends('layouts.app')
<script>
    function openSearchWindow() {
        window.open('/search-continent', '搜尋洲別', 'width=800,height=600');
    }
</script>
@section('content')
<div style="" class="container">  
     <form action="{{ route('cusselect.update', ['cusselect' => $ordertraffic->OrderTrafficId]) }}" method="POST">
        @csrf
        @method('PUT') <!-- 這是更新請求的標準方法 -->
        <table border="1" cellspacing="0" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>{{$ordertraffic->Date}}</th>
                    <th colspan="3">{{$ordertraffic->TrafficName}}</th>
                </tr>
                <tr>
                    <th colspan="4">接駁車選旅客代表，船票請選全部正確名單</th>
                </tr>
                <tr>
                    <!-- 全選的勾選框 -->
                    <th>
                        <input type="checkbox" id="select-all" 
                            @if ($isAllSelected) checked @endif>
                        全選/全不選
                    </th>
                    <th>生日</th>
                    <th>身分證</th>
                    <th>電話</th>
                </tr>
            </thead>
            <tbody>
               @foreach ($customers as $customer)
              <tr>
                <td>
                   <input type="checkbox" name="customer_ids[]" value="{{ $customer->CusId }}"  class="customer-checkbox"
                      @if ($isAllSelected || in_array($customer->CusId, $selectedCustomerIds)) checked @endif>
                         {{ $customer->Name }}
                 </td>
                 <td>{{ $customer->Birthday }}</td>
                 <td>{{ $customer->ID }}</td>
                 <td>{{ $customer->Phone }}</td>
              </tr>
              @endforeach

                 <!-- 送出按鈕 -->
                <tr>
                 <td colspan="4" align="right"> <button type="submit" class="btn btn-primary">送出</button></td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 全選的勾選框
        const selectAllCheckbox = document.getElementById('select-all');
        // 每個客戶的勾選框
        const customerCheckboxes = document.querySelectorAll('.customer-checkbox');

        // 如果所有的客戶勾選框都已勾選，則全選框也應該被勾選
        selectAllCheckbox.checked = Array.from(customerCheckboxes).every(cb => cb.checked);

        // 當全選勾選框狀態變化時，控制所有客戶勾選框
        selectAllCheckbox.addEventListener('change', function () {
            const isChecked = selectAllCheckbox.checked;
            customerCheckboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
            });
        });

        // 當任何客戶勾選框狀態變化時，檢查是否應取消全選
        customerCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                if (!this.checked) {
                    selectAllCheckbox.checked = false; // 若有一個未勾選，取消全選
                } else {
                    // 檢查是否所有都勾選，如果是，則勾選全選框
                    const allChecked = Array.from(customerCheckboxes).every(cb => cb.checked);
                    selectAllCheckbox.checked = allChecked;
                }
            });
        });
    });
</script>


@endsection


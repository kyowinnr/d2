@extends('layouts.app')

@section('content')
<center>
    <table border=1  style="font-weight: bold;" cellpadding="5" cellspacing="0">
        <thead>
            <tr>            
                <td colspan="11">{{ $traffic->TrafficName }}</td>              
            </tr>
            
        </thead>
        <tbody>
            <tr>
                <th>總編號</th>
                <th>編號</th>
                <th>時間</th>
                <th>姓名</th>
                <th>性別</th>
                <th>身分證字號</th>
                <th>生日</th>
                <th>電話</th>
                <th>票種</th>
                <th>去/回程</th>
                <th>備註</th>                
            </tr>
            @foreach($customers as $customerData)
            @foreach($customerData['customerList'] as $customer)
                <tr style="background-color: {{ $customer->color }}">
                    <td>{{$customer->totalNum}}</td>
                    <td>{{$customer->groupNum}}</td>
                    <td>{{ $customerData['date'] }}</td>
                    <td>{{ $customer->Name}}</td>
                    <td>{{ $customer->Sex}}</td>
                    <td>{{ $customer->ID}}</td>
                    <td>{{ $customer->Birthday}}</td>
                    <td>{{ $customer->Phone}}</td>
                    <td>{{ $customer->TicketType}}</td>
                    <td>{{ $customer->comebackDate}}</td>
                    <td>{{ $customer->Ps}}</td>
                </tr>
            @endforeach
        @endforeach
        </tbody>
    </table>
</center>    
@endsection


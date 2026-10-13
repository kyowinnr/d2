@extends('layouts.app')

@section('content')
<div style="margin:20px 5%;">
    <div style="background:#fff;border:1px solid #dde3e8;border-radius:12px;overflow:hidden;">
        <table class="table" style="margin:0;">
            <thead>
                <tr style="background:#e9edf3;color:#334155;text-align:center;font-size:13px;">
                    <th>序號</th>
                    <th>姓名</th>
                    <th>英文姓</th>
                    <th>英文名</th>
                    <th>性別</th>
                    <th>身分證字號</th>
                    <th>生日</th>
                    <th>護照號碼</th>
                    <th>護照效期</th>
                    <th>電話</th>
                    @if ($type==2)
                    <th>台胞證號</th>
                    <th>台胞效期</th>                    
                    <th>備註</th>
                    @endif
                </tr>
            </thead>
            <tbody style="text-align:center;font-size:13px;">
                @foreach ($customers as $customer)
                @php
                    $nameParts = explode(',', $customer->EName);
                    $lastName = $nameParts[0] ?? '';
                    $firstName = $nameParts[1] ?? '';
                @endphp
                <tr style="border-top:1px solid #edf1f5;">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $customer->Name }}</td>
                    <td>{{ $lastName }}</td>
                    <td>{{ $firstName }}</td>
                    <td>
                        @if ($customer->Sex == 2)
                            F
                        @elseif ($customer->Sex == 1)
                            M
                        @else
                            error
                        @endif
                    </td>
                    <td>{{ $customer->ID }}</td>
                    <td>{{ $customer->Birthday }}</td>
                    <td>{{ $customer->PpNumber }}</td>
                    <td>{{ $customer->PpDate1 }}</td>
                    <td>{{ $customer->Phone }}</td>
                    @if ($type==2)
                    <td>{{ $customer->TbNumber }}</td>
                    <td>{{ $customer->TbDate }}</td>                    
                    <td>{{ $customer->Ps }}</td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
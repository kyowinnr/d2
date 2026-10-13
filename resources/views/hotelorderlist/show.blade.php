@extends('layouts.app')

@section('content')
<div class="container">
    <table border="1" width="600px" cellspacing="0" style="font-size:20px;   margin: auto;" bordercolor="#000000">
    <tr>
      <td align="center" colspan="2" style="font-size:32px">訂房單</td>
    </tr>
    <tr>
      <td rowspan="2" align="left">TO:{{ $order->HotelName }}</td>
      <td align="left">電話:{{ $order->HotelTel }}</td>
    </tr>
    <tr>
      <td align="left">傳真:{{ $order->HotelFax }}</td>
    </tr>
    <tr>
      <td colspan="2" align="left" height="50px">住宿日期{{ $order->OrderDate }}共{{ $order->Night}}晚
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BY龍之嶺-{{$order->username}}</td>
    </tr>
    <tr>
      <td colspan="2" height="130px" style="text-align:left" valign="top">{!! nl2br($order->Main) !!}</td>
    </tr>
    <tr>
      <td width="50%"  style="text-align:left" valign="top">龍之嶺旅遊確認章<img src="{{ asset('images/logo.gif') }}" width="180px" /></td>
      <td  style="text-align:left" valign="top">確認請蓋章回傳</td>
    </tr>
    <tr>
      <td colspan="2" align="left">
        龍之嶺旅遊-麗誠旅行社&nbsp;&nbsp;TEL:04-3704-0306&nbsp;&nbsp;FAX:04-2256-9636<br>
        台中市南屯區五權西路二段666號14F-5
      </td>
    </tr>
  </table>
</div>
@endsection


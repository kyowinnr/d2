@extends('layouts.app')

@section('content')
<div style="margin: 0 5%;">
            <table class="table table-bordered tanle-hover">
                <thead>
                    <tr style="color:white; background-color:red;">
                        <th>編號</th>
                        <th>入單時間</th>                        
                        <th>訂位人</th>
                        <th>出發日</th>
                        <th>地點</th>
                        <th>回程日</th>
                        <th>地點</th>
                        <th>總人數</th>
                        <th>旅客代表</th>
                        <th>電話</th>
                        <th>旅客代表</th>
                        <th>電話</th>
                        <th>特殊需求</th>
                        <th colspan="2"></th>                                           
                    </tr>
                </thead>
                <tbody>
                  @foreach ($temps as $temp)
               <tr   @if ($temp->Close == 0)   style="background-color:white;" 
                     @elseif($temp->Close == 1)   style="background-color: yellow;"   
                     @elseif ($temp->Close == 2)    style="background-color:#3C3C3C; "    @endif           >
                <td>{{ $temp->T_ID}}</td>
                <td>{{ $temp->sign}}</td>                
                <td>{{ $temp->Often_Group }}</td>
                <td>{{ $temp->Startdate }}--{{ $temp->PS1 }}</td>
                <td>{{ $temp->Location1Name }}</td>
                <td>{{ $temp->Enddate }}--{{ $temp->PS2 }}</td>
                <td>{{ $temp->Location2Name }}</td>
                <td>{{ $temp->Number }}</td>
                <td>{{ $temp->CusName1 }}</td>
                <td>{{ $temp->CusPhone1 }}</td>
                <td>{{ $temp->CusName2 }}</td>
                <td>{{ $temp->CusPhone2 }}</td>
                <td>{{ $temp->Ps }}</td>
                <td>
                 @if ($temp->Close == 0)
                    <form action="{{ route('temporder2.update', ['temporder2' => $temp->T_ID]) }}" method="POST" style="display:inline;">
                       @csrf   @method('PUT')
                     <button type="submit" style="border: none; background: none;">
                       <img src="images/change.png" width="20px">
                     </button>
                    </form> 
                 @endif
                </td>
                <td>
                <a href="{{ route('temporder2.show', ['temporder2' => $temp->T_ID]) }}">
                  <img src="images\delete.gif">
                </a>  
                  </td>
            </tr>
        @endforeach
                </tbody>
            </table>
    </div>
</div>
@endsection


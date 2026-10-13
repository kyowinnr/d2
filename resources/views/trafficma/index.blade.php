@extends('layouts.app')

@section('content')
<div class="container">
    <!-- 顯示交通資料 -->
    <div class="table-responsive" style="width: 50%; margin: 0 auto;">
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>交通名稱</th>
                    <th>顯示狀態</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <form action="{{ route('trafficma.store') }}" method="POST" class="form-inline">
                 @csrf
                 <td><input type="text" name="TrafficName" class="form-control" placeholder="新增交通名稱" required></td>
                 <td>&nbsp;</td>
                 <td><button type="submit" class="btn btn-success">新增</button></td>
                </form>
                
                </tr>
                @foreach($traffics as $traffic)  <!-- 使用傳遞進來的 $traffics 變數 -->
                    <tr>
                        <form action="{{ route('trafficma.update', $traffic->TrafficId) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <td>
                                <input type="text" name="TrafficName" value="{{ $traffic->TrafficName }}" class="form-control">
                            </td>

                            <td>
                                <select name="Display" class="form-control">
                                    <option value="Y" {{ $traffic->Display == 0 ? 'selected' : '' }}>Y</option>
                                    <option value="N" {{ $traffic->Display == 1 ? 'selected' : '' }}>N</option>
                                </select>
                            </td>

                            <td>
                                <button type="submit" class="btn btn-primary">修改</button>
                            </td>
                        </form>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection


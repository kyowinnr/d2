@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <!-- 區塊 2 -->
        <div class="col-md-4">
            <form action="{{ route('visasearch.index') }}" method="GET">
                <input type="text" name="CusName" size=7 placeholder="姓名">
                <button type="submit" class="btn btn-primary">查詢</button>
            </form>
        </div>
    </div>
    <br>
    <!-- 顯示查詢結果 -->
            <table class="table table-bordered">
                <thead>
                    <tr style="color:#000; background-color:#C9F">
                        <th>姓名</th>                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                       <tr>
                            <td><a href="{{ route('visa.index', ['CusId' => $customer->CusId]) }}">{{ $customer->Name }} </a> </td> 
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
</div>
@endsection


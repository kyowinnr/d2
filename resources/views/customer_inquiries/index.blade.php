@extends('layouts.app')

@section('content')
<div class="container" style="background:#D0D0D0; padding:20px;">

    <div style="background:#FFF; padding:20px; border:1px solid #CCC;">
        
        <div class="d-flex justify-content-between mb-3">
            <h4>團體詢問記錄</h4>
            <a href="{{ route('customer_inquiries.create') }}" class="btn btn-primary">新增</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead style="background:#EEE;">
                <tr>
                    <th>編號</th>
                    <th>客戶名稱</th>
                    <th>詢問內容</th>
                    <th>電話</th>
                    <th>業務</th>
                    <th>日期</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inquiries as $row)
                <tr>
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->customer_name }}</td>
                    <td>{{ $row->content }}</td>
                    <td>{{ $row->phone }}</td>
                    <td>{{ $row->salesperson }}</td>
                    <td>{{ $row->inquiry_date }}</td>
                    <td style="white-space:nowrap;">
                        <a href="{{ route('customer_inquiries.edit', $row->id) }}" class="btn btn-sm btn-warning">編輯</a>

                        <form action="{{ route('customer_inquiries.destroy', $row->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('確定刪除?')" class="btn btn-sm btn-danger">刪除</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</div>
@endsection
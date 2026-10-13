@extends('layouts.app')

@section('content')
<div class="container" style="background:#D0D0D0; padding:20px;">

    <div style="background:#FFF; padding:20px; border:1px solid #CCC;">
        <h4 style="margin-bottom:20px;">編輯客戶詢問</h4>

        <form method="POST" action="{{ route('customer_inquiries.update', $inquiry->id) }}">
            @csrf
            @method('PUT')

            <table class="table table-bordered">
                <tr>
                    <th style="width:150px;">客戶名稱</th>
                    <td>
                        <input type="text" name="customer_name" class="form-control"
                               value="{{ $inquiry->customer_name }}" required>
                    </td>
                </tr>

                <tr>
                    <th>詢問內容</th>
                    <td>
                        <textarea name="content" class="form-control" rows="4" required>{{ $inquiry->content }}</textarea>
                    </td>
                </tr>

                <tr>
                    <th>聯絡電話</th>
                    <td>
                        <input type="text" name="phone" class="form-control"
                               value="{{ $inquiry->phone }}">
                    </td>
                </tr>

                <tr>
                    <th>業務人員</th>
                    <td>
                        <input type="text" name="salesperson" class="form-control"
                               value="{{ $inquiry->salesperson }}">
                    </td>
                </tr>

                <tr>
                    <th>詢問日期</th>
                    <td>
                        <input type="date" name="inquiry_date" class="form-control"
                               value="{{ $inquiry->inquiry_date }}">
                    </td>
                </tr>
                @if (session('permission') == 1)
                <tr>
                    <th>管理者備註</th>
                    <td>
                        <textarea name="note" class="form-control" rows="3">{{ $inquiry->note }}</textarea>
                    </td>
                </tr>
                @endif
                <tr>
                    <td colspan="2" style="text-align:right;">
                        <button type="submit" class="btn btn-primary">更新</button>
                        <a href="{{ route('customer_inquiries.index') }}" class="btn btn-secondary">返回</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>

</div>
@endsection
<!-- resources/views/guestbook/index.blade.php -->
@extends('layouts.app')


@section('content')
<div class="container"><br>
    <div class="mb-4">
        <form action="{{ route('guestbook.store') }}" method="POST" class="form-inline">
    @csrf
    <div class="form-group mr-2">
        <input type="text" name="content" id="content" class="form-control" placeholder="交辦內容" value="{{ old('content') }}">
    </div>
    <div class="form-group mr-2">
        <input type="text" name="starter" id="starter" class="form-control" placeholder="交辦人" value="{{ old('starter') }}">
    </div>
    <button type="submit" class="btn btn-primary">建立</button>
</form>

    </div>

    <div class="mb-4">
            <table class="table">
                <thead>
                    <tr>
                        <th>交辦時間</th>
                        <th>內容</th>
                        <th>交辦人</th>
                        <th>刪除</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($guestbooks as $guestbook)
                        <tr>
                            <td>{{ $guestbook->S_Time }}</td>
                            <td>{{ $guestbook->Main}}</td>
                            <td>{{ $guestbook->Starter }}</td>
                            <td><!-- 刪除按鈕表單 -->
                              <form action="{{ route('guestbook.destroy', $guestbook->Gid) }}" method="POST" style="display:inline;">
                                 @csrf
                                 @method('DELETE')
                                 <button type="submit" class="btn btn-danger btn-sm">刪除</button>
                              </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
</div>    
@endsection


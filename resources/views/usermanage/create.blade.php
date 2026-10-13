@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width:900px;">
    <div class="card border-0 shadow-sm">
        <div class="card-header" style="background:#f3f4f6;">
            <h4 class="mb-0">新增使用者</h4>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('usermanage.store') }}">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">帳號</label>
                        <input type="text" name="usercode" class="form-control" value="{{ old('usercode') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">姓名</label>
                        <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">電話</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">權限</label>
                        <input type="number" name="permission" class="form-control" value="{{ old('permission', 0) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">密碼</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">確認密碼</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger mt-3 mb-0">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">儲存</button>
                    <a href="{{ route('usermanage.index') }}" class="btn btn-secondary">返回</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
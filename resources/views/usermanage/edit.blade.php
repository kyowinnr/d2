@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width:900px;">
    <div class="card border-0 shadow-sm">
        <div class="card-header" style="background:#f3f4f6;">
            <h4 class="mb-0">修改使用者 / 重設密碼</h4>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('usermanage.update', $user->id) }}">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">帳號</label>
                        <input type="text" name="usercode" class="form-control" value="{{ old('usercode', $user->usercode) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">姓名</label>
                        <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">電話</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">權限</label>
                        <input type="number" name="permission" class="form-control" value="{{ old('permission', $user->permission) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">新密碼</label>
                        <input type="password" name="password" class="form-control">
                        <small class="text-muted">不修改密碼可留空</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">確認新密碼</label>
                        <input type="password" name="password_confirmation" class="form-control">
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
                    <button type="submit" class="btn btn-primary">儲存修改</button>
                    <a href="{{ route('usermanage.index') }}" class="btn btn-secondary">返回</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
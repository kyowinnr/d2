@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width:1200px;">

    <div class="card border-0 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center" style="background:#f3f4f6;">
            <h4 class="mb-0">使用者管理</h4>

            <a href="{{ route('usermanage.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i>
            </a>
        </div>

        <div class="card-body p-0">

            @if(session('success'))
                <div class="alert alert-success m-3">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger m-3">{{ session('error') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0 user-table">
                    <thead>
                        <tr>
                            <th style="width:80px;">ID</th>
                            <th>帳號</th>
                            <th>姓名</th>
                            <th>電話</th>
                            <th style="width:100px;">權限</th>
                            <th style="width:100px;"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($users as $user)
                        <tr class="row-hover">
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->usercode }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->permission }}</td>

                            <td class="text-center">
                                <div class="action-group">

                                    <!-- 修改 -->
                                    <a href="{{ route('usermanage.edit', $user->id) }}"
                                       class="action-btn text-primary"
                                       title="修改">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <!-- 刪除 -->
                                    <form action="{{ route('usermanage.destroy', $user->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('確定要刪除此使用者嗎？')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="action-btn text-danger"
                                                title="刪除">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @endforeach

                        @if($users->count() == 0)
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">目前沒有資料</td>
                        </tr>
                        @endif

                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection


@push('styles')
<style>

/* 表頭 */
.user-table thead {
    background: #e5e7eb;
    color: #374151;
}

/* 列 hover */
.row-hover:hover {
    background: #f9fafb;
}

/* 操作區（預設隱藏） */
.action-group {
    display: flex;
    justify-content: center;
    gap: 8px;
    opacity: 0;
    transition: 0.2s;
}

/* hover 顯示 */
.row-hover:hover .action-group {
    opacity: 1;
}

/* icon 按鈕 */
.action-btn {
    border: none;
    background: none;
    padding: 4px 6px;
    font-size: 16px;
    cursor: pointer;
    transition: 0.2s;
}

/* hover 效果 */
.action-btn:hover {
    transform: scale(1.2);
}

/* 刪除按鈕避免 form 影響排版 */
.action-group form {
    display: inline;
    margin: 0;
}

</style>
@endpush
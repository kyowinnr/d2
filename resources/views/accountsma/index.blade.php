@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <!-- 新增資料的表單 -->
        <form action="{{ route('accountsma.store') }}" method="POST" class="col-md-12 mb-3">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-4">
                    <input type="text" name="ItemName" class="form-control" placeholder="新增名稱" required>
                </div>
                <div class="form-group col-md-4">
                    <select name="ItemType" class="form-control" required>
                        <option value="1">行程</option>
                        <option value="0">帳務</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <button type="submit" class="btn btn-primary">新增</button>
                </div>
            </div>
        </form>
    </div>

    <table class="table table-bordered" >
        <thead class="thead-light">
            <tr>
                <th>名稱</th>
                <th>類型</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <form action="{{ route('accountsma.update', $item->ItemId) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <td>
                            <input type="text" name="ItemName" value="{{ $item->ItemName }}" class="form-control" required>
                        </td>
                        <td>
                            <select name="ItemType" class="form-control" required>
                                <option value="1" {{ $item->ItemType == 1 ? 'selected' : '' }}>行程</option>
                                <option value="0" {{ $item->ItemType == 0 ? 'selected' : '' }}>帳務</option>
                            </select>
                        </td>
                        <td>
                            <button type="submit" class="btn btn-success">修改</button>
                        </td>
                    </form>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection


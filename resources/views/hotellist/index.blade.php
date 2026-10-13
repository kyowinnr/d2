@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="GET" action="{{ route('hotellist.index') }}">
            <input type="text" name="search" value="{{ old('search', $search) }}" placeholder="搜尋飯店名稱">
            <button type="submit">搜尋</button>
        </form>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>飯店名稱</th>
                    <th>洲</th>
                    <th>地址</th>
                    <th>電話</th>
                    <th>傳真</th>
                    <th>修改</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hotels as $hotel)
                    <tr>
                        <form method="POST" action="{{ route('hotellist.update', $hotel->HotelId) }}">
                            @csrf
                            @method('PUT')
                            <td><input type="text" name="HotelName" value="{{ $hotel->HotelName }}"></td>
                            <td>
                                <select name="HotelLocalId">
                                    @foreach ($continents as $continent)
                                        <option value="{{ $continent->ContinentID }}" 
                                            {{ $hotel->HotelLocalId == $continent->ContinentID ? 'selected' : '' }}>
                                            {{ $continent->Country }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="text" name="HotelAdd" value="{{ $hotel->HotelAdd }}"></td>
                            <td><input type="text" name="HotelTel" value="{{ $hotel->HotelTel }}"></td>
                            <td><input type="text" name="HotelFax" value="{{ $hotel->HotelFax }}"></td>
                            <td>
                                <button type="submit">修改</button>
                            </td>
                        </form>
                        <td> <!-- 訂房按鈕 --><a href="" class="btn btn-success btn-sm">訂房</a></td>
                        <td>
                    <!-- 刪除按鈕 -->
                    <form action="{{ route('hotellist.destroy', $hotel->HotelId) }}" method="POST" style="display:inline-block;">
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
@endsection


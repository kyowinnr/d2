<!-- resources/views/location/index.blade.php -->
@extends('layouts.app')

@section('title', '地點管理')

@section('header', '地點管理')

@section('content')
<div class="container">
    <!-- 新增地點表單 -->
    <br>
    <form action="{{ route('location.store') }}" method="POST" class="form-inline mb-4">
        @csrf
        <div class="form-group mr-2">
            <label for="continent_id" class="mr-2">國家:</label>
            <select name="continent_id" id="continent_id" class="form-control">
                @foreach($countries as $country)
                    <option value="{{ $country->ContinentID }}">{{ $country->Country }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group mr-2">
            <label for="location_name" class="mr-2">地點名稱:</label>
            <input type="text" name="location_name" id="location_name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">新增地點</button>
    </form>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>國家/地點</th>
                <th>地點名稱</th>                
                <th>顯示狀態</th>
            </tr>
        </thead>
        <tbody>
        
            @foreach($locations as $location)
            <form action="{{ route('location.update', $location->LocationId) }}" method="POST">
                        @csrf
                        @method('PUT')
            <tr>
                <!-- 可編輯的國家下拉選單 -->
                <td>
                    <select name="continent_id" class="form-control">
                        @foreach($countries as $country)
                            <option value="{{ $country->ContinentID }}" {{ $location->ContinentID == $country->ContinentID ? 'selected' : '' }}>
                                {{ $country->Country }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <!-- 可編輯的地點名稱文字框 -->
                <td>
                    <input type="text" name="location_name" value="{{ $location->LocationName }}" class="form-control">
                </td>
                <!-- 顯示狀態下拉選單 -->
                <td>
                    <select name="display_status" class="form-control">
                        <option value="Y" {{ $location->DisplayStatus == 'Y' ? 'selected' : '' }}>Y</option>
                        <option value="N" {{ $location->DisplayStatus == 'N' ? 'selected' : '' }}>N</option>
                    </select>
                </td>

                <!-- 修改按鈕 -->
                <td>
                  <button type="submit" class="btn btn-success">修改</button>                    
                </td>
            </tr>
            </form>
            @endforeach
        </tbody>
    </table>
</div>
@endsection


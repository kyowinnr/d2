@extends('layouts.app')

@section('content')
    <div >  

        <!-- 資料表格 -->
        <div class="col-md-12">
            <table class="table table-bordered" >
                <!-- 新增資料表單 -->
                <form action="{{ route('localts.store') }}" method="POST">
                @csrf
                <thead class="thead-light">
                    <tr>
                        <th><input type="text" name="LocalTsName" class="form-control" placeholder="名稱" required></th>
                        <th>
                          <select name="HotelLocalId" class="form-control" required>
                        <option value="">類型</option>
                        @foreach($hotels as $hotel)
                            <option value="{{ $hotel->HotelLocalId }}">{{ $hotel->LocalName }}</option>
                        @endforeach
                    </select>
                        </th>
                        <th><input type="text" name="LocalTsAdd" class="form-control" placeholder="地址" required></th>
                        <th><input type="text" name="LocalTsTEL" class="form-control" placeholder="電話" required></th>
                        <th><input type="text" name="LocalTsFax" class="form-control" placeholder="傳真"></th>
                        <th><input type="text" name="LocalTsMan" class="form-control" placeholder="負責人"></th>
                                          
                        <th><button type="submit" class="btn btn-success">新增</button></th>
                    </tr>
                </thead>
                </form>
                <tbody>
                    <tr>
                        <th>名稱</th>
                        <th>類別</th>
                        <th>地址</th>
                        <th>電話</th>
                        <th>傳真</th>
                        <th>負責人</th>                        
                        <th>操作</th>
                    </tr>
                    @foreach($localts as $local)
                        <tr>
                            <form action="{{ route('localts.update', $local->LocalTsId) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <td><input type="text" name="LocalTsName" value="{{ $local->LocalTsName }}" class="form-control"></td>
                                 <td>
                                    <select name="HotelLocalId" class="form-control">
                                        @foreach($hotels as $hotel)
                                            <option value="{{ $hotel->HotelLocalId }}" {{ $local->HotelLocalId == $hotel->HotelLocalId ? 'selected' : '' }}>
                                                {{ $hotel->LocalName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="text" name="LocalTsAdd" value="{{ $local->LocalTsAdd }}" class="form-control"></td>
                                <td><input type="text" name="LocalTsTEL" value="{{ $local->LocalTsTEL }}" class="form-control"></td>
                                <td><input type="text" name="LocalTsFax" value="{{ $local->LocalTsFax }}" class="form-control"></td>
                                <td><input type="text" name="LocalTsMan" value="{{ $local->LocalTsMan }}" class="form-control"></td>
                               
                                <td>
                                    <button type="submit" class="btn btn-primary">修改</button>
                                </td>
                            </form>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection


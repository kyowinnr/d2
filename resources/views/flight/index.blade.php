@extends('layouts.app')
<script>
    function openSearchWindow() {
        window.open('/search-continent', '搜尋洲別', 'width=800,height=600');
    }
</script>
@section('content')
<form  name="form" action={{ route('flight.store') }} method="post">
@csrf
<div class="container">
  <div class="col-12 col-md-12" style="color:red;"><h3>批次開檔</h3></div>
  
   <div class="row">
    <div class="col-6 col-md-1"><h5>開始日</h5></div>
    <div class="col-6 col-md-3"><input type="date" name="date1" class="form-control" min="2023-04-01" max="2123-12-30"></div>
    <div class="col-6 col-md-1"><h5>結束日</h5></div>
    <div class="col-6 col-md-3"><input type="date" name="date2" class="form-control" min="2023-04-01" max="2123-12-30"></div>
    <div class="col-6 col-md-1"><h5>人數</h5></div>
    <div class="col-6 col-md-1"><input type="number" name="Number" min="1" id="Number" class="form-control"></div>
  </div>
  <div class="row">
     <div class="col-6 col-md-1">類型</div>
     <div class="col-6 col-md-1"><input name="direction" type="radio" value="1" checked="checked" />南下</div>
     <div class="col-6 col-md-1"><input name="direction" type="radio" value="2" />北上</div>
     <div class="col-6 col-md-1"><input name="direction" type="radio" value="3" />布馬</div>
     <div class="col-6 col-md-2"><input name="direction" type="radio" value="4" />馬布</div>
  </div>
  <div class="row">
     <div class="col-6 col-md-1">船票價格</div>
     <div class="col-6 col-md-1"><input type="number" name="price" min="1" class="form-control"></div>
     <div class="col-6 col-md-3"><input type="submit" class="btn btn-success"   value="送出"/></div>
  </div> 
  </form>
  <hr style="background-color:red;height: 1px;">
  <div class="row">
    <form method="GET" action="{{ route('flight.index') }}">
    @csrf
    <div class="form-group">
        <select name="direction" id="direction" class="form-control" onchange="this.form.submit()">
            <option value="1" {{ $direction == 1 ? 'selected' : '' }}>南下</option>
            <option value="2" {{ $direction == 2 ? 'selected' : '' }}>北上</option>
        </select>
    </div>
   </form>
  <form name="form3" action="{{ route('flight.renew') }}" method="post">
  @csrf
     <div class="col-6 col-md-3"><input type="submit" class="btn btn-success"   value="一鍵更新"/></div>
  </form>
    </div>
  <div class="row">
     <div class="col-6 col-md-2">日期</div>
     <div class="col-6 col-md-2">剩餘空位</div>
     <div class="col-6 col-md-2"></div>
  </div>
  
  
    @foreach ($flights as $flight)
    <form name="form2" action="{{ route('flight.update', ['flight' => $flight->F_Id]) }}" method="POST">
    @csrf
    @method('PUT') <!-- 更新請求需要使用 PUT 或 PATCH -->
   <div class="row">
     <div class="col-6 col-md-2">{{ $flight->Date }}</div>
     <div class="col-3 col-md-2"><input type="number" name="number" min=0 class="form-control"  value="{{ $flight->Number }}"></div>
      <div class="col-3 col-md-2">
            <!-- 下拉方塊 -->
            <select name="lock" id="lock-select" class="form-control" 
                style="{{ $flight->Lock == 1 ? 'background-color: red; color: white;' : '' }}">
                <option value="0" {{ $flight->Lock == 0 ? 'selected' : '' }}>開放</option>
                <option value="1" {{ $flight->Lock == 1 ? 'selected' : '' }}>鎖</option>
            </select>
        </div>
     <div class="col-3 col-md-2"><input type="submit" class="btn btn-success"   value="修改"/></div> 
   </div>
   </form> 
    @endforeach
  

     
  
     
</div>  
@endsection


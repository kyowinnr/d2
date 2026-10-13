@extends('layouts.app')
<script language="javascript">
    <!--
      var n1=0,n2=0,n3=0,n4=0,n5=0,n6=0,n7=0,m1=0;      
	 
	  
	 function check(){
    	    	
    	if(document.form3.startdate.value==""){
    		alert("請輸入出發日期");
    		document.form3.startdate.focus();
    		return false;
    	}
		
		if(document.form3.comedate.value==""){
    		alert("請輸入回程日期");
    		document.form3.comedate.focus();
    		return false;
    	}
		
		if(document.form3.CusNum.value==""){
    		alert("請輸入人數");
    		document.form3.CusNum.focus();
    		return false;
    	}
		
		if(document.form3.OrderCus.value=="" && document.form3.often.value==""){
    		alert("請輸入聯絡人");
    		document.form3.OrderCus.focus();
    		return false;
    	}
		
		if(document.form3.OrderTel.value=="" && document.form3.often.value==""){
    		alert("請輸入電話");
    		document.form3.OrderTel.focus();
    		return false;
    	}
		
		
		
    	
    }
	  
	 
	  
  //-->
  </script>	 
@section('content')
<form  name="form3" action="{{ route('ticketwork.step_one') }}" method="post">
@csrf
<div class="container">
  <div class="col-12 col-md-12" style="color:red;"><h3>票務訂單建檔STEP1</h3></div>
  
   <div class="row">
     <div class="col-6 col-md-1"><h5>Agant</h5></div>
     <div class="col-6 col-md-2"><input type="text" name="OrderBuss" class="form-control"></div>
     <div class="col-6 col-md-1"><h5>OR</h5></div>
     <div class="col-6 col-md-2">
       <select name="often" class="form-control">
           <option value=""></option>
           @foreach ($oftens as $often)
            <option value="{{$often->Often_ID}}">{{$often->Often_Group}}</option>
           @endforeach         
         </select>
     </div>
     <div class="col-12 col-md-4"><h5>(選取後者其餘免填)</h5></div>
  </div>
  <div class="row">   
     <div class="col-6 col-md-1"><h5>聯絡人</h5></div>
     <div class="col-6 col-md-2"><input type="text" name="OrderCus" class="form-control"></div>
     <div class="col-6 col-md-1"><h5>電話</h5></div>
     <div class="col-6 col-md-2"><input type="text" name="OrderTel" class="form-control"></div>
     <div class="col-6 col-md-1"><h5>傳真</h5></div>
     <div class="col-6 col-md-2"><input type="text" name="OrderFax" class="form-control"></div>
  </div>
  <hr style="background-color:red;height: 1px;">
  <div class="row">
    <div class="col-6 col-md-1"><h5>出發日</h5></div>
    <div class="col-6 col-md-3"><input type="date" name="startdate" class="form-control" min="1900-01-00" max="3000-11-11"></div>
    <div class="col-6 col-md-1"><h5>回程日</h5></div>
    <div class="col-6 col-md-3"><input type="date" name="comedate" class="form-control" min="1900-01-00" max="3000-11-11"></div>
    <div class="col-6 col-md-1"><h5>人數</h5></div>
    <div class="col-6 col-md-1"><input type="number" name="CusNum" min="1"  class="form-control"></div>
  </div>
  <div class="row">
     <div class="col-6 col-md-1"><h5>類型</h5></div>
     <div class="col-6 col-md-1"><input name="tickettype" type="radio" value="1"/>純票</div>
     <div class="col-6 col-md-1"><h5></h5></div>
     <div class="col-6 col-md-1"><input name="tickettype" type="radio" value="2" />車+票</div>
     <div class="col-6 col-md-1"><h5></h5></div>
     <div class="col-6 col-md-1"><input name="tickettype" type="radio" value="3"  checked="checked"  />純車</div>
  </div>
  <div class="row">
      <div class="col-6 col-md-2"><h5>接駁預選</h5></div>
      <div class="col-6 col-md-3">
          <select name="localselect" class="form-control">
           <option value="37">台北轉運站</option>
           <option value="88">三重重陽站</option>
           <option value="89">經國轉運站</option>
           <option value="40" selected >台中火車站</option>
           <option value="41" style="display:none;">台中朝馬站</option>
           <option value="90">中港轉運站</option>
           <option value="31">烏日高鐵站</option>
           <option value="43">彰化交流道</option>
           <option value="67">員林交流道</option> 
           <option value="171">嘉義火車站</option>
           <option value="167">嘉義高鐵站</option>
           <option value="170">新營火車站</option>
           <option value="151">新營客運站</option> 
        </select>
      </div>
      <div class="col-6 col-md-4"></div>
      <div class="col-6 col-md-3"><input type="submit" class="btn btn-success"   value="送出" onClick="return check();"/></div>
  </div>
</div>
</form> 
@endsection


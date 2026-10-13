<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Carinfo;
use App\Models\Location;

class CarinfoController extends Controller
{
    // 顯示所有資料及新增表單
    public function index()
    {
         // 搜尋 CarNO 分別等於 4、6、8、10車 的資料，並載入關聯的 Location
       $carinfos = Carinfo::with('location')
          ->whereIn('CarNO', [4, 6, 8, 10])
          ->get();
        

        return view('carinfo.index', compact('carinfos'));
    }
   
   
   // 更新資料
   public function update(Request $request, $id)
{
    // 查詢要更新的資料
    $carinfo = Carinfo::findOrFail($id);

    // 更新資料
    $carinfo->Narrate = $request->input('Narrate');  // 假設你只需要更新 'Narrate'
    $carinfo->save();

    // 重定向回顯示頁面
    return redirect()->route('carinfo.index');
}
    
}


    

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function index()
    {
        // 從資料表取得所有 schedule 資料
        $schedules = DB::table('schedule')->get();
        return view('schedulema.index', compact('schedules'));
    }
    

    public function update(Request $request, $S_Id)
    {
      // 驗證
      $request->validate([
        'S_Name' => 'required|string|max:255', // 確保 S_Name 是有效的字串
      ]);

      // 更新資料
      $updated = DB::table('schedule')
                 ->where('S_Id', $S_Id) // 使用路由參數 S_Id
                 ->update(['S_Name' => $request->S_Name]);
      // 返回結果
        return redirect()->route('schedulema.index');
    }
    
    
    public function store(Request $request)
    {
       // 驗證輸入
       $request->validate([
           'S_Name' => 'required|string|max:255',]);

       // 新增 Schedule
       DB::table('schedule')->insert(['S_Name' => $request->S_Name,]);

       // 重定向回列表頁面
        return redirect()->route('schedulema.index');
    }



}


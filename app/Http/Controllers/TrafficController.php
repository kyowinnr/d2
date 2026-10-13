<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrafficController extends Controller
{
    // 顯示交通資料
    public function index()
    {
        // 使用 DB 查詢所有 traffic 資料
        $traffics = DB::table('traffic')->get();
        return view('trafficma.index', compact('traffics'));
    }

    // 更新交通資料
    public function update(Request $request, $trafficId)
   {
       // 驗證資料
       $request->validate([
           'TrafficName' => 'required|string|max:255',  // 確保名稱是有效的
           'Display' => 'required|in:Y,N',  // 確保Display值是Y或N
       ]);

      // 根據選擇的 Display 值進行轉換
       $display = ($request->Display == 'Y') ? 0 : 1;  // Y -> 0, N -> 1

      //  更新資料
       $updated = DB::table('traffic')
           ->where('TrafficId', $trafficId)
           ->update([
            'TrafficName' => $request->TrafficName,
            'Display' => $display,  // 將 'Y' 或 'N' 轉換為 0 或 1
        ]);
   
        return redirect()->route('trafficma.index');
   }
   
   
   //新增
   public function store(Request $request)
    {
        // 驗證表單資料
        $request->validate([
            'TrafficName' => 'required|string|max:255',  // 確保交通名稱是有效的
        ]);

        // 新增資料
        DB::table('traffic')->insert([
            'TrafficName' => $request->TrafficName,
            'Display' => 0,  // Display 預設為 0
            'TrafficType' => 2,  // TrafficType 預設為 2
        ]);

        // 重定向到 traffic 列表頁面，並顯示成功訊息
        return redirect()->route('trafficma.index')->with('success', '交通資料已新增');
    }
   

}


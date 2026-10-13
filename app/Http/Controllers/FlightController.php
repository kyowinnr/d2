<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FlightController extends Controller
{
    // 顯示客戶名單
    public function index(Request $request)
    {
     // 預設 direction = 1
    $direction = $request->input('direction', 1);

    // 當前日期
    $today = now()->format('Y-m-d');

    // 查詢符合條件的 flight 資料
    $flights = DB::table('flight')
        ->where('Date', '>=', $today)
        ->where('Direction', $direction)
        ->get();

    return view('flight.index', compact('flights', 'direction'));
    }
    
    
    public function store(Request $request)
{
    // 取得輸入的日期範圍
    $date1 = $request->input('date1'); // 開始日期
    $date2 = $request->input('date2'); // 結束日期
    $direction = $request->input('direction'); // 方向
    $number = $request->input('Number'); // 數量
    $price = $request->input('Price'); // 價格

    // 驗證輸入資料是否完整
    $request->validate([
        'date1' => 'required|date',
        'date2' => 'required|date|after_or_equal:date1',
        'direction' => 'required|string',
    ]);

    // 處理空的 Number 和 Price
    $number = $number ?: 0; // 如果空值，設為 0
    $price = $price ?: 0;   // 如果空值，設為 0

    // 將日期範圍內的所有日期逐天新增到資料庫
    $currentDate = $date1;
    while (strtotime($currentDate) <= strtotime($date2)) {
        DB::table('flight')->insert([
            'Date' => $currentDate,
            'Direction' => $direction,
            'Number' => $number,
            'Price' => $price,
            'Lock' => 0,
        ]);
        // 日期遞增一天
        $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
    }

    // 返回視圖或重新導向
    return redirect()->route('flight.index');
}

    public function update(Request $request, $id)
    {
     
    // 驗證請求數據
    $validated = $request->validate([
        'number' => 'required|integer|min:0',
        'lock' => 'required|in:0,1', // 驗證 lock 的值是 0 或 1
    ]);
    
    // 根據 Lock 狀態決定 Number 值
    $number = ($validated['lock'] == 1) ? 0 : ($validated['number'] ?? 0);

    // 更新 flight 資料
    DB::table('flight')
        ->where('F_Id', $id)
         ->update([
            'Number' => $number,
            'Lock' => $validated['lock'], // 更新 Lock 狀態
        ]);

    // 重定向回上一頁或指定頁面
      return redirect()->route('flight.index');
    }
    
    public function renew(Request $request)
    {
      // 取得今天的日期
    $today = Carbon::createFromFormat('Y-m-d', Carbon::now()->year . '-03-25');
    
    // 設定今年的 9 月 30 日為結束日期
    $endDate = Carbon::createFromFormat('Y-m-d', Carbon::now()->year . '-09-30');
    
    // 計算從今天到 9 月 30 日之間的天數
    $days = $today->diffInDays($endDate);

    // 迴圈處理每一天
    for ($i = 0; $i <= $days; $i++) {
        // 計算每一天的日期
        $currentDate = $today->copy()->addDays($i)->format('Y-m-d');
        
        // 針對南下方向 (Direction = 1)
        $southboundSeats = DB::table('ordertraffic')
            ->whereDate('Date', $currentDate)
            ->whereIn('TrafficId', ['36', '39']) // 只計算南下的 TrafficId
            ->sum('CusNum');

        $southboundSeats = ($southboundSeats == 0) ? 42 : ceil($southboundSeats / 42) * 42 - $southboundSeats;

        // 更新南下的航班座位數
        DB::table('flight')
            ->whereDate('Date', $currentDate)
            ->where('Direction', 1)
            ->where('Lock', '!=', 1)  // 排除鎖定的航班
            ->update(['Number' => $southboundSeats]);

        // 針對北上方向 (Direction = 2)
        $northboundSeats = DB::table('ordertraffic')
            ->whereDate('Date', $currentDate)
            ->whereIn('TrafficId', ['37', '40']) // 只計算北上的 TrafficId
            ->sum('CusNum');

        $northboundSeats = ($northboundSeats == 0) ? 42 : ceil($northboundSeats / 42) * 42 - $northboundSeats;

        // 更新北上的航班座位數
        DB::table('flight')
            ->whereDate('Date', $currentDate)
            ->where('Direction', 2)
            ->where('Lock', '!=', 1)  // 排除鎖定的航班
            ->update(['Number' => $northboundSeats]);
    }

    
      return redirect()->route('flight.index');
    }



}  




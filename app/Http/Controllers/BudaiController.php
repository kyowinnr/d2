<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BudaiController extends Controller
{
    public function index(Request $request)
    {
        // 預設為今年
        $year = $request->year ?? date('Y');
        $month = $request->month ?? date('m');

        // TrafficId清單
        $trafficIds = [32, 34, 35, 33, 74];

        // 查詢ordertraffic資料
        $results = $this->getOrderTrafficData($year, $month, $trafficIds);
        $title32="鵲";
        $title34="凱";
        $title35="豹";
        $title33="滿";
        $title74="太";
        return view('budai.index', compact('results', 'year', 'month','title32','title34','title35','title33','title74'));
    }

   private function getOrderTrafficData($year, $month, $trafficIds)
{
    // 取得這個月份的第一天和最後一天
    $startDate = Carbon::createFromFormat('Y-m-d', "{$year}-{$month}-01")
    ->startOfDay() // 設定時間為 00:00:00
    ->toDateTimeString(); 

$endDate = Carbon::createFromFormat('Y-m-d', "{$year}-{$month}-01")
    ->endOfMonth()
    ->endOfDay() // 設定時間為 23:59:59
    ->toDateTimeString();

    // 分別查詢 LocationId 為 29 和 30 的資料
    $query29 = DB::table('ordertraffic')  //布馬
        ->select(DB::raw('DATE(Date) as date'), 'TrafficId', DB::raw('SUM(cusnum) as total'))
        ->where('LocationId', 29)
        ->whereIn('TrafficId', $trafficIds)
        ->whereBetween('Date', [$startDate, $endDate])
        ->groupBy(DB::raw('DATE(Date), TrafficId'))
        ->get();

    $query30 = DB::table('ordertraffic')  //馬布
        ->select(DB::raw('DATE(Date) as date'), 'TrafficId', DB::raw('SUM(cusnum) as total'))
        ->where('LocationId', 30)
        ->whereIn('TrafficId', $trafficIds)
        ->whereBetween('Date', [$startDate, $endDate])
        ->groupBy(DB::raw('DATE(Date), TrafficId'))
        ->get();
        
    $query140 = DB::table('ordertraffic')  //龍布
        ->select(DB::raw('DATE(Date) as date'), 'TrafficId', DB::raw('SUM(cusnum) as total'))
        ->where('LocationId', 140)
        ->whereIn('TrafficId', $trafficIds)
        ->whereBetween('Date', [$startDate, $endDate])
        ->groupBy(DB::raw('DATE(Date), TrafficId'))
        ->get();    

    // 格式化結果
    $data29 = [];$data30 = [];$data140 = [];
    
    
    // 分別處理 LocationId 為 29 和 30 的結果
    foreach ($query29 as $row) {
        $data29[$row->date][$row->TrafficId] = $row->total;
    }
    foreach ($query30 as $row) {
        $data30[$row->date][$row->TrafficId] = $row->total;
    }
    foreach ($query140 as $row) {
        $data140[$row->date][$row->TrafficId] = $row->total;
    }

    // 填充沒有資料的日期
    $daysInMonth = range(1, (int) date('t', strtotime($startDate)));
    $formattedData = [];
    foreach ($daysInMonth as $day) {
        $date = Carbon::createFromDate($year, $month, $day)->format('Y-m-d');
        
        // 初始化為每個 TrafficId 都有預設值 0
        $formattedData[$date] = [
            'Location29' => [],
            'Location30' => [],
            'Location140' => [],
        ];

        foreach ($trafficIds as $trafficId) {
            // 設定 LocationId 29 和 30 的預設值為 0
            $formattedData[$date]['Location29'][$trafficId] = $data29[$date][$trafficId] ?? 0;
            $formattedData[$date]['Location30'][$trafficId] = $data30[$date][$trafficId] ?? 0;
            $formattedData[$date]['Location140'][$trafficId] = $data140[$date][$trafficId] ?? 0;
        }
    }
    
    return $formattedData;
}

}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BusListController extends Controller
{
    public function index()
    {
        // 建立年份和月份選項
    $year = $request->year ?? date('Y');
    $months = range(1, 12);

    // 預設年份和月份為當前日期的年和月
    $defaultYear = now()->year;
    $defaultMonth = now()->month;

    // 執行初始查詢
    return $this->searchData($defaultYear, $defaultMonth, $year, $months);
    }
    
    
    public function store(Request $request)
    {
       // 接收用戶輸入的年份和月份
       $year = $request->input('year') ?? now()->year;
       $month = $request->input('month') ?? now()->month;

      // 年份和月份選項
       $years = array_reverse(range(2014, now()->year));
       $months = range(1, 12);

       return $this->searchData($year, $month, $years, $months);
    }




    public function searchData($year, $month, $years, $months)
    {
        // 計算月份的起始和結束日期
    $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
    $endDate = $startDate->copy()->endOfMonth();

        // TrafficId = 36 每天的客數總和  台中南下
        $dailyCusnum36 = DB::table('ordertraffic')
            ->select(DB::raw('DATE(Date) as date'), DB::raw('SUM(cusnum) as cusnum_total'))
            ->where('TrafficId', 36)
            ->whereBetween('Date', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(Date)'))
            ->pluck('cusnum_total', 'date')
            ->toArray();


        // 查詢 TrafficId = 37 的每日 cusnum 總和 台北南下
         $dailyCusnum37 = DB::table('ordertraffic')
            ->select(DB::raw('DATE(Date) as date'), DB::raw('SUM(cusnum) as cusnum_total'))
            ->where('TrafficId', 37)
            ->whereBetween('Date', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(Date)'))
            ->pluck('cusnum_total', 'date')
            ->toArray();

        // 查詢 TrafficId = 39 的每日 cusnum 總和 台中北上
         $dailyCusnum39 = DB::table('ordertraffic')
            ->select(DB::raw('DATE(Date) as date'), DB::raw('SUM(cusnum) as cusnum_total'))
            ->where('TrafficId', 39)
            ->whereBetween('Date', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(Date)'))
            ->pluck('cusnum_total', 'date')
            ->toArray();

        // 查詢 TrafficId = 40 的每日 cusnum 總和 台北北上
         $dailyCusnum40 = DB::table('ordertraffic')
            ->select(DB::raw('DATE(Date) as date'), DB::raw('SUM(cusnum) as cusnum_total'))
            ->where('TrafficId', 40)
            ->whereBetween('Date', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(Date)'))
            ->pluck('cusnum_total', 'date')
            ->toArray();
            
        // 查詢 TrafficId = 108 的每日 cusnum 總和  嘉義->布袋
         $dailyCusnum108 = DB::table('ordertraffic')
            ->select(DB::raw('DATE(Date) as date'), DB::raw('SUM(cusnum) as cusnum_total'))
            ->where('TrafficId', 108)
            ->whereBetween('Date', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(Date)'))
            ->pluck('cusnum_total', 'date')
            ->toArray();
            
         // 查詢 TrafficId = 113 的每日 cusnum 總和  新營->布袋
         $dailyCusnum113 = DB::table('ordertraffic')
            ->select(DB::raw('DATE(Date) as date'), DB::raw('SUM(cusnum) as cusnum_total'))
            ->where('TrafficId', 113)
            ->whereBetween('Date', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(Date)'))
            ->pluck('cusnum_total', 'date')
            ->toArray();     
            
         // 查詢 TrafficId = 109 的每日 cusnum 總和  布袋->嘉義
         $dailyCusnum109 = DB::table('ordertraffic')
            ->select(DB::raw('DATE(Date) as date'), DB::raw('SUM(cusnum) as cusnum_total'))
            ->where('TrafficId', 109)
            ->whereBetween('Date', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(Date)'))
            ->pluck('cusnum_total', 'date')
            ->toArray();
            
         // 查詢 TrafficId = 114 的每日 cusnum 總和  布袋->新營
         $dailyCusnum114 = DB::table('ordertraffic')
            ->select(DB::raw('DATE(Date) as date'), DB::raw('SUM(cusnum) as cusnum_total'))
            ->where('TrafficId', 114)
            ->whereBetween('Date', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(Date)'))
            ->pluck('cusnum_total', 'date')   
            ->toArray();
            
        // 查詢 TrafficId = 1 的每日 cusnum 總和  候補-南下
         $dailyCusnum1 = DB::table('ordertraffic')
            ->select(DB::raw('DATE(Date) as date'), DB::raw('SUM(cusnum) as cusnum_total'))
            ->where('TrafficId', 1)
            ->whereBetween('Date', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(Date)'))
            ->pluck('cusnum_total', 'date')   
            ->toArray(); 
            
        // 查詢 TrafficId = 7 的每日 cusnum 總和  候補-北上
         $dailyCusnum7 = DB::table('ordertraffic')
            ->select(DB::raw('DATE(Date) as date'), DB::raw('SUM(cusnum) as cusnum_total'))
            ->where('TrafficId', 7)
            ->whereBetween('Date', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(Date)'))
            ->pluck('cusnum_total', 'date')   
            ->toArray();  
         
            
        // 建立完整日期範圍，填充缺少的日期為 0
        $dateRange36 = []; $dateRange39 = [];
        $dateRange37 = []; $dateRange40 = [];
        $dateRange108 = []; $dateRange113 = [];
        $dateRange109 = []; $dateRange114 = [];
        $dateRange1 = []; $dateRange7 = [];
        
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $formattedDate = $date->toDateString();
            $dateRange36[$formattedDate] = $dailyCusnum36[$formattedDate] ?? 0;
            $dateRange39[$formattedDate] = $dailyCusnum39[$formattedDate] ?? 0;
            $dateRange37[$formattedDate] = $dailyCusnum37[$formattedDate] ?? 0;
            $dateRange40[$formattedDate] = $dailyCusnum40[$formattedDate] ?? 0;
            $dateRange108[$formattedDate] = $dailyCusnum108[$formattedDate] ?? 0;
            $dateRange113[$formattedDate] = $dailyCusnum113[$formattedDate] ?? 0;
            $dateRange109[$formattedDate] = $dailyCusnum109[$formattedDate] ?? 0;
            $dateRange114[$formattedDate] = $dailyCusnum114[$formattedDate] ?? 0;
            $dateRange1[$formattedDate] = $dailyCusnum1[$formattedDate] ?? 0;
            $dateRange7[$formattedDate] = $dailyCusnum7[$formattedDate] ?? 0;
        }    
            
        
        $years = range(2014, now()->year);
        $months = range(1, 12);


        // 將查詢結果傳遞到視圖
        return view('buslist.index', compact('years', 'months', 'dateRange36', 'dateRange39','dateRange37', 'dateRange40','dateRange108', 'dateRange113',
                                             'dateRange109', 'dateRange114','dateRange1','dateRange7', 'year', 'month'));
    }
}



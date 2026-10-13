<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class OrderSearchController extends Controller
{
    // 主畫面顯示
    public function index(Request $request)
    {
        // 處理表單提交
    if ($request->has('year') && $request->has('month') && $request->has('category')) {
        // 調用 searchByCategory 方法，根據提交的表單條件進行查詢
        $orders = $this->searchByCategory($request);
        
    }elseif ($request->has('dateType') && $request->has('date')) {
        
        $orders = $this->searchByDate($request);
    
    }elseif ($request->has('searchType') && $request->has('year')&& $request->has('keyword')) {
        
        $orders = $this->searchByOrder($request);
    
    }else {
        // 如果沒有表單提交，可以給予默認的結果或空陣列
        $orders = [];
    }

    // 取得其他可能需要的資料，像是年份和月份選項等
    $years = range(2019, now()->year + 1); // 從2019年到今年
    $months = range(1, 12); // 1月到12月

    // 返回到 index 視圖，並傳遞查詢結果及其他資料
    return view('ordersearch.index', compact('orders', 'years', 'months'));
    }

    // 區塊 1: 根據日期類型和日期查詢
    private function searchByDate(Request $request)
{
    $request->validate([
        'dateType' => 'required',
        'date' => 'required|date',
    ]);

    $dateType = $request->input('dateType');
    $date = $request->input('date');

    // 查詢 orders 表並加入 customer 表的聯接
    return DB::table('order')
        ->join('customer', 'order.OrderId', '=', 'customer.OrderId')  // 連接 orders 和 customer 表
        ->where($dateType, $date)  // 篩選出符合 dateType 和 date 的條件
        ->where('customer.TM', 1)  // 加入 customer.TM = 1 的篩選條件
        ->select('order.*', 'customer.Name','customer.Phone')  // 選取 order 表的所有欄位和 customer.Name
        ->get();
}

   

    // 區塊 2: 根據年份、查詢條件及關鍵字查詢
    private function searchByOrder(Request $request)
{
    // 驗證接收到的表單資料
    $request->validate([
        'year' => 'required|integer',
        'searchType' => 'required|string',
        'keyword' => 'required|string',  // 關鍵字可以為空
    ]);

    // 從表單獲取資料
    $year = $request->input('year');
    $searchType = $request->input('searchType');
    $keyword = $request->input('keyword');   
    // 基本的查詢，從 order 表開始
    $query = DB::table('order')
        ->join('customer', 'order.OrderId', '=', 'customer.OrderId')
        ->orderBy('order.OrderStart', 'DESC');  // 根據 OrderStart 進行升冪排序 ; // 連接 order 和 customer 表
        
    // 如果 searchType 不是 'Name'，才加入 customer.TM = 1 條件
    if ($searchType != 'Name') {  $query->where('customer.TM', 1);}

    // 如果 searchType 不是 OrderId，則需要加入年份匹配
    if ($searchType != 'OrderId') {
        $query->whereYear('order.OrderStart', $year);
    }

    // 根據 searchType 和 keyword 進行不同的查詢
    if ($searchType == 'OrderId' || $searchType == 'OrderBuss') {
        // 查詢 order.OrderId 或 order.OrderBuss
        $query->where("order.$searchType", 'like', "%{$keyword}%");
    } elseif ($searchType == 'bank') {
        // 查詢 okrece.Ps
        $query->join('okrece', 'order.OrderId', '=', 'okrece.OrderId')
            ->where('okrece.Ps', 'like', "%{$keyword}%");
    } elseif ($searchType == 'Name') {
        // 查詢 customer.Name
        $query->where('customer.Name', 'like', "%{$keyword}%");
    }

    // 返回查詢結果
    return $query->get();
}




    // 區塊 3: 根據年份、月份和類別查詢
    private function searchByCategory(Request $request)
{
    // 驗證輸入
    $request->validate([
        'year' => 'required|integer',
        'month' => 'required|integer|min:1|max:12',
        'category' => 'required|string',
    ]);

    $year = $request->input('year');
    $month = $request->input('month');
    $category = $request->input('category');

    // 開始查詢
    $query = DB::table('order')
        ->join('customer', 'order.OrderId', '=', 'customer.OrderId') // 連接 'orders' 和 'customer'
        ->whereYear('order.OrderStart', $year) // 檢查 OrderStart 年份
        ->whereMonth('order.OrderStart', $month) // 檢查 OrderStart 月份
        ->where('customer.Tm', 1) // customer.Tm = 1 的條件
        ->select('order.OrderId', 'order.GroupName', 'order.OrderBuss', 'order.OrderCus', 'order.OrderStart', 
                 'customer.Phone', 'order.OrderType', 'customer.Name', 'order.FinalPay') // 選取需要的欄位
        ->orderBy('order.OrderStart', 'DESC');  // 根據 OrderStart 進行升冪排序                 

    // 根據 category 增加條件
    if ($category != '3') {
        $query->where('order.OrderType', $category); // 如果 category 不等於 3，加上 OrderType = category 的條件
    }

    // 執行查詢並返回結果
    return $query->get();
}


    public function destroy($orderId)
{
    // 1. 查找與該 OrderId 關聯的所有 CusId
    $cusIds = DB::table('customer')
                ->where('OrderId', $orderId)
                ->pluck('CusId');

    // 2. 找出所有包含 CusId 欄位的資料表，並刪除符合條件的資料
    $cusIdTables = DB::table('INFORMATION_SCHEMA.COLUMNS')
                      ->where('COLUMN_NAME', 'CusId')
                      ->where('TABLE_SCHEMA', env('DB_DATABASE'))
                      ->pluck('TABLE_NAME');

    foreach ($cusIdTables as $table) {
        DB::table($table)->whereIn('CusId', $cusIds)->delete();
    }

    // 3. 找出所有包含 OrderId 欄位的資料表，並刪除符合條件的資料
    $orderIdTables = DB::table('INFORMATION_SCHEMA.COLUMNS')
                       ->where('COLUMN_NAME', 'OrderId')
                       ->where('TABLE_SCHEMA', env('DB_DATABASE'))
                       ->pluck('TABLE_NAME');

    foreach ($orderIdTables as $table) {
        DB::table($table)->where('OrderId', $orderId)->delete();
    }

    return redirect()->route('ordersearch.index');
}


}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TbillController extends Controller
{
    /**
     * 顯示指定 OrderId 的應收和扣款資料
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // 從 URL 取得 OrderId 參數
        $orderId = $request->query('orderId');

        // 查詢所有 aitem 資料作為下拉選單的選項
        $items = DB::table('aitem')->pluck('ItemName', 'ItemId');

        // 查詢 receivable 中的相關資料並連接 aitem 表來獲取 ItemName
        $receivables = DB::table('receivable')
            ->join('aitem', 'receivable.RItemId', '=', 'aitem.ItemId')
            ->where('receivable.OrderId', $orderId)
            ->select('receivable.*', 'aitem.ItemName')
            ->get();
 
        // 查詢 receivableoff 中的相關資料並連接 aitem 表來獲取 ItemName
        $receivableoffs = DB::table('receivableoff')
            ->join('aitem', 'receivableoff.RItemId', '=', 'aitem.ItemId')
            ->where('receivableoff.OrderId', $orderId)
            ->select('receivableoff.*', 'aitem.ItemName')
            ->get();
            
            
        // 查詢 okrece 中的相關資料並連接 aitem 表來獲取 ItemName
        $okreces = DB::table('okrece')
            ->where('OrderId', $orderId)
            ->select('OId', 'OrderId','Date','Price','Ps')
            ->get();    
            
            
        // 查詢 payable 中的相關資料並連接 aitem 表來獲取 ItemName
        $payables = DB::table('payable')
            ->join('aitem', 'payable.RItemId', '=', 'aitem.ItemId')
            ->where('payable.OrderId', $orderId)
            ->select('payable.*', 'aitem.ItemName')
            ->get();    

       // 查詢 okpay 中的相關資料並連接 aitem 表來獲取 ItemName
        $okpays = DB::table('okpay')
            ->where('OrderId', $orderId)
            ->select('OId', 'OrderId','Date','Price','Ps')
            ->get(); 
            
        //訂金&尾款
        $moneys = DB::table('order')
                ->join('customer', 'order.OrderId', '=', 'customer.OrderId')
                ->select('GroupName','OrderStart','DepositDate', 'Deposit', 'DepositPay', 'FinalDate', 'FinalPay','customer.Name','OrderType','OrderBuss')
                ->where('order.OrderId', $orderId)
                ->where('customer.Tm', 1)
               ->first();   
          

        // 將查詢結果傳遞到視圖
        return view('tbill.index', compact('receivables', 'receivableoffs', 'items', 'orderId','okreces','payables','okpays','moneys'));
    }
    
    
   public function update(Request $request, $tbill)
{
    // 使用接收到的 $tbill 和 $request 中的其他數據來更新資料
    // 更新完畢後重定向回包含 `orderid` 的頁面
    $orderId = $request->orderid;
    $tableName=$request->tableName;
    $tableId=$request->tableId;
    
    // 更新資料邏輯
    DB::table($tableName)
        ->where($tableId, $tbill)
        ->update([
            'RItemId' => $request->input('RItemId'),
            'Price' => $request->input('Price'),
            'Number' => $request->input('Number'),
        ]);

    return redirect()->route('tbill.index', ['orderId' => $orderId]);
}

  public function store(Request $request)
{
    $orderid = $request->orderid;  // 從表單資料中獲取 orderid
    $itemId = $request->RItemId;
    $price = $request->Price;
    $number = $request->Number;
    $tableName=$request->tableName;
    DB::table($tableName)->insert([
        'OrderId' => $orderid,
        'RItemId' => $itemId,
        'Price' => $price,
        'Number' => $number,
    ]);

    return redirect()->route('tbill.index', ['orderId' => $orderid]);
}

 
 public function destroy(Request $request, $tbill)
{
    // 刪除 receivable 記錄
    $orderid = $request->orderid;  // 從表單資料中獲取 orderid
    $tableName=$request->tableName;
    $receivableId=$tbill;
    //dd($receivableId);
    $tableId=$request->tableId;
    DB::table($tableName)->where($tableId, $receivableId)->delete();

    return redirect()->route('tbill.index', ['orderId' => $orderid]);
}


public function editmoney(Request $request, $id)
{
    DB::table('order')
        ->where('OrderId', $id)
        ->update([
               'DepositDate' => $request->input('DepositDate'),
               'Deposit' => $request->input('Deposit', null),
               'DepositPay' => $request->input('DepositPay'),
               'FinalDate' => $request->input('FinalDate'),
               'FinalPay' => $request->input('FinalPay')
               
               ]);



    return redirect()->route('tbill.index', ['orderId' => $id]);
}

  public function show($orderId)
  {
    
        
        // 查詢所有 aitem 資料作為下拉選單的選項
        $items = DB::table('aitem')->pluck('ItemName', 'ItemId');

        // 查詢 receivable 中的相關資料並連接 aitem 表來獲取 ItemName
        $receivables = DB::table('receivable')
            ->join('aitem', 'receivable.RItemId', '=', 'aitem.ItemId')
            ->where('receivable.OrderId', $orderId)
            ->select('receivable.*', 'aitem.ItemName',DB::raw('Price * Number as subtotal'))
            ->get();
         $total_rece = $receivables->sum(function ($item) {
             return (float) $item->subtotal;  // 將 subtotal 轉換為浮點數進行加總
         });   
         
         
        // 查詢 receivableoff 中的相關資料並連接 aitem 表來獲取 ItemName
        $receivableoffs = DB::table('receivableoff')
            ->join('aitem', 'receivableoff.RItemId', '=', 'aitem.ItemId')
            ->where('receivableoff.OrderId', $orderId)
            ->select('receivableoff.*', 'aitem.ItemName',DB::raw('Price * Number as subtotal'))
            ->get();
         $total_receoff = $receivableoffs->sum(function ($item) {
             return (float) $item->subtotal;  // 將 subtotal 轉換為浮點數進行加總
         });   
         
         
              
         
           
            
        // 查詢 okrece 中的相關資料並連接 aitem 表來獲取 ItemName
        $okreces = DB::table('okrece')
            ->where('OrderId', $orderId)
            ->select('OId', 'OrderId','Date','Price','Ps')
            ->get();  
            
            
            
        //格式化及加總
         $total = [
           'end' => number_format($total_rece-$total_receoff-$okreces->sum('Price'),0),
           'all' => number_format($total_rece-$total_receoff,0),
           'rece' => number_format($total_rece, 0),  // 格式化為兩位小數
           'receoff' => number_format($total_receoff, 0),  // 格式化為兩位小數
           'okrece' => number_format($okreces->sum('Price'), 0),
         ];
        
          // 格式化 Price 欄位為兩位小數
         $okreces->transform(function ($item) {
              $item->Price = number_format($item->Price, 0);  // 格式化 Price 為兩位小數
              return $item;
         });    
            
            
        //訂金&尾款
        $moneys = DB::table('order')
                ->select('OrderId','OrderBuss','OrderStart','OrderCome','OrderCus','OrderTel','CusNum','DepositDate','Deposit','FinalDate')
                ->where('order.OrderId', $orderId)
                ->first(); 
        //旅客資料
        $customer = DB::table('customer')
                       ->select('Name','Phone')
                       ->where('OrderId', $orderId)
                       ->where('TM', 1)
                       ->first();  
  
       //交通資訊
      $ordertraffics = DB::table('ordertraffic')
                         ->join('location as loc1', 'ordertraffic.LocationId', '=', 'loc1.LocationId') // 第一個地點
                         ->join('location as loc2', 'ordertraffic.LocationId2', '=', 'loc2.LocationId') // 第二個地點
                         ->join('traffic', 'ordertraffic.TrafficId', '=', 'traffic.TrafficId') 
                         ->where('OrderId', $orderId) // 根據 OrderId 篩選
                         ->orderBy('Date', 'ASC') // 按日期升序排序
                         ->select(
                                 'ordertraffic.*', 
                                 'loc1.LocationName as StartLocation', // 第一地點名稱
                                 'loc2.LocationName as EndLocation',   // 第二地點名稱
                                 'TrafficName'
                        )
    ->get(); // 取得所有符合條件的資料
                          
      
         
         
     return view('tbill.show', compact('receivables', 'receivableoffs', 'items', 'orderId','okreces','moneys','total','customer','ordertraffics'));
  }


   
   
    
}


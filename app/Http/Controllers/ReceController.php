<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReceController extends Controller
{
      
    
   public function update(Request $request, $rece)
{
    // 使用接收到的 $tbill 和 $request 中的其他數據來更新資料
    // 更新完畢後重定向回包含 `orderid` 的頁面
    $orderId = $request->orderid;
    $tableName=$request->tableName;
    $tableId=$request->tableId;
    
    // 更新資料邏輯
    DB::table($tableName)
        ->where($tableId, $rece)
        ->update([
            'Date' => $request->input('Date'),
            'Price' => $request->input('Price'),
            'Ps' => $request->input('Ps'),
        ]);

    return redirect()->route('tbill.index', ['orderId' => $orderId]);
}

  public function store(Request $request)
{
    $orderid = $request->orderid;  // 從表單資料中獲取 orderid
    $date = $request->Date;
    $price = $request->Price;
    $ps = $request->Ps;
    $tableName=$request->tableName;
    DB::table($tableName)->insert([
        'OrderId' => $orderid,
        'Date' => $date,
        'Price' => $price,
        'Ps' => $ps,
    ]);

    return redirect()->route('tbill.index', ['orderId' => $orderid]);
}

 



   
   
    
}


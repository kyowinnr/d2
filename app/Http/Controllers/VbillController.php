<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VbillController extends Controller
{
    public function index(Request $request)
    {
        // 從 URL 取得 OrderId 參數
        $orderId = $request->query('orderId');
        $type = $request->query('type'); // 接收 type 參數
        
        //訂單資料
        $order = DB::table('order')
                ->select('GroupName','OrderStart','OrderCome')
                ->where('order.OrderId', $orderId)
                ->first(); 

       
        // 先計算每個客戶的簽證
    $customers = DB::table('customer')
        ->Join('visatype2', 'customer.CusId', '=', 'visatype2.CusId')
        ->leftJoin('visatype1', 'visatype2.V1_Id', '=', 'visatype1.V1_Id')
        ->where('customer.OrderId', $orderId)
        ->select(
            'customer.CusId',
            'customer.Name',
            DB::raw("GROUP_CONCAT(visatype1.V1_Name SEPARATOR '+') as visa")
        )
        ->groupBy('customer.CusId', 'customer.Name')
        ->get();

    // 計算每個客戶的金額總和
    foreach ($customers as $customer) {
        // 建議優化：可以在一個 query 中完成三個欄位的加總
        $amounts = DB::table('list')
            ->where('CusId', $customer->CusId)
            ->selectRaw('SUM(Income2) as t_income2, SUM(Income) as t_income, SUM(Exp) as t_exp')
            ->first();

        $customer->total_income2 = $amounts->t_income2 ?? 0;
        $customer->total_income = $amounts->t_income ?? 0;
        $customer->total_exp = $amounts->t_exp ?? 0;
    }

         $totals = [
    'total_income2' => $customers->sum('total_income2'),
    'total_income' => $customers->sum('total_income'),
    'total_exp' => $customers->sum('total_exp'),
];

            
       
          return view('vbill.index', compact('order','type','customers','totals'));
       
    }
    
     


   
   
    
}


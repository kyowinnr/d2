<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FinalPayController extends Controller
{
    public function index(Request $request)
    {
        // 接收 check 參數，並設置預設值
        $check = $request->input('check', 2);  // 預設值為 2，若沒傳遞 check 參數

        // 獲取當前年份的起始與結束日期
        $startOfYear = Carbon::now()->startOfYear()->toDateString(); // 今年的1月1日
        $endOfYear = Carbon::now()->endOfYear()->toDateString(); // 今年的12月31日

        // 使用 Query Builder 查詢資料，根據 OrderType、check 參數以及 OrderStart 在今年度的條件過濾
       $orders = DB::table('order')
    ->join('customer', 'order.OrderId', '=', 'customer.OrderId')
    ->where('order.OrderType', $check)  // 只查詢 OrderType 為 'check' 的訂單
    ->where('order.FinalPay', '!=', 'Y')  // 確保 FinalPay 不等於 'N'
    ->whereBetween('order.OrderStart', [$startOfYear, $endOfYear])  // 確保 OrderStart 在今年度
    ->where('customer.TM', '=', 1)  // 確保 customer.TM = 1
    ->orderBy('order.OrderStart', 'ASC')  // 根據 OrderStart 進行升冪排序
    ->select('order.OrderId', 'order.OrderStart', 'order.OrderBuss', 'customer.Name')
    ->get();  // 執行查詢並取得結果


        // 傳遞資料到 Blade 模板
        return view('finalpay.index', compact('orders'));
    }

    // 顯示單筆訂單詳情
    public function show($id)
    {
        $order = DB::table('order')
            ->join('customer', 'order.OrderId', '=', 'customer.OrderId')
            ->where('order.OrderId', $id)
            ->first();

        return view('finalpay.show', compact('order'));
    }

    // 編輯訂單資料
    public function edit($id)
    {
        $order = DB::table('order')
            ->join('customer', 'order.OrderId', '=', 'customer.OrderId')
            ->where('order.OrderId', $id)
            ->first();

        return view('finalpay.edit', compact('order'));
    }
}


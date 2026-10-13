<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillController extends Controller
{
    // index 方法：顯示搜尋表單
    public function index()
    {
        return view('mbill.index');
    }

    // store 方法：處理搜尋請求
    public function store(Request $request)
    {
        // 接收查詢條件
        $orderBuss = $request->input('orderBuss');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        
        $orderBussLike = "%{$orderBuss}%"; // 設定 LIKE 查詢條件

        // 查詢訂單資料
        $results = DB::table('order')
            ->join('customer', 'order.OrderId', '=', 'customer.OrderId')
            ->leftJoin(
                DB::raw('(SELECT OrderId, SUM(Price * Number) AS total_receivable FROM receivable GROUP BY OrderId) AS receivable_totals'),
                'order.OrderId', '=', 'receivable_totals.OrderId'
            )
            ->leftJoin(
                DB::raw('(SELECT OrderId, SUM(Price * Number) AS total_deduction FROM receivableoff GROUP BY OrderId) AS receivableoff_totals'),
                'order.OrderId', '=', 'receivableoff_totals.OrderId'
            )
            ->select(
                'order.OrderId',
                'order.OrderBuss',
                'order.OrderStart',
                'order.CusNum',
                'customer.Name',
                DB::raw('IFNULL(receivable_totals.total_receivable, 0) as total_receivable'),
                DB::raw('IFNULL(receivableoff_totals.total_deduction, 0) as total_deduction')
            )
            ->where('order.OrderBuss', 'like', $orderBussLike)
            ->whereBetween('order.OrderStart', [$startDate, $endDate])
            ->where('customer.TM', '=', 1)
            ->orderBy('order.OrderStart', 'asc')
            ->get();

        // 計算全部合計及差額
        $totalReceivable = $results->sum('total_receivable');
        $totalDeduction = $results->sum('total_deduction');
        $netAmount = $totalReceivable - $totalDeduction;

        // 返回搜尋結果和合計數據
        return view('mbill.index', [
            'orders' => $results,
            'total_receivable' => $totalReceivable,
            'total_deduction' => $totalDeduction,
            'net_amount' => $netAmount,
            'orderBuss' => $orderBuss,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
}


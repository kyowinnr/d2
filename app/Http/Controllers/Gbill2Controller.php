<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Gbill2Controller extends Controller
{
    /**
     * 顯示指定 OrderId 的應收和扣款資料
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $orderId = $request->query('orderId');

        // 基本資料
        $order = DB::table('order')
            ->join('customer', 'order.OrderId', '=', 'customer.OrderId')
            ->select('GroupName', 'OrderStart', 'OrderCome', 'customer.Name', 'OrderType', 'OrderBuss')
            ->where('order.OrderId', $orderId)
            ->where('customer.Tm', 1)
            ->first();

        // 查詢所有 aitem 資料作為下拉選單的選項
        $items = DB::table('aitem')->pluck('ItemName', 'ItemId');

        // 應收
        $receivables = DB::table('receivable')
            ->join('aitem', 'receivable.RItemId', '=', 'aitem.ItemId')
            ->where('receivable.OrderId', $orderId)
            ->select('receivable.*', 'aitem.ItemName', DB::raw('Price * Number as subtotal'))
            ->get();

        $total_rece = $receivables->sum(function ($item) {
            return (float) $item->subtotal;
        });

        // 應收扣款
        $receivableoffs = DB::table('receivableoff')
            ->join('aitem', 'receivableoff.RItemId', '=', 'aitem.ItemId')
            ->where('receivableoff.OrderId', $orderId)
            ->select('receivableoff.*', 'aitem.ItemName', DB::raw('Price * Number as subtotal'))
            ->get();

        $total_receoff = $receivableoffs->sum(function ($item) {
            return (float) $item->subtotal;
        });

        // 已收
        $okreces = DB::table('okrece')
            ->where('OrderId', $orderId)
            ->select('OId', 'OrderId', 'Date', 'Price', 'Ps')
            ->get();

        // 應付
        $payables = DB::table('payable')
            ->join('aitem', 'payable.RItemId', '=', 'aitem.ItemId')
            ->where('payable.OrderId', $orderId)
            ->select('payable.*', 'aitem.ItemName', DB::raw('Price * Number as subtotal'))
            ->get();

        $total_payable = $payables->sum(function ($item) {
            return (float) $item->subtotal;
        });

        // 已付
        $okpays = DB::table('okpay')
            ->where('OrderId', $orderId)
            ->select('OId', 'OrderId', 'Date', 'Price', 'Ps')
            ->get();

        // 證件費用
        $total_income2 = DB::table('list')
            ->whereIn('CusId', function ($query) use ($orderId) {
                $query->select('CusId')
                    ->from('customer')
                    ->where('OrderId', $orderId);
            })
            ->sum('Income2');

        // 加總
        $total = [
            'end' => number_format($total_rece + $total_income2 - $total_receoff - $okreces->sum('Price'), 0),
            'all' => number_format($total_rece + $total_income2 - $total_receoff, 0),
            'all_over' => number_format($okreces->sum('Price') - $okpays->sum('Price'), 0),
            'rece' => number_format($total_rece + $total_income2, 0),
            'receoff' => number_format($total_receoff, 0),
            'okrece' => number_format($okreces->sum('Price'), 0),
            'okpay' => number_format($okpays->sum('Price'), 0),
        ];

        return view('gbill2.index', compact(
            'order',
            'receivables',
            'receivableoffs',
            'items',
            'okreces',
            'payables',
            'okpays',
            'total_income2',
            'total'
        ));
    }
}
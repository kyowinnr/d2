<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GbillController extends Controller
{
    public function index(Request $request)
    {
        $orderId = $request->query('orderId');
        $type = $request->query('type');

        $items = DB::table('aitem')->pluck('ItemName', 'ItemId');

        $receivables = DB::table('receivable')
            ->join('aitem', 'receivable.RItemId', '=', 'aitem.ItemId')
            ->where('receivable.OrderId', $orderId)
            ->select('receivable.*', 'aitem.ItemName', DB::raw('Price * Number as subtotal'))
            ->get();

        $total_rece = $receivables->sum(function ($item) {
            return (float) $item->subtotal;
        });

        $receivableoffs = DB::table('receivableoff')
            ->join('aitem', 'receivableoff.RItemId', '=', 'aitem.ItemId')
            ->where('receivableoff.OrderId', $orderId)
            ->select('receivableoff.*', 'aitem.ItemName', DB::raw('Price * Number as subtotal'))
            ->get();

        $total_receoff = $receivableoffs->sum(function ($item) {
            return (float) $item->subtotal;
        });

        $total_income2 = DB::table('list')
            ->whereIn('CusId', function ($query) use ($orderId) {
                $query->select('CusId')
                    ->from('customer')
                    ->where('OrderId', $orderId);
            })
            ->sum('Income2');

        $okreces = DB::table('okrece')
            ->where('OrderId', $orderId)
            ->select('OId', 'OrderId', 'Date', 'Price', 'Ps')
            ->get();

        $total = [
            'end'     => $total_rece + $total_income2 - $total_receoff - $okreces->sum('Price'),
            'all'     => $total_rece + $total_income2 - $total_receoff,
            'rece'    => $total_rece + $total_income2,
            'receoff' => $total_receoff,
            'okrece'  => $okreces->sum('Price'),
        ];

        $moneys = DB::table('order')
            ->select('GroupName', 'OrderStart', 'OrderCome', 'OrderCus', 'OrderTel', 'CusNum')
            ->where('order.OrderId', $orderId)
            ->first();

        if ($type == 1) {
            return view('gbill.index', compact('receivables', 'receivableoffs', 'items', 'orderId', 'okreces', 'moneys', 'total', 'total_income2'));
        } else {
            return view('gbill.index2', compact('receivables', 'receivableoffs', 'items', 'orderId', 'okreces', 'moneys', 'total', 'total_income2'));
        }
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();
        $tomorrow = Carbon::tomorrow()->toDateString();

        $todayDepartures = Order::query()
            ->departureDate($today)
            ->with(['tmCustomer:CusId,OrderId,Name'])
            ->orderBy('OrderStart')
            ->orderBy('OrderId')
            ->get(['OrderId', 'OrderStart', 'OrderBuss', 'CusNum']);

        $tomorrowDepartures = Order::query()
            ->departureDate($tomorrow)
            ->with(['tmCustomer:CusId,OrderId,Name'])
            ->orderBy('OrderStart')
            ->orderBy('OrderId')
            ->get(['OrderId', 'OrderStart', 'OrderBuss', 'CusNum']);

        $tempOrderCount = DB::table('temporder')
            ->where('Close', 0)
            ->count();

        $guestbooks = DB::table('guestbook')
            ->where('type', 0)
            ->orderByDesc('S_Time')
            ->limit(10)
            ->get();

        // 取消訂單：temporder 還沒有正式訂單編號，所以用 CusName1 + Startdate 去對正式訂單
        $cancelOrders = Order::query()
            ->select('order.OrderId', 'order.OrderStart', 'order.OrderBuss', 'order.CusNum')
            ->join('customer', 'customer.OrderId', '=', 'order.OrderId')
            ->join('temporder', function ($join) {
                $join->on('temporder.CusName1', '=', 'customer.Name')
                     ->on('temporder.Startdate', '=', 'order.OrderStart');
            })
            ->where('temporder.Ps', 'like', '%取消%')
            ->with(['tmCustomer:CusId,OrderId,Name'])
            ->orderByDesc('order.OrderStart')
            ->orderByDesc('order.OrderId')
            ->distinct()
            ->get();

        return view('dashboard', [
            'todayDepartures' => $todayDepartures,
            'tomorrowDepartures' => $tomorrowDepartures,
            'tempOrderCount' => $tempOrderCount,
            'guestbooks' => $guestbooks,
            'cancelOrders' => $cancelOrders,
            'today' => $today,
            'tomorrow' => $tomorrow,
        ]);
    }
}
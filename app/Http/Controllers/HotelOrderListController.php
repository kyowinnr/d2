<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HotelOrderListController extends Controller
{
    // 顯示資料清單
    public function index()
{
    // 查詢 hotelorder 和 hotel 表的聯合資料
    $hotelOrders = DB::table('hotelorder')
        ->join('hotel', 'hotelorder.HotelId', '=', 'hotel.HotelId')
        ->select('hotelorder.HotelOrderId', 'hotel.HotelName', 'hotelorder.OrderDate', 'hotelorder.HotelId')
        ->orderBy('hotelorder.OrderDate', 'DESC')
        ->get();

    // 查詢所有飯店，用於新增表單
    $hotels = DB::table('hotel')->get();

    return view('hotelorderlist.index', compact('hotelOrders', 'hotels'));
}

    public function show($HotelOrderId)
{
    $order = DB::table('hotelorder')
        ->join('hotel', 'hotelorder.HotelId', '=', 'hotel.HotelId')
        ->join('users', 'hotelorder.Sign', '=', 'users.id')
        ->where('hotelorder.HotelOrderId', $HotelOrderId)
        ->select(
            'hotelorder.HotelId',
            'hotelorder.OrderDate',
            'hotelorder.Main',
            'hotelorder.Sign',
            'hotel.HotelName',
            'hotel.HotelTel',
            'hotel.HotelFax',
            'users.username',
            'hotelorder.Night'
        )
        ->first();

    return view('hotelorderlist.show', compact('order'));
}

}
    

<?php

namespace App\Http\Controllers; // 添加命名空間

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller; // 確保導入 Controller 類

class SearchHotelController extends Controller
{
    public function SearchHotel($ContinentID)
{
    // 查詢特定大洲的酒店
    $hotels = DB::table('hotel')
        ->where('HotelLocalId', $ContinentID)
        ->select('HotelId', 'HotelName')
        ->get();

    // 顯示不同洲的國家
    $type1 = DB::table('continent')->select('ContinentID', 'Country')->where('ContinentName', '亞洲')->get();
    $type2 = DB::table('continent')->select('ContinentID', 'Country')->where('ContinentName', '歐洲')->get();
    $type3 = DB::table('continent')->select('ContinentID', 'Country')->where('ContinentName', '美洲')->get();
    $type4 = DB::table('continent')->select('ContinentID', 'Country')->where('ContinentName', '大洋洲')->get();
    $type5 = DB::table('continent')->select('ContinentID', 'Country')->where('ContinentName', '未分類')->get();

    return view('searchhotel.index', compact('type1', 'type2', 'type3', 'type4', 'type5', 'hotels'));
}
    
    
    public function SearchHotelWithoutContinent()
{
    // 處理無參數時的邏輯，例如返回所有酒店
    $hotels = DB::table('hotel')
        ->select('HotelId', 'HotelName')
        ->get();

    // 顯示不同洲的國家
    $type1 = DB::table('continent')->select('ContinentID', 'Country')->where('ContinentName', '亞洲')->get();
    $type2 = DB::table('continent')->select('ContinentID', 'Country')->where('ContinentName', '歐洲')->get();
    $type3 = DB::table('continent')->select('ContinentID', 'Country')->where('ContinentName', '美洲')->get();
    $type4 = DB::table('continent')->select('ContinentID', 'Country')->where('ContinentName', '大洋洲')->get();
    $type5 = DB::table('continent')->select('ContinentID', 'Country')->where('ContinentName', '未分類')->get();

    return view('searchhotel.index', compact('type1', 'type2', 'type3', 'type4', 'type5', 'hotels'));
}
    
}


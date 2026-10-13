<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  // 使用DB來執行原生SQL查詢

class HotelController extends Controller
{
    // 顯示飯店列表
    public function index(Request $request)
    {
        $search = $request->input('search');  // 取得搜尋關鍵字

        // 查詢洲資料，這裡不使用模型，而是使用原生SQL
        $continents = DB::table('continent')->get();  // 獲取所有洲資料

        // 查詢飯店資料，根據搜尋條件來篩選
        if ($search) {
            $hotels = DB::table('hotel')
                ->join('continent', 'hotel.HotelLocalId', '=', 'continent.ContinentID')
                ->select('hotel.HotelId', 'hotel.HotelName', 'hotel.HotelTel', 'hotel.HotelFax', 'hotel.HotelAdd', 'continent.Country', 'hotel.HotelLocalId')
                ->where('hotel.HotelName', 'LIKE', "%{$search}%")  // 根據飯店名稱搜尋
                ->get();
        } else {
            // 如果沒有搜尋關鍵字，則列出所有飯店
            $hotels = DB::table('hotel')
                ->join('continent', 'hotel.HotelLocalId', '=', 'continent.ContinentID')
                ->select('hotel.HotelId', 'hotel.HotelName', 'hotel.HotelTel', 'hotel.HotelFax', 'hotel.HotelAdd', 'continent.Country', 'hotel.HotelLocalId')
                ->get();
        }

        // 傳遞資料給視圖
        return view('hotellist.index', compact('hotels', 'continents', 'search'));
    }

    // 更新飯店資料
    public function update(Request $request, $id)
    {
        // 接收表單資料
        $hotelName = $request->input('HotelName');
        $hotelLocalId = $request->input('HotelLocalId');
        $hotelTel = $request->input('HotelTel', '');  // 默認為空字串
        $hotelFax = $request->input('HotelFax', '');  // 默認為空字串
        $hotelAdd = $request->input('HotelAdd', '');  // 默認為空字串

        // 更新飯店資料
        DB::table('hotel')
            ->where('HotelId', $id)
            ->update([
                'HotelName' => $hotelName,
                'HotelLocalId' => $hotelLocalId,
                'HotelTel' => $hotelTel,
                'HotelFax' => $hotelFax,
                'HotelAdd' => $hotelAdd,
            ]);

        return redirect()->route('hotellist.index')->with('success', '飯店資料已更新');
    }
    
    public function destroy($hotelId)
{
    // 刪除飯店
    DB::table('hotel')->where('HotelId', $hotelId)->delete();
    
    return redirect()->route('hotellist.index');
}

    
}


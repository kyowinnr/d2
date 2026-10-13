<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocaltsController extends Controller
{
    // 顯示所有資料及新增表單
    public function index()
    {
        // 查詢所有 localts 資料
        $localts = DB::table('localts')
                    ->join('hotellocal', 'localts.HotelLocalId', '=', 'hotellocal.HotelLocalId')
                    ->select('localts.*', 'hotellocal.LocalName')
                    ->get();
        
        // 查詢 hotellocal 資料用於下拉選單
        $hotels = DB::table('hotellocal')->get();

        return view('localts.index', compact('localts', 'hotels'));
    }

    // 儲存新增資料
    public function store(Request $request)
    {
        // 驗證資料
        $request->validate([
            'HotelLocalId' => 'required|integer|exists:hotellocal,HotelLocalId',
            'LocalTsName' => 'required|string|max:255',
            'LocalTsAdd' => 'nullable|string|max:255',
            'LocalTsTEL' => 'nullable|string|max:20',
            'LocalTsFax' => 'nullable|string|max:20',
            'LocalTsMan' => 'nullable|string|max:255',
        ]);

        // 新增資料
        DB::table('localts')->insert([
            'HotelLocalId' => $request->HotelLocalId,
            'LocalTsName' => $request->LocalTsName,
            'LocalTsAdd' => $request->LocalTsAdd,
            'LocalTsTEL' => $request->LocalTsTEL,
            'LocalTsFax' => $request->LocalTsFax,
            'LocalTsMan' => $request->LocalTsMan,
        ]);

        // 重新導向到資料頁面
        return redirect()->route('localts.index');
    }

    // 更新資料
    public function update(Request $request, $id)
    {
        $request->validate([
            'HotelLocalId' => 'required|integer|exists:hotellocal,HotelLocalId',
            'LocalTsName' => 'required|string|max:255',
            'LocalTsAdd' => 'required|string|max:255',
            'LocalTsTEL' => 'required|string|max:20',
            'LocalTsFax' => 'nullable|string|max:20',
            'LocalTsMan' => 'nullable|string|max:255',
        ]);

        // 更新資料
        DB::table('localts')
            ->where('LocalTsId', $id)
            ->update([
                'HotelLocalId' => $request->HotelLocalId,
                'LocalTsName' => $request->LocalTsName,
                'LocalTsAdd' => $request->LocalTsAdd,
                'LocalTsTEL' => $request->LocalTsTEL,
                'LocalTsFax' => $request->LocalTsFax,
                'LocalTsMan' => $request->LocalTsMan,
            ]);

        return redirect()->route('localts.index');
    }
}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function index()
    {
        // 查詢 location 資料表，並用 join 來取得對應的 ContinentID 和 Country
        $locations = DB::table('location')
            ->join('continent', 'location.ContinentID', '=', 'continent.ContinentID')
            ->select(
                'location.LocationId',
                'location.LocationName',
                'location.ContinentID',
                'continent.Country',
                DB::raw("IF(location.Display = 0, 'Y', 'N') as DisplayStatus")
            )
            ->get();
        // 取得 continent 資料表中的國家
        $countries = DB::table('continent')->select('ContinentID', 'Country')->get();
        
        // 傳遞數據到視圖
        return view('location.index', compact('locations','countries'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'continent_id' => 'required|exists:continent,ContinentID',
            'location_name' => 'required|string|max:255',
        ]);

        // 新增到 location 資料表，Display 預設為 0
        DB::table('location')->insert([
            'LocationName' => $request->location_name,
            'ContinentID' => $request->continent_id,
            'Display' => 0,
        ]);

        return redirect()->route('location.index');
    }
    
    
    // 更新地點資料
    public function update(Request $request, $id)
    {
        $request->validate([
            'continent_id' => 'required|exists:continent,ContinentID',
            'location_name' => 'required|string|max:255',
            'display_status' => 'required|in:Y,N',
        ]);

        DB::table('location')
            ->where('LocationId', $id)
            ->update([
                'LocationName' => $request->location_name,
                'ContinentID' => $request->continent_id,
                'Display' => $request->display_status === 'Y' ? 0 : 1,
            ]);

        return redirect()->route('location.index');
    }
}


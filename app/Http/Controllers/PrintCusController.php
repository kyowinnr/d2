<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrintCusController extends Controller
{
    public function index(Request $request)
    {
        // 取得 type 參數
        $type = $request->input('type');
        $OrderId = $request->input('OrderId');
        
        $customers = DB::table('customer')
                         ->where('OrderId', $OrderId)
                         ->where('Cancel',0)
                         ->get(); // 這裡查詢 'customer' 資料表
        
        return view('printcus.index', compact('customers','type'));
        
         
    }
}


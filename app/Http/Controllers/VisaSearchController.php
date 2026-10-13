<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class VisaSearchController extends Controller
{
    // 主畫面顯示
    public function index(Request $request)
    {
       $cusName = $request->input('CusName', '8548456');      
       $customers = DB::table('customer')
                    ->join('sign2', 'customer.CusId', '=', 'sign2.CusId')  // 連接 'customer' 和 'sign2' 表
                    ->where('Name', 'LIKE', '%' . $cusName . '%')
                    ->distinct()
                    ->get(); 
       return view('visasearch.index', compact('customers'));
    }
    
}


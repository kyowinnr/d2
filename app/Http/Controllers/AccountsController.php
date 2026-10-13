<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountsController extends Controller
{
    // 顯示所有資料及新增表單
    public function index()
    {
    // 從資料表 aitem 查詢所有資料
    $items = DB::table('aitem')->get();

    return view('accountsma.index', compact('items'));
    }
    
    
    //新增
    public function store(Request $request)
    {
    // 驗證資料
    $request->validate([
        'ItemName' => 'required|string|max:255',
        'ItemType' => 'required|in:0,1',
    ]);

    // 新增資料到資料表 aitem
    DB::table('aitem')->insert([
        'ItemName' => $request->ItemName,
        'ItemType' => $request->ItemType,
    ]);

    return redirect()->route('accountsma.index');
    }
    
    
    //更新
    public function update(Request $request, $ItemId)
    {
    // 驗證資料
    $request->validate([
        'ItemName' => 'required|string|max:255',
        'ItemType' => 'required|in:0,1',
    ]);

    // 更新資料表 aitem
    DB::table('aitem')
        ->where('ItemId', $ItemId)
        ->update([
            'ItemName' => $request->ItemName,
            'ItemType' => $request->ItemType,
        ]);

    return redirect()->route('accountsma.index');
    }   


    
}


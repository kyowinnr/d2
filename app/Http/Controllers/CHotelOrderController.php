<?php

namespace App\Http\Controllers;

use App\Models\CHotelOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CHotelOrderController extends Controller
{
    
  public function index(Request $request)
{
    // CloseType = 0 處理中, 1已收訂, 2已成行, 3已取消
    $filter = $request->input('filter', 'unfinished'); // 預設為查找 CloseType = 0 或 1

    $query = CHotelOrder::select('Cid', 'TourDate', 'HotelDate', 'Customer', 'Phone', 'DateLine', 'CloseType');

    // 如果選擇的是未取消資料
    if ($filter === 'not_closed') {
        $query->where('CloseType', '!=', 3);
    }

    // 如果選擇的是未完成資料 (CloseType = 0 或 1)
    if ($filter === 'unfinished') {
        $query->whereIn('CloseType', [0, 1]);
    }

    // 依照 DateLine (訂金日期) 升序排列
    $orders = $query->orderBy('DateLine', 'asc')->get();

    return view('chotelorder.index', compact('orders', 'filter'));
}

public function show($Cid)
{
    // 根據 Cid 查詢具體的訂單
    $order = CHotelOrder::findOrFail($Cid);

    // 顯示該訂單的詳細資訊
    return view('chotelorder.show', compact('order'));
}


public function update(Request $request, $id)
{
    $request->validate([
        'CloseType' => 'required|integer|in:0,1,2,3',
        'Activity' => 'nullable|integer|in:1,2,3,4',
        // 你可以加入其他欄位驗證
    ]);

    $order = CHotelOrder::findOrFail($id);

    $order->CloseType = $request->input('CloseType');
    $order->Activity = $request->input('Activity');
    $order->GroupName = $request->input('GroupName');
    $order->Target = $request->input('Target');
    $order->Customer = $request->input('Customer');
    $order->Phone = $request->input('Phone');
    $order->Ins = $request->input('Ins');
    $order->Num = $request->input('Num');
   $order->Discount = is_array($request->input('Discounts')) 
    ? implode('、', $request->input('Discounts')) 
    : '';
    $order->HotelDate = $request->input('HotelDate');
    $order->TourDate = $request->input('TourDate');
    $order->Deposit = $request->input('Deposit');
    $order->DateLine = $request->input('DateLine');
    $order->Ps = $request->input('Ps');
    $order->S2 = $request->input('S2');
    $order->T3 = $request->input('T3');
    $order->T4 = $request->input('T4');

    $order->save();

    return redirect()->route('chotelorder.show', $order->Cid);
}



    
}









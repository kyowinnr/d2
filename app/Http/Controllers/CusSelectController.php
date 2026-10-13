<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CusSelectController extends Controller
{
    // 顯示客戶名單
    public function index(Request $request)
    {
      $OrderTrafficId=$request->input('OrderTrafficId');
      
       $ordertraffic = DB::table('ordertraffic')
                     ->join('traffic', 'ordertraffic.TrafficId', '=', 'traffic.TrafficId')
                     ->where('ordertraffic.OrderTrafficId', $OrderTrafficId)
                     ->select('ordertraffic.*', 'traffic.TrafficName') // 包括所有 ordertraffic 欄位和 trafficName
                     ->first();


        $cusList = $ordertraffic->CusList;

        // 將 CusList 中的 CusId 分解為陣列（如果不是 ALL）
         $selectedCustomerIds = ($cusList == 'ALL') ? [] : explode(',', $cusList);

       // 查詢所有客戶，無論是否是 ALL
        $customers = DB::table('customer')
                     ->where('OrderId', $ordertraffic->OrderId) // 只篩選與 OrderId 對應的客戶
                     ->orderBy('TM', 'desc') // 按 TM 降冪排序
                     ->get();
                  

           // 判斷是否是全選
        $isAllSelected = $cusList === 'ALL';

        return view('cusselect.index', [
                    'ordertraffic' => $ordertraffic, 
                    'customers' => $customers,
                    'cusList' => $cusList, 
                    'isAllSelected' => $isAllSelected,
                    'selectedCustomerIds' => $selectedCustomerIds, // 明確傳遞此變數
                    ]);
    }

    // 更新選中的客戶列表
     public function update(Request $request, $OrderTrafficId)
    {
        
        // 確保 ordertraffic 存在
        $ordertraffic = DB::table('ordertraffic')
            ->where('OrderTrafficId', $OrderTrafficId)
            ->first();

        // 獲取勾選的客戶 ID
        $selectedCusIds = $request->input('customer_ids', []);

        // 如果全部勾選
        if (count($selectedCusIds) === DB::table('customer')
                ->where('OrderId', $ordertraffic->OrderId)
                ->count()) {
            $cusList = 'ALL';
        } else {
            // 使用逗號連接選中的客戶 ID
            $cusList = implode(',', $selectedCusIds);
        }

        // 更新 ordertraffic 表
        DB::table('ordertraffic')
            ->where('OrderTrafficId', $OrderTrafficId)
            ->update([
                'CusList' => $cusList,
            ]);

        // 返回原頁面
        return redirect()->route('cusselect.index', ['OrderTrafficId' => $OrderTrafficId]);
    }
}




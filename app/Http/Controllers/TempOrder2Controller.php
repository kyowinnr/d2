<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class TempOrder2Controller extends Controller
{
    // 主畫面顯示
    public function index(Request $request)
    {     
      $temps = DB::table('temporder')
    ->join('often', 'often.Often_ID', '=', 'temporder.OftenId') // 連結 user 表
    ->join('location as loc1', 'loc1.LocationId', '=', 'temporder.Location1') // 連結 Location1
    ->join('location as loc2', 'loc2.LocationId', '=', 'temporder.Location2') // 連結 Location2
    ->select(
        'temporder.*',
        'often.Often_Group', // 來自 user 表
        'loc1.LocationName as Location1Name', // Location1 對應的名稱
        'loc2.LocationName as Location2Name'  // Location2 對應的名稱
    )
    ->where('OftenId','!=', '1')
    ->orderBy('Close', 'asc') // 按 Close 升序排列
    ->get();
       return view('temporder2.index', compact('temps'));
    }
    
    public function show($id)
    {
     
    // 更新 Close 欄位為 2
    
     DB::table('temporder')
        ->where('T_ID', $id)
        ->update([       
            'Close' => '2',
        ]);

    return redirect('/temporder2');
    }
    
    public function update($id)
    {
      //搜尋temporder裡的資料
      $TempOrder = DB::table('TempOrder')
                     ->join('often', 'often.Often_ID', '=', 'TempOrder.OftenId') // 連結 user 表 
                     ->select('TempOrder.*','Often_Group','Often_OrderCus','Often_OrderTel')
                     ->where('T_ID', $id)->first();
              
      // 呼叫 generateOrderId 方法，傳遞 startdate 並接收 OrderId
      $orderId = $this->generateOrderId( $TempOrder->Startdate);
      $startdate=$TempOrder->Startdate;
      $comedate=$TempOrder->Enddate;
      // 判斷單趟或來回
       if ($TempOrder->Location1 != 29 && $TempOrder->Location2 != 29) {
              $way = 0; // 來回
       } elseif ($TempOrder->Location1 == 29) {
            $way = 1; // 單回
            $startdate = $comedate;
      } else {
            $way = 2; // 單去
            $comedate = $startdate;
     }
     
      //寫入order
       DB::table('order')->insert([
                ['OrderId' => $orderId,'OrderType' => 2 ,'OrderBuss'=> $TempOrder->Often_Group,'OrderCus' => $TempOrder->Often_OrderCus ,'OrderTel' => $TempOrder->Often_OrderTel,
                 'OrderStart' =>$startdate , 'OrderCome' =>$comedate , 'CusNum' => $TempOrder->Number,'Ps'=> $TempOrder->Ps,'CreateMan' => auth()->id(),
                ]
                
            ]);
      
      
      // 插入旅客代表1
       DB::table('customer')->insert(['OrderId' => $orderId, 'Name' => $TempOrder->CusName1, 'Phone' => $TempOrder->CusPhone1, 'TM' => 1,]);
     // 插入旅客代表2（如果存在）
      if (!empty($TempOrder->CusName2)) {
          DB::table('customer')->insert(['OrderId' => $orderId, 'Name' => $TempOrder->CusName2,'Phone' => $TempOrder->CusPhone2,]);
      }
      
      
      
      
      // 判斷 TrafficId 和 Time
      $trafficMapping = [
        37 => ['id' => 39, 'time' => '05:00:00'],
        88 => ['id' => 39, 'time' => '05:15:00'],
        89 => ['id' => 39, 'time' => '05:30:00'],
        40 => ['id' => 36, 'time' => '07:00:00'],
        41 => ['id' => 36, 'time' => '07:20:00'],
        90 => ['id' => 36, 'time' => '07:20:00'],
        31 => ['id' => 36, 'time' => '07:40:00'],
        43 => ['id' => 36, 'time' => '07:40:00'],
        67 => ['id' => 36, 'time' => '08:10:00'],
        171 => ['id' => 108, 'time' => '08:00:00'],
        167 => ['id' => 108, 'time' => '08:30:00'],
        170 => ['id' => 113, 'time' => '08:30:00'],
        151 => ['id' => 113, 'time' => '08:40:00'],
       ];
       
       //回程的
       $trafficMapping2 = [
        37 => ['id' => 40, 'time' => '18:30:00'],
        88 => ['id' => 40, 'time' => '18:30:00'],
        89 => ['id' => 40, 'time' => '18:30:00'],
        40 => ['id' => 37, 'time' => '18:30:00'],
        41 => ['id' => 37, 'time' => '18:30:00'],
        90 => ['id' => 37, 'time' => '18:30:00'],
        31 => ['id' => 37, 'time' => '18:30:00'],
        43 => ['id' => 37, 'time' => '18:30:00'],
        67 => ['id' => 37, 'time' => '18:30:00'],
        171 => ['id' => 109, 'time' => '18:30:00'],
        167 => ['id' => 109, 'time' => '18:30:00'],
        170 => ['id' => 114, 'time' => '18:30:00'],
        151 => ['id' => 114, 'time' => '18:30:00'],
       ];
       

        $TrafficId1 = $trafficMapping[$TempOrder->Location1]['id'] ?? null;
        $Time1 = $startdate . ' ' . ($trafficMapping[$TempOrder->Location1]['time'] ?? '00:00:00');
        $TrafficId2 = $trafficMapping2[$TempOrder->Location1]['id'] ?? null;
        $Time2 = $comedate . ' ' . ($trafficMapping2[$TempOrder->Location1]['time'] ?? '00:00:00');

       // 插入 ordertraffic 資料
      if ($way == 0) { // 來回
         DB::table('ordertraffic')->insert([
                ['OrderId' => $orderId, 'Date' => $Time1,'LocationId'=>$TempOrder->Location1, 'LocationId2'=>'29','TrafficId' => $TrafficId1,'cusnum'=>$TempOrder->Number,
                 'Ps'=>$TempOrder->PS1],
                ['OrderId' => $orderId, 'Date' => $Time2,'LocationId'=>'29' ,'LocationId2'=>$TempOrder->Location2,'TrafficId' => $TrafficId2,'cusnum'=>$TempOrder->Number,
                 'Ps'=>$TempOrder->PS2],
        ]);
    } else {
         $TrafficId = $way == 1 ? $TrafficId2 : $TrafficId1;
         $Time = $way == 1 ? $Time2 : $Time1;

        DB::table('ordertraffic')->insert([
             'OrderId' =>$orderId,
             'Date' => $Time,
             'TrafficId' => $TrafficId,
             'cusnum'=>$TempOrder->Number,
        ]);
     }
      
      
            
            
       // 更新 Close 欄位為 1
    
        DB::table('temporder') ->where('T_ID', $id)  ->update([ 'Close' => '1', ]);
             
       return redirect('/temporder2');        
     
    }
    
    
    // 生成 OrderId 的邏輯
   private function generateOrderId($startdate)
   {
      // 提取年與月
      $yearMonth = date('Y-m', strtotime($startdate)); // 例: "2024-10"
      $shortYear = substr(date('Y', strtotime($startdate)), 2); // 例: "24"
      $month = date('m', strtotime($startdate)); // 例: "10"

      // 查詢當前 GMonth 的 ticket
      $ticket = DB::table('ticket')->where('GMonth', $yearMonth)->first();

      if (!$ticket) {
        // 當月無數據，新增記錄並初始化 GNumber 為 0
        DB::table('ticket')->insert([
            'GMonth' => $yearMonth,
            'GNumber' => 0,
        ]);
        $currentGNumber = 1;
      } else {
        // 如果記錄已存在，直接自增 GNumber
        DB::table('ticket')->where('GMonth', $yearMonth)->increment('GNumber');
        $currentGNumber = $ticket->GNumber + 1; // 新的 GNumber
      }

      // 生成 OrderId
      $orderId = sprintf('%sT%s%04d', $shortYear, $month, $currentGNumber); // 例: "24T100001"

      return $orderId; // 返回生成的 OrderId
  }

}


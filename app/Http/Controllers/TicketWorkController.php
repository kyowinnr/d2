<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TicketWorkController extends Controller
{
      
    
    public function step_one(Request $request)
    {
      // 接收表單提交的所有欄位
      $startdate = $request->input('startdate');
      $comedate=$request->input('comedate');
      $CusNum=$request->input('CusNume');
      $tickettype=$request->input('tickettype');
      $localselect=$request->input('localselect');
      
      
      // 呼叫 generateOrderId 方法，傳遞 startdate 並接收 OrderId
       $orderId = $this->generateOrderId($startdate);
       $ordertraffic = $this->createFlight($request, $orderId);
      
      //Often處理
      $often=$request->input('often');
       if ($often !== null) {
        // 搜尋 often 表中的數據
        $oftenData = DB::table('often')->where('Often_ID', $often)->first();

        if ($oftenData) {
            // 使用搜尋到的數據設置值
            $OrderBuss = $oftenData->Often_Group;
            $OrderCus = $oftenData->Often_OrderCus;
            $OrderTel = $oftenData->Often_OrderTel;
            $OrderFax = $oftenData->Often_OrderFax;
        } else {
            // 如果未找到相應的數據，設置為空或處理錯誤
            $GroupName = $OrderCus = $OrderTel = $OrderFax = null;
        }
    } else {
        // 如果 $often 為 null，直接從請求中獲取值
        $OrderBuss = $request->input('OrderBuss');        
        $OrderCus = $request->input('OrderCus');
        $OrderTel = $request->input('OrderTel');
        $OrderFax = $request->input('OrderFax');
    }

      //寫入order
      $OrderStart=$request->input('startdate');
      $OrderCome=$request->input('comedate');
      $cusNum = $request->input('CusNum');           // 乘客人數
      
      DB::table('order')->insert([
                ['OrderId' => $orderId,'OrderType' => 2 ,'OrderBuss'=> $OrderBuss ,'OrderStart' => $OrderStart, 'OrderCome' => $OrderCome, 'CusNum' => $cusNum,
                 'OrderCus' => $OrderCus,'OrderTel' => $OrderTel,'CreateMan' => auth()->id()]
                
            ]);
            
            
        // 預先插入 customer 1個
        DB::table('customer')->insert([          'OrderId' => $orderId,'Name' => "補名單", 'Tm' => 1,        ]);     
   
      return redirect()->route('ticket.index2', ['orderId' => $orderId, 'CusNum' => $cusNum]);


//      return redirect()->route('ticket.index2', ['orderId' => $orderId,'CusNum'=>$cusNum]);
     
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

    

   //預先寫入交通
   public function createFlight(Request $request, $orderId)
{
    $ticketType = $request->input('tickettype');
    $localSelect = $request->input('localselect'); // Location ID
    $startDate = $request->input('startdate');     // 航班出發日期
    $comeDate = $request->input('comedate');       // 航班回程日期
    $CusNum = $request->input('CusNum');           // 乘客人數

    // 預設變數
    $time = '';
    $presetPrice = 0;
    $trafficId1 = null;
    $trafficId2 = null;

    // 條件判斷：處理車票類型及位置 ID 設定
    if (in_array($ticketType, [2, 3])) {
        switch ($localSelect) {
            case 37:
                $trafficId1 = 39;
                $trafficId2 = 40;
                $time = "$startDate 05:00:00"; // 根據區域調整時間
                $presetPrice = 1100;
                break;
            case 88:
                $trafficId1 = 39;
                $trafficId2 = 40;
                $time = "$startDate 05:15:00"; // 根據區域調整時間
                $presetPrice = 1100;
                break;
            case 89:
                $trafficId1 = 39;
                $trafficId2 = 40;
                $time = "$startDate 05:30:00"; // 根據區域調整時間
                $presetPrice = 1100;
                break;
            case 40:
                $trafficId1 = 36;
                $trafficId2 = 37;
                $time = "$startDate 07:00:00";
                $presetPrice = 550;
                break;
            case 41:
                $trafficId1 = 36;
                $trafficId2 = 37;
                $time = "$startDate 07:20:00";
                $presetPrice = 550;
                break;
            case 90:
                $trafficId1 = 36;
                $trafficId2 = 37;
                $time = "$startDate 07:20:00";
                $presetPrice = 550;
                break;
            case 31:
                $trafficId1 = 36;
                $trafficId2 = 37;
                $time = "$startDate 07:40:00";
                $presetPrice = 550;
                break;
            case 43:
                $trafficId1 = 36;
                $trafficId2 = 37;
                $time = "$startDate 07:40:00";
                $presetPrice = 550;
                break;
            case 67:
                $trafficId1 = 36;
                $trafficId2 = 37;
                $time = "$startDate 08:10:00";
                $presetPrice = 550;
                break;
            case 171: // 嘉義火車站
                $trafficId1 = 108;
                $trafficId2 = 109;
                $time = "$startDate 07:50:00";
                $presetPrice = 460;
                break;
            case 167: // 嘉義高鐵站
                $trafficId1 = 108;
                $trafficId2 = 109;
                $time = "$startDate 08:30:00";
                $presetPrice = 360;
                break;
            case 170: // 新營火車站
                $trafficId1 = 113;
                $trafficId2 = 114;
                $time = "$startDate 08:30:00";
                $presetPrice = 360;
                break;
            case 151: // 新營客運站
                $trafficId1 = 113;
                $trafficId2 = 114;
                $time = "$startDate 08:40:00";
                $presetPrice = 360;
                break;
        }
    }

    // 插入數據：依不同票種處理
    
    
        if ($ticketType == 1) { // 純票
            $data = [
                   ['OrderId' => $orderId, 'Date' => "$startDate 10:00:00", 'LocationId' => 29, 'LocationId2' => 30, 'TrafficId' => 34, 'cusnum' => $CusNum],
                   ['OrderId' => $orderId, 'Date' => "$comeDate 16:00:00", 'LocationId' => 30, 'LocationId2' => 29, 'TrafficId' => 34, 'cusnum' => $CusNum],
            ];
            $inserted = DB::table('ordertraffic')->insert($data);
            
        } elseif ($ticketType == 2) { // 車 + 船
            DB::table('ordertraffic')->insert([
                ['OrderId' => $orderId, 'Date' => "$startDate 10:00:00", 'LocationId' => 29, 'LocationId2' => 30, 'TrafficId' => 34, 'cusnum' => $CusNum],
                ['OrderId' => $orderId, 'Date' => "$comeDate 16:00:00", 'LocationId' => 30, 'LocationId2' => 29, 'TrafficId' => 34, 'cusnum' => $CusNum],
                ['OrderId' => $orderId, 'Date' => $time, 'LocationId' => $localSelect, 'LocationId2' => 29, 'TrafficId' => $trafficId1, 'cusnum' => $CusNum],
                ['OrderId' => $orderId, 'Date' => "$comeDate 18:00:00", 'LocationId' => 29, 'LocationId2' => $localSelect, 'TrafficId' => $trafficId2, 'cusnum' => $CusNum],
            ]);
        } elseif ($ticketType == 3) { // 純車
            DB::table('ordertraffic')->insert([
                ['OrderId' => $orderId, 'Date' => $time, 'LocationId' => $localSelect, 'LocationId2' => 29, 'TrafficId' => $trafficId1, 'cusnum' => $CusNum],
                ['OrderId' => $orderId, 'Date' => "$comeDate 18:00:00", 'LocationId' => 29, 'LocationId2' => $localSelect, 'TrafficId' => $trafficId2, 'cusnum' => $CusNum],
            ]);

            // 插入應收款項
            DB::table('receivable')->insert([
                'OrderId' => $orderId,
                'RItemId' => 106,
                'Price' => $presetPrice,
                'Number' => $CusNum,
            ]);
        }

       
   
}
    
    
    public function step_final(Request $request)
  {
     $OrderId = $request->input('OrderId');
     $names = $request->input('Name');
     $birthdays = $request->input('Birthday');
     $ids = $request->input('ID');
     $sexes = $request->input('Sex');
     $ticketypes = $request->input('TicketType');
     $phones = $request->input('Phone');
     $ps = $request->input('Ps');

    //先清除原本資料
    
    DB::table('customer')->where('OrderId', $OrderId)->delete();


    // 旅客資料寫入 customer 表單
    foreach ($names as $index => $name) {
        // 第一筆資料特殊處理
        $tm = $index === 0 ? 1 : 0;

        // 若第一筆資料未輸入姓名，設為"缺資料"
        if ($index === 0 && empty($name)) {
            $name = '缺資料';
        }
        // 檢查日期格式是否正確，若格式錯誤設為 '0000-00-00'
    $birthday = $birthdays[$index] ?? null;
    if ($birthday && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $birthday)) {
        $birthday = null;
    }
        
        // 插入到 customer 表單
        DB::table('customer')->insert([
            'OrderId' => $OrderId,
            'Name' => $name,
            'Birthday' => $birthday,
            'ID' => $ids[$index] ?? null,
            'Sex' => $sexes[$index] ?? 4,
            'TicketType' => $ticketypes[$index] ?? 0,
            'Phone' => $phones[$index] ?? null,
            'Ps' => $ps[$index] ?? null,
            'Tm' => $tm,
        ]);
    }

    // 更新訂單的訂金資料
    DB::table('order')
        ->where('OrderId', $OrderId)
        ->update([
            'DepositDate' => $request->input('date'),
            'Deposit' => $request->input('price'),
            'CreateMan' => auth()->id(),
        ]);

    // 返回到原頁面或顯示成功訊息
    return redirect('/ordersearch');
}



}  




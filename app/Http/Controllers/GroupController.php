<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    // index 方法：顯示搜尋表單
    public function index()
    {
       $continents = DB::table('continent')->get();  // 獲取所有國家資料
 
      $Taiwan = DB::table('localts')
      ->select('LocalTsId', 'HotelLocalId', 'LocalTsName')
      ->where('HotelLocalId', 2)
      ->get();
       
      $Foreign = DB::table('localts')
      ->select('LocalTsId', 'HotelLocalId', 'LocalTsName')
      ->where('HotelLocalId', 1)
      ->get(); 
        

       return view('group.index',compact('continents','Taiwan','Foreign'));
    }

    // store 方法：處理搜尋請求
    public function store(Request $request)
    {
      // 呼叫 generateOrderId 方法，傳遞 startdate 並接收 OrderId
        $startdate = $request->startdate;
        $cusNum =$request->CusNum;
        $orderId = $this->generateOrderId( $startdate);
     
        DB::table('order')->insert([
            'OrderId' => $orderId,
            'OrderType' => '0',
            'GroupName' => $request->GroupName,
            'ContinentID' => $request->continent,
            'OrderStart' => $startdate ,
            'OrderCome' => $request->comedate,
            'CusNum' => $cusNum ,
            'OrderBuss' => $request->OrderBuss,
            'OrderCus' => $request->OrderCus,
            'OrderTel' => $request->OrderTel,
            'OrderFax' => $request->OrderFax,
            'OrderMail' => $request->OrderMail,
            'TaiwanTs' => $request->TaiwanTs,
            'TaiwanTs' => $request->TaiwanTs,
            'Guide1' => $request->Guide1,
            'Fts' => $request->FTs,
            'Ticket' => $request->Ticket,
            'Shopping' => $request->Shopping,
            'OTour' => $request->OTour,
            'Ps' => $request->orderps,
            'CreateMan' => auth()->id(),
         
         ]);
     
      
         // 根據 CusNum 插入 customer 資料表
        for ($i = 0; $i < $cusNum; $i++) {
            DB::table('customer')->insert([
                'OrderId' => $orderId,
                'Name' => $i === 0 ? '缺資料' : '',
                'TM' => $i === 0 ? 1 : 0,
            ]);
        }
        
        return redirect('/ordersearch');
      
    }
    
    
    // 生成 OrderId 的邏輯
   private function generateOrderId($startdate)
   {
      // 提取年與月
      $yearMonth = date('Y-m', strtotime($startdate)); // 例: "2024-10"
      $shortYear = substr(date('Y', strtotime($startdate)), 2); // 例: "24"
      $month = date('m', strtotime($startdate)); // 例: "10"

      // 查詢當前 GMonth 的 ticket
      $ticket = DB::table('group')->where('GMonth', $yearMonth)->first();

      if (!$ticket) {
        // 當月無數據，新增記錄並初始化 GNumber 為 0
        DB::table('group')->insert([
            'GMonth' => $yearMonth,
            'GNumber' => 0,
        ]);
        $currentGNumber = 1;
      } else {
        // 如果記錄已存在，直接自增 GNumber
        DB::table('group')->where('GMonth', $yearMonth)->increment('GNumber');
        $currentGNumber = $ticket->GNumber + 1; // 新的 GNumber
      }

      // 生成 OrderId
      $orderId = sprintf('%sG%s%04d', $shortYear, $month, $currentGNumber); // 例: "24T100001"

      return $orderId; // 返回生成的 OrderId
  }
}


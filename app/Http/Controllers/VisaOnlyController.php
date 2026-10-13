<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisaOnlyController extends Controller
{
   public function index(Request $request)
  {
    $sexs = DB::table('sex')->get();            //性別 
    $tickets = DB::table('tickettype')->get();  //票種 
    $schedules = DB::table('schedule')->get();  //進度品項
    $windows = DB::table('window')->get();      //窗口品項      

    // 返回視圖，並將查詢結果傳遞到視圖中
    return view('visaonly.index', compact('sexs','tickets','schedules','windows'));
  }


  public function store(Request $request)
  {
        $CusId =DB::table('customer')->insertGetId([
            'Name' => $request->input('Name'),
            'EName' => $request->input('EName'),
            'ID' => $request->input('ID'),
            'Birthday' => $request->input('Birthday'),
            'Phone' => $request->input('Phone'),
            'TicketType' => $request->input('TicketType'),
            'Sex' => $request->input('Sex'),
            'Ps' => $request->input('Ps'),
            'PpNumber' => $request->input('PpNumber'),
            'PpDate' => $request->input('PpDate'),
            'PpDate1' => $request->input('PpDate1'),
            'TbNumber' => $request->input('TbNumber'),
            'TbDate' => $request->input('TbDate'),
            'CarNo' => 1,
            'CarNo2' => 1,
            'StartPNR' => $request->input('StartPNR'),
            'StartETicket' => $request->input('StartETicket'),
            'ComePNR' => $request->input('ComePNR'),
            'ComeETicket' => $request->input('ComeETicket'),
            'OrderId'  => 'Credentials',
        ]);
      
       // 檢查必填欄位是否有輸入
    $L_date = $request->input('L_date');
    $schedule = $request->input('schedule');
    $window = $request->input('window');

    // 只有當 L_date, schedule 和 window 有輸入時才插入
    if ($L_date && $schedule && $window) {
     // 將數據插入到 `list` 資料表
     DB::table('list')->insert([
          'CusId' => $CusId,
          'L_date' => $request->input('L_date'),
          'S_Id' => $request->input('schedule'),
          'window' => $request->input('window'),
          'Ps' => $request->input('Ps'),
          'Income2' => $request->input('Income2'),
          'Exp' => $request->input('Exp'),
          'Income' => $request->input('Income'),
      ]);
      
   }   
      // 2. 更新 visatype2 表
    $visaTypes = $request->input('visa_types', []);
    
    foreach ($visaTypes as $visaType) {
        DB::table('visatype2')->insert([
            'CusId' => $CusId,
            'V1_Id' => $visaType,
        ]);
    }

    // 3. 更新 sign2 表
    $signTypes = $request->input('sign_types', []);
    
    foreach ($signTypes as $signType) {
        DB::table('sign2')->insert([
            'CusId' => $CusId,
            'S1_Id' => $signType,
        ]);
    }
    
    

   return redirect('/ordersearch');
  }

    

}


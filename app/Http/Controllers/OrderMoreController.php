<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;  // 引入 Excel 類


class OrderMoreController extends Controller
{
   // 主畫面顯示
    public function index(Request $request)
    {
      // 從 URL 取得 OrderId 參數
        $orderId = $request->query('orderId');
        
        // 查詢所有 aitem 資料作為下拉選單的選項
       $continents = DB::table('continent')->pluck('Country', 'ContinentID');
       
       //所有地區
       $locations = DB::table('location')
               ->where('Display', '=', 0) // 篩選 Display 等於 0 的資料
               ->get(); // 取得所有符合條件的資料
               
       //所有交通
       $traffics = DB::table('traffic')
               ->where('Display', '=', 0) // 篩選 Display 等於 0 的資料
               ->orderBy('TrafficType','ASC')
               ->get(); // 取得所有符合條件的資料        
       
       
       //訂單資訊       
        $order = DB::table('order')
            ->join('users', 'users.id', '=', 'order.CreateMan')
            ->where('order.OrderId', $orderId)
            ->select('order.*', 'users.username')
            ->first();
       
       //交通資訊
       $ordertraffics = DB::table('ordertraffic')
               ->where('OrderId', $orderId) // 根據 OrderId 篩選
               ->orderBy('Date','ASC')
               ->get(); // 取得所有符合條件的資料 
      //票種               
       $tickettypes = DB::table('tickettype') ->get(); // 取得所有符合條件的資料 
       
      //國內地接
       $local1 = DB::table('localts')
               ->where('HotelLocalId', '2') // 根據 OrderId 篩選               
               ->get(); // 取得所有符合條件的資料 
               
      //國外地接
       $local2 = DB::table('localts')
               ->where('HotelLocalId', '1') // 根據 OrderId 篩選               
               ->get(); // 取得所有符合條件的資料                
       //行程
       $ordertours=DB::table('ordertour')
               ->join('hotel', 'ordertour.HotelId', '=', 'hotel.HotelId') // 使用 join 連接 hotel 表
               ->where('OrderId', $orderId) // 根據 OrderId 篩選
               ->orderBy('Date','ASC')
                ->select('ordertour.*', 'hotel.HotelName')
               ->get(); // 取得所有符合條件的資料 
             
               
       //所有名單        
       $customers = DB::table('customer')
               ->join('sex', 'customer.Sex', '=', 'sex.SexId') // 聯接 sex 表
               ->join('tickettype', 'customer.TicketType', '=', 'tickettype.TypeId') // 聯接 tickettype 表
               ->where('customer.OrderId', $orderId) // 根據 OrderId 篩選
               ->orderBy('customer.TM', 'DESC') // 根據 TM 欄位排序
               ->select('customer.*', 'sex.SexName', 'tickettype.TypeName') // 選擇需要的欄位
               ->get(); // 取得符合條件的資料
       // 檢查每個客戶的 ID 是否有效
    foreach ($customers as $customer) {
        $customer->isValid = $this->isValidID($customer->ID); // 將驗證結果存到 isValid 屬性
    }     
       
          return view('ordermore.index', compact('order','continents','locations','traffics','ordertraffics','customers','tickettypes','local1','local2','ordertours'));
      
    
    }    


    public function update(Request $request, $orderid)
    {
      $form_type=$request->input('form_type');
     
      if($form_type=="form1"){  //訂單資料更新
      
        $request->merge([
              'TaiwanTs' => $request->input('TaiwanTs', 0), // 如果沒有值，設為 0
              'Ticket' => $request->input('Ticket', 0), // 如果沒有值，設為 0
              'FTs' => $request->input('FTs', 0), // 如果沒有值，設為 0
              'Guide1' => $request->input('Guide1', null), // 如果沒有值，設為 0
              'Guide1Tel' => $request->input('Guide1Tel', null), // 如果沒有值，設為 0
              'Guide2' => $request->input('Guide2', null), // 如果沒有值，設為 0
              'Guide2Tel' => $request->input('Guide2Tel', null), // 如果沒有值，設為 0
              
         
        ]);
       
      
    $validated = $request->validate([
        'OrderName'    => 'nullable|string|max:255',
        'ContinentID'  => 'required|integer',
        'OrderCus'     => 'nullable|string|max:255',
        'OrderTel'     => 'nullable|string|max:20',
        'OrderBuss'    => 'nullable|string|max:255',
        'CusNum'       => 'required|integer|min:1',
        'OrderFax'     => 'nullable|string|max:20',
        'Ps'           => 'nullable|string|max:1000',
        'OrderStart'   => 'nullable|date',
        'OrderCome'    => 'nullable|date|after_or_equal:OrderStart',
        'TaiwanTs'     => 'nullable|integer',
        'Ticket'       => 'nullable|integer',
        'FTs'          => 'nullable|integer',
        'Guide1'       => 'nullable|string',
        'Guide1Tel'    => 'nullable|string',
        'Guide2'       => 'nullable|string',
        'Guide2Tel'    => 'nullable|string',
    ]);
    
        // 更新資料到資料庫
        $updated = DB::table('order')
            ->where('OrderId', $orderid)
            ->update([
                'GroupName'   => $validated['OrderName'],
                'ContinentID' => $validated['ContinentID'],
                'OrderCus'    => $validated['OrderCus'],
                'OrderTel'    => $validated['OrderTel'],
                'OrderBuss'   => $validated['OrderBuss'],
                'CusNum'      => $validated['CusNum'],
                'OrderFax'    => $validated['OrderFax'],
                'Ps'          => $validated['Ps'],
                'OrderStart'  => $validated['OrderStart'],
                'OrderCome'   => $validated['OrderCome'],
                'TaiwanTs'    => $validated['TaiwanTs'],
                'Ticket'      => $validated['Ticket'],
                'FTs'         => $validated['FTs'],
                'Guide1'         => $validated['Guide1'],
                'Guide1Tel'         => $validated['Guide1Tel'],
                'Guide2'         => $validated['Guide2'],
                'Guide2Tel'         => $validated['Guide2Tel'],
                'CreateMan'   => auth()->id(), // 紀錄修改人
            ]);

            return redirect()->back();
      
      
      }elseif($form_type=="form3"){ //航班修改
         // 驗證請求資料
        $validated = $request->validate([
            'date'        => 'required|string',
            'LocationId'  => 'required|integer',
            'LocationId2' => 'required|integer',
            'TrafficId'   => 'required|integer',
            'cusnum'      => 'required|integer',
            'Ps'          => 'nullable|string|max:1000',
        ]);

        // 更新資料到資料庫
        $updated = DB::table('ordertraffic')
            ->where('OrderTrafficId', $orderid)
            ->update([
                'Date'   => $validated['date'],
                'LocationId' => $validated['LocationId'],
                'LocationId2'    => $validated['LocationId2'],
                'TrafficId'    => $validated['TrafficId'],
                'cusnum'   => $validated['cusnum'],
                'Ps'      => $validated['Ps'],
            ]);

            return redirect()->back();
        
      
      }elseif($form_type=="cus_update"){
      
         $validated = $request->validate([
                      'Cancel' => 'required|integer',
                      'CusId' => 'required|integer'
                     ]);

              // 獲取客戶的當前狀態
         $customer = DB::table('customer')->where('CusId', $validated['CusId'])->first();

         if ($customer) {
            $oldCancel = $customer->Cancel; // 紀錄原始 Cancel 值
            $newCancel = $validated['Cancel']; // 新的 Cancel 值

            // 更新客戶資料
         DB::table('customer')
             ->where('CusId', $validated['CusId'])
             ->update(['Cancel' => $newCancel]);

           // 查詢對應的訂單資料
        $order = DB::table('order')->where('OrderId', $orderid)->first();

        if ($order) {
        // 動態調整 CusNum
        if ($oldCancel == 0 && $newCancel == 1) {
            // Cancel 從 0 變為 1 -> CusNum -1
            DB::table('order')
                ->where('OrderId', $orderid)
                ->update(['CusNum' => max(0, $order->CusNum - 1)]);
        } elseif ($oldCancel == 1 && $newCancel == 0) {
            // Cancel 從 1 變為 0 -> CusNum +1
            DB::table('order')
                ->where('OrderId', $orderid)
                ->update(['CusNum' => $order->CusNum + 1]);
        }
    }
}

        return redirect()->back();
      
      }    //end cus_update
        
    }//end function update
    
    public function store(Request $request)
    {
   
        $orderId = $request->input('orderid');
        $form_type=$request->input('form_type');
        
        if($form_type == "form2"){ //新增交通
          // 驗證請求資料
           $validated = $request->validate([
              'Date'       => 'required|string',
              'location1'  => 'required|integer',
              'location2'  => 'required|integer',
              'traffic'    => 'required|integer',
              'Ps'         => 'nullable|string',
              'cusnum'     => 'required|integer',
              
           ]);
           
           
              // 寫入 ordertraffic 資料表
            DB::table('ordertraffic')->insert([
                'OrderId'     => $orderId,
                'Date'        => $validated['Date'],
                'LocationId'  => $validated['location1'],
                'LocationId2' => $validated['location2'], 
                'TrafficId'   => $validated['traffic'],                
                'Ps'          => $validated['Ps'],
                'CusNum'     => $validated['cusnum'],
             ]);

                      // 成功後重定向並提示
                return redirect() ->route('ordermore.index',['orderId' => $orderId]);
              
        
        
        }elseif($form_type == "cus_store"){     //新增旅客
              // 驗證輸入資料
             $validated = $request->validate([
                 'Name'       => 'nullable|string|max:255',
                 'Birthday'   => 'nullable|date',
                 'ID'         => 'nullable|string|max:10',
                 'Sex'        => 'nullable|integer',
                 'tickettype' => 'nullable|integer',
                 'Phone'      => 'nullable|string|max:15',
                 'Ps'         => 'nullable|string',
            
              ]);
              
              $tickettype = isset($validated['tickettype']) ? $validated['tickettype'] : 0;
              
              // 寫入 customer 資料表
            DB::table('customer')->insert([
                'OrderId'     => $orderId,
                'Name'        => $validated['Name'],
                'Birthday'    => $validated['Birthday'],
                'ID'          => $validated['ID'], 
                'Sex'         => $validated['Sex'],
                'TicketType'  => $tickettype,
                'Phone'       => $validated['Phone'],                
                'Ps'          => $validated['Ps'],                
             ]);

       

        // 更新 Order 資料，Cusnum +1
           $order = DB::table('order')->where('OrderId', $orderId)->first(); // 查詢對應的訂單
           if ($order) {DB::table('order')
                       ->where('OrderId', $orderId)
                      ->update(['CusNum' => $order->CusNum + 1]); // 增加 CusNum 並更新資料
           }

        // 返回或重定向
        return redirect() ->route('ordermore.index',['orderId' => $orderId]);
         
       }elseif($form_type == "tour_store"){  //新增行程
          $validated = $request->validate([
                 'Tour'       => 'nullable|string|max:255',
                 'Date'       => 'required|date',
                 'HotelId'    => 'nullable|integer',
            
              ]);
              
          DB::table('ordertour')->insert([
                'OrderId'     => $orderId,
                'Date'        => $validated['Date'],
                'Tour'        => $validated['Tour'],
                'HotelId'     => $validated['HotelId'],             
             ]);
             
             // 返回或重定向
        return redirect() ->route('ordermore.index',['orderId' => $orderId]);
       
       }
    }
    
    public function destroy(Request $request, $OrderTrafficId)
    {
        // 從表單資料中獲取必要的參數
        $orderId = $request->input('orderid'); // 從表單中獲取 orderid
        $tableName = $request->input('tableName'); // 獲取表名
        $tableId = $request->input('tableId'); // 獲取主鍵欄位名  
        
        if($tableName=="customer"){
          $order = DB::table('order')->where('OrderId', $orderId)->first(); // 查詢對應的訂單
          DB::table('order')
                ->where('OrderId', $orderId)
                ->update(['CusNum' => $order->CusNum - 1]); // 增加 CusNum 並更新資料
        }   

        // 刪除資料
        DB::table($tableName)->where($tableId, $OrderTrafficId)->delete();

       // 返回到指定頁面
        return redirect()->route('ordermore.index', ['orderId' => $orderId]);
   }
   
    
    //身分證驗證
    function isValidID($id) {
    
    // 身分證字號驗證：必須是10個字符（字母 + 9個數字）
    if (strlen($id) != 10) {
        return false;
    }
    

    // 英文字母轉數字，對應數值
    $letterMap = [
        'A' => 10, 'B' => 11, 'C' => 12, 'D' => 13, 'E' => 14, 'F' => 15, 'G' => 16, 'H' => 17, 'I' => 34, 'J' => 18,
        'K' => 19, 'L' => 20, 'M' => 21, 'N' => 22, 'O' => 35, 'P' => 23, 'Q' => 24, 'R' => 25, 'S' => 26, 'T' => 27,
        'U' => 28, 'V' => 29, 'W' => 32, 'X' => 30, 'Y' => 31, 'Z' => 33
    ];

    // 轉換字母部分為數字
    $letter = strtoupper($id[0]);
    if (!isset($letterMap[$letter])) {
        return false;
    }

    $firstDigit = $letterMap[$letter];
    $firstDigit1 = floor($firstDigit / 10); //十位數
    $firstDigit2 = $firstDigit % 10;//個位數

    // 檢查剩下的九個數字
    $digits = substr($id, 1);
    if (!preg_match('/^\d{9}$/', $digits)) {
        return false;
    }

    // 計算總和
    $total = $firstDigit1 + $firstDigit2 * 9;
    for ($i = 0; $i < 9; $i++) {
        $total += $digits[$i] * (8 - $i);
    }
   // 取得餘數
    $remainder = $total % 10;

    // 用 10 減去餘數，檢查是否等於最後一位數字
    $checkDigit = (10 - $remainder) % 10;  // 確保結果在 0 到 9 之間

    // 檢查最後一位數字是否符合
    if ($checkDigit == $digits[8]) {
        return true;  // 身分證字號驗證成功
    } else {
        return false; // 身分證字號驗證失敗
    }
    
    
   }
   
    public function import(Request $request, $OrderId,$date)
    {
    
      // 確認文件是否上傳
    if ($request->hasFile('file')) {
        $file = $request->file('file');

        // 使用 Maatwebsite\Excel 加載文件
        $data = Excel::toArray([], $file);

        if (isset($data[0]) && count($data[0]) > 0) {
            $rows = $data[0]; // 獲取第一個 sheet 的數據
            
            // 清空對應 OrderId 的現有數據
            DB::table('customer')->where('OrderId', $OrderId)->delete();
          
            // 處理數據並插入到數據庫
            $customerCount = 0; // 記錄資料數量
            foreach ($rows as $index => $row) {
                // 跳過空行
                if (empty($row[0])) {
                    continue;
                }

                // 轉換 birthday 為 YYYY-MM-DD 格式
                $birthday = $this->convertBirthday($row[2]);

                // 計算年齡
                $age = $this->calculateAge($birthday,$date);

                // 設定 tickettype 根據年齡
                $tickettype = $this->determineTicketType($age);

                // 設定 Sex 欄位
                $sex = $this->determineSex($row[1]);

                DB::table('customer')->insert([
                    'OrderId' => $OrderId,
                    'Name' => $row[0], // A欄
                    'ID' => $row[1] ?? null, // B欄
                    'Birthday' => $birthday,
                    'Phone' => $row[3] ?? null, // D欄
                    'TM' => $index === 0 ? 1 : 0, // 第一行 TM=1，其他行 TM=0
                    'Sex' => $sex,
                    'tickettype' => $tickettype,
                    'EName' => $row[4] ?? null, // E欄
                    'PpNumber' => $row[5] ?? null, // f欄
                    'PpDate1' => $row[6] ?? null, // G欄
                    'TbNumber' => $row[7] ?? null, // H欄
                    'TbDate' => $row[8] ?? null, // I欄
                ]);
                 $customerCount++; // 每插入一條記錄，數量加 1
            }
        }
        
        
        
        
    }
      
      //更新訂單人數
      DB::table('order')
             ->where('OrderId', $OrderId)
             ->update(['CusNum' => $customerCount]);
             
      //更新訂單交通資訊
     DB::table('ordertraffic')
         ->where('OrderId', $OrderId)
         ->update([
                'CusList' => 'ALL',  // 設置 CusList 為 'ALL'
                'cusnum' => $customerCount // 設置 cusnum 為 $customerCount
          ]);
             

    return redirect()->back();   
    }
    
    // 轉換回西元格式
   private function convertBirthday($birthday)
   {
     // 判斷年份是否小於 100，若小於 100 則為中華民國紀元
    $parts = explode('.', $birthday); // 以 "." 為分隔符分解日期

    // 檢查是否有足夠的日期部分
    if (count($parts) == 3) {
        $year = (int)$parts[0];  // 年份部分

        // 如果年份小於1000，則是中華民國紀元，需轉換為西元
        if ($year < 1000) {
            $year += 1911; // 中華民國紀元轉為西元年份
        }

        // 返回格式化的西元日期
        return sprintf('%04d-%02d-%02d', $year, $parts[1], $parts[2]);
    }

    return $birthday; // 如果格式不正確，直接返回原始數據
    }

// 計算年齡
private function calculateAge($birthday,$basedate)
{
    $birthDate = new \DateTime($birthday);
    $baseDate = new \DateTime($basedate);
    $age = $baseDate->diff($birthDate)->y; // 計算年齡
    return $age;
}

// 根據年齡判斷 tickettype
private function determineTicketType($age)
{
    if ($age < 3) {
        return 4; // 未滿3歲
    } elseif ($age >= 3 && $age < 12) {
        return 1; // 2歲以上未滿12歲
    } elseif ($age >= 12 && $age < 65) {
        return 2; // 12歲以上未滿65歲
    } else {
        return 3; // 65歲以上
    }
}

// 根據 ID 判斷 Sex
private function determineSex($id)
{
    if (isset($id) && (substr($id, 1, 1) == '1' || substr($id, 1, 1) == '2')) {
        return substr($id, 1, 1); // 如果第二個字是1或2，則設定性別為1或2
    }

    return 0; // 其他情況設為 0
}
    
}


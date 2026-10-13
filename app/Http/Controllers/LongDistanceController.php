<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LongDistanceController extends Controller
{
    public function index(Request $request)
    {
         
        // 檢查是否有傳入日期，沒有的話設為預設日期（明天）
         $date = $request->input('date', Carbon::tomorrow()->format('Y-m-d'));
         $carNumber = $request->input('carNumber', 1); // 預設車號為1

           //南下
        $orderTrafficData = DB::table('ordertraffic')
         ->join('location', 'ordertraffic.LocationId', '=', 'location.LocationId') // 使用 join 來連接 ordertraffic 和 location
         ->whereDate('ordertraffic.Date', $date) // 依日期篩選
         ->whereIn('ordertraffic.TrafficId', [36, 39]) // 篩選 TrafficId
         ->orderBy('ordertraffic.Date', 'asc') // 依照日期升冪排序
         ->select('ordertraffic.*', 'location.LocationName',DB::raw('DATE_FORMAT(ordertraffic.Date, "%H:%i") as TimeOnly')) // 取得需要的欄位，並格式化時間
         ->get(); // 返回一個資料集合

  

        $results = [];  $total=0;     $today_num=0;  
        foreach ($orderTrafficData as $orderTraffic) {
            // 預設 $northName 為空字串
            $northName = "";

            // 根據 LocationId 設定 $northName
            if (in_array($orderTraffic->LocationId, [37, 88, 89])) {
            
            // 設定 $northName 為 LocationId
            $northName = $orderTraffic->LocationName;
        
           // 設定 LocationName 為 "中港轉運站"
            $orderTraffic->LocationName = "中港轉運站";
        
        
        
          }

            // 若 CusList 為 ALL，搜尋 `customer` 表中符合條件的 Name 和 Phone
            if ($orderTraffic->CusList === 'ALL') {
                $customers = DB::table('customer')
                         ->join('ordertraffic', 'customer.OrderId', '=', 'ordertraffic.OrderId')  
                         ->where('CarNo', $carNumber)  // 篩選 CarNo 為指定車號
                         ->where('customer.OrderId', $orderTraffic->OrderId)
                         ->where('customer.Tm', 1)  // 篩選 Tm 為 1
                         ->whereIn('ordertraffic.TrafficId', [36, 39]) // 篩選 TrafficId
                          ->where('ordertraffic.OrderTrafficId', $orderTraffic->OrderTrafficId)
                          ->get(['ordertraffic.cusnum','customer.CusId','customer.Name', 'customer.Phone', 'customer.TbNumber']);
    
                    
                    //回程
                $comeDateEntry = DB::table('ordertraffic')
                ->where('OrderId', $orderTraffic->OrderId)
                ->where(function($query) {
                        $query->where('TrafficId', 37)
                ->orWhere('TrafficId', 40);  })
                ->select(DB::raw('DATE_FORMAT(Date, "%m/%d") as Date')) // 格式化日期為月/日
                ->first();
                
                $comeDate = $comeDateEntry ? $comeDateEntry->Date : '單趟';
    
            } else {
               
                $customers = DB::table('customer')
                 ->join('ordertraffic', 'customer.OrderId', '=', 'ordertraffic.OrderId')
                 ->where('customer.CusId', $orderTraffic->CusList) // 直接比對 CusId
                 ->whereIn('ordertraffic.TrafficId', [36, 39]) // 篩選 TrafficId
                 ->whereNotNull('Phone')
                 ->where('CarNo',$carNumber )
                 ->where('customer.OrderId', $orderTraffic->OrderId)
                  ->where('ordertraffic.OrderTrafficId', $orderTraffic->OrderTrafficId)
                 ->limit(1)
                 ->get(['ordertraffic.cusnum','customer.CusId', 'customer.Name', 'customer.Phone', 'customer.TbNumber']);
       
                // 回程
                $comeDateEntry = DB::table('ordertraffic')
                 ->where('OrderId', $orderTraffic->OrderId)
                 ->where(function($query) {
                     $query->where('TrafficId', 37)
                            ->orWhere('TrafficId', 40);
                     })
                 ->where('CusList', 'like', '%' . $orderTraffic->CusList . '%')
                 ->select(DB::raw('DATE_FORMAT(Date, "%m/%d") as Date')) // 格式化日期為月/日
                 ->first(); // 使用 first() 取得第一筆資料

               // 檢查是否找到資料，若無則設為 '單趟'
               $comeDate = $comeDateEntry ? $comeDateEntry->Date : '單趟';
               
            }

                    
            foreach ($customers as $customer) {             
               $today_num += $customer->cusnum;   
                   }  // 將 cusnum 加到總人數
          

          

            // 收集每個 `orderTraffic` 和對應的 `customer`
            $results[] = [
                'order' => $orderTraffic,
                'customers' => $customers,
                'northName' => $northName,  // 傳遞 $northName
                'comeDate' => $comeDate
            ];
            
            //總人數
            $total=$total+$orderTraffic->cusnum;
        }
         //南下結束
         
         //北上
        $orderTrafficData2 = DB::table('ordertraffic')
         ->join('location', 'ordertraffic.LocationId2', '=', 'location.LocationId') // 使用 join 來連接 ordertraffic 和 location
         ->whereDate('ordertraffic.Date', $date) // 依日期篩選
         ->whereIn('ordertraffic.TrafficId', [37, 40]) // 篩選 TrafficId
         ->orderBy('ordertraffic.Date', 'asc') // 依照日期升冪排序
         ->select('ordertraffic.*', 'location.LocationName') // 取得需要的欄位，並格式化時間
         ->get(); // 返回一個資料集合



        $results2 = [];  $total2=0;     $today_num2=0;   $cusnumArray = [];
        foreach ($orderTrafficData2 as $orderTraffic) {
            // 預設 $northName 為空字串
            $northName2 = "";

            // 根據 LocationId 設定 $northName
            if (in_array($orderTraffic->LocationId2, [37, 88, 89])) {
            
            // 設定 $northName 為 LocationId
            $northName2 = $orderTraffic->LocationName;
        
           // 設定 LocationName 為 "中港轉運站"
            $orderTraffic->LocationName = "中港轉運站";
               
         }

            // 若 CusList 為 ALL，搜尋 `customer` 表中符合條件的 Name 和 Phone
            if ($orderTraffic->CusList === 'ALL') {
                $customers2 = DB::table('customer')
                         ->join('ordertraffic', 'customer.OrderId', '=', 'ordertraffic.OrderId')  
                         ->where('CarNo2', $carNumber)  // 篩選 CarNo 為指定車號
                         ->where('customer.OrderId', $orderTraffic->OrderId)
                         ->where('customer.Tm', 1)  // 篩選 Tm 為 1
                         ->whereIn('ordertraffic.TrafficId', [37, 40]) // 篩選 TrafficId
                         
                          ->get(['ordertraffic.cusnum','customer.CusId','customer.Name', 'customer.Phone', 'customer.TbNumber']);
    
                    
                    
    
                    
            } else {
                // 若 CusList 不為 ALL，分割 CusList 並搜尋有電話的第一筆 Customer
                //$cusIds2 = explode(',', $orderTraffic->CusList);
                $customers2 = DB::table('customer')
                 ->join('ordertraffic', 'customer.OrderId', '=', 'ordertraffic.OrderId')               
                 ->where('customer.CusId', $orderTraffic->CusList) // 直接比對 CusId
                 ->whereIn('ordertraffic.TrafficId', [37, 40]) // 篩選 TrafficId
                 ->where('CarNo2',$carNumber )
                 ->where('customer.OrderId', $orderTraffic->OrderId)  
                 ->where('ordertraffic.OrderTrafficId', $orderTraffic->OrderTrafficId)
                 ->limit(1)
                 ->get(['ordertraffic.cusnum','customer.CusId','customer.Name', 'customer.Phone', 'customer.TbNumber']);               
                 
                
               
            }   

            foreach ($customers2 as $customer) { $today_num2 += $customer->cusnum;}  // 將 cusnum 加到總人數
         




            // 收集每個 `orderTraffic` 和對應的 `customer`
            $results2[] = [
                'order' => $orderTraffic,
                'customers' => $customers2,
                'northName' => $northName2,  // 傳遞 $northName
            ];
            
            //總人數
            
            $total2=$total2+$orderTraffic->cusnum;
        }
         //北上結束
         
         //司機
        $busdata = DB::table('bus')         
         ->where('Date', $date) // 依日期篩選
         ->where('Type', 1) // 依日期篩選         
         ->select('BusId','Main','Number') // 取得需要的欄位，並格式化時間
         ->get(); // 返回一個資料集合
         
         
         
          //包車
        $charters = DB::table('ordertraffic')
        ->where('Date', 'like', "{$date}%") // 將變數 $date 拼接到字串中
         ->where('TrafficId',75) // 篩選 TrafficId         
         ->select('OrderId') 
         ->get(); // 返回一個資料集合
         
         
         
       //候補-南下 id=1
       $reserve1 = DB::table('ordertraffic')
       ->where('TrafficId', 1)
       ->where('Date', 'like', '%' . $date . '%')
       ->select('OrderId', 'cusnum', 'Date', 'TrafficId','Ps')
       ->get();  
         
       
       //候補-南下 id=7
       $reserve2 = DB::table('ordertraffic')
       ->where('TrafficId', 7)
       ->where('Date', 'like', '%' . $date . '%')
       ->select('OrderId', 'cusnum', 'Date', 'TrafficId','Ps')
       ->get();  
         
         
        // 返回視圖，並傳遞資料
        return view('longdistance.index', compact('date', 'results','carNumber','total','today_num', 'results2','total2','today_num2','busdata','charters','cusnumArray','reserve1'
                                        ,'reserve2'));
    }
    
    public function store(Request $request)
{
    // 獲取表單數據
    $data = $request->validate([
        'Number' => 'required|integer|min:1|max:10',
        'Main' => 'required|string|max:255',
        'date' => 'required|date',
    ]);

    // 新增到 bus 表
    DB::table('bus')->insert([
        'Date' => $data['date'],
        'Main' => $data['Main'],
        'Number' => $data['Number'],
        'Type' => 1, // 固定值
    ]);

    // 返回原頁面
    return redirect()->route('longdistance.index');
}

   public function update(Request $request, $id)
  {

    // 驗證請求資料
    $validated = $request->validate([
        'Number' => 'required|integer|min:1|max:10',
        'Main' => 'required|string|max:255',
    ]);

    // 更新 bus 表
     DB::table('bus')
        ->where('BusId', $id)
        ->update([
            'Number' => $request->input('Number'),
            'Main' => $request->input('Main'),
        ]);
        

    // 返回原頁面，附帶成功訊息
    return redirect()->route('longdistance.index');
   }


  public function destroy($id)
  {
    
    // 執行刪除
    DB::table('bus')->where('BusId', $id)->delete();

    // 返回原頁面並顯示成功訊息
    return redirect()->route('longdistance.index');
  }

    
    
}


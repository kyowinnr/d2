<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TicketController extends Controller
{
    // 步驟一
    public function index()
    {
     //常用業者
     $oftens = DB::table('often') ->get();

    return view('ticket.index1', compact('oftens'));
    
    }
    
    
    public function index2(Request $request)
    {
      // 接收表單提交的所有欄位
      $OrderId = $request->input('orderId');      
     $CusNum = $request->input('CusNum');
     
      //所有地區
       $locations = DB::table('location')
               ->where('Display', '=', 0) // 篩選 Display 等於 0 的資料
               ->get(); // 取得所有符合條件的資料

     //所有交通
       $traffics = DB::table('traffic')
               ->where('Display', '=', 0) // 篩選 Display 等於 0 的資料
               ->orderBy('TrafficType','ASC')
               ->get(); // 取得所有符合條件的資料 
      
      //交通資訊
       $ordertraffics = DB::table('ordertraffic')
               ->where('OrderId', $OrderId) // 根據 OrderId 篩選
               ->orderBy('Date','ASC')
               ->get(); // 取得所有符合條件的資料 
               
      // 查詢所有 aitem 資料作為下拉選單的選項
        $items = DB::table('aitem')->get();
        
      // 查詢 receivable 中的相關資料並連接 aitem 表來獲取 ItemName
       // 查詢 receivable 中的相關資料並連接 aitem 表來獲取 ItemName
        $receivables = DB::table('receivable')
            ->join('aitem', 'receivable.RItemId', '=', 'aitem.ItemId')
            ->where('receivable.OrderId', $OrderId)
            ->select('receivable.*', 'aitem.ItemName')
            ->get();                
       
      return view('ticket.index2',compact('OrderId','CusNum','locations','traffics','ordertraffics','items','receivables'));
     
    }
    
    
     public function store(Request $request)
    {
       $type=$request->input('type');
       
       if($type == "ordertraffic"){
          $OrderId = $request->input('OrderId');
          $Date = $request->input('Date');
          $LocationId = $request->input('location1');
          $LocationId2 = $request->input('location2');
          $TrafficId = $request->input('traffic');
          $Ps = $request->input('Ps');
          $cusnum = $request->input('cusnum');
          
           DB::table('ordertraffic')->insert([
            'OrderId' => $OrderId,
            'Date' => $Date,
            'LocationId' => $LocationId,
            'LocationId2' => $LocationId2,
            'TrafficId' => $TrafficId,
            'Ps' => $Ps,
            'cusnum' => $cusnum,
        ]);
           
       
       }elseif($type == "receivable"){
          $OrderId = $request->input('OrderId');
          $RItemId=$request->input('itemid');
          $price=$request->input('price');
          $number=$request->input('number');
          
          DB::table('receivable')->insert([
            'OrderId' => $OrderId,
            'RItemId' => $RItemId,
            'Price' => $price,
            'Number' => $number,
            'CusList' => "ALL",
        ]);
       
       }elseif($type == "customer"){  //寫入名冊
         $OrderId = $request->input('OrderId'); // 从隐藏字段或其他来源获取 OrderId
         $names = $request->input('Name');
         $birthdays = $request->input('Birthday');
         $ids = $request->input('ID');
         $sexes = $request->input('Sex');
         $phones = $request->input('Phone');
         $ps = $request->input('Ps');

         $data = [];
         foreach ($names as $index => $name) {
           $data[] = [
            'OrderId' => $OrderId,
            'Name' => $index === 0 ? ($name ?: '缺資料') : $name, // 第一個空白補"缺資料"
            'Birthday' => $birthdays[$index] ?? null,
            'ID' => $ids[$index] ?? null,
            'Sex' => $sexes[$index] ?? null,
            'Phone' => $phones[$index] ?? null,
            'Ps' => $ps[$index] ?? null,
            'TM' => $index === 0 ? 1 : 0, // 第一筆為1，其餘為0
           ];
        }  
       }
       
       return redirect()->back();
      }
      
      
      public function update(Request $request, $id)
     {
       $type=$request->input('type');
       
       if($type == "ordertraffic"){
         // 验证表单输入
           $validatedData = $request->validate([
                           'date' => 'required|date',
                           'LocationId' => 'required|integer',
                           'LocationId2' => 'required|integer',
                           'TrafficId' => 'required|integer',
                           'cusnum' => 'required|integer|min:1',
                           'Ps' => 'nullable|string',
           ]);
           
           // 更新数据库中的记录
            DB::table('ordertraffic')
                 ->where('OrderTrafficId', $id)
                 ->update([
                        'Date' => $validatedData['date'],
                        'LocationId' => $validatedData['LocationId'],
                        'LocationId2' => $validatedData['LocationId2'],
                        'TrafficId' => $validatedData['TrafficId'],
                        'cusnum' => $validatedData['cusnum'],
                        'Ps' => $validatedData['Ps'],
                  ]);

             // 更新成功，返回成功消息
              return redirect()->back();
       
       
       }
     }
     
       public function destroy(Request $request, $id)
      {
    
        $tableName=$request->input('tableName');
        $tableId=$request->input('tableId');
        // 删除记录
        DB::table($tableName)->where($tableId, $id)->delete();

        // 删除成功后返回成功消息
        return redirect()->back();
    
      

    
        
     }



}  




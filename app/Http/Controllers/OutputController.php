<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class OutputController extends Controller
{
    public function index(Request $request)
    {
        $trafficId = $request->get('traffic');
        $locationId = $request->get('location');
        $date = $request->get('date');
        $check = $request->get('check');

        // 設定其他 locationId
        if ($locationId == 29) {
            $locationId2 = 30; // 馬公港
            $locationId3 = 140; // 龍門港
        } elseif ($locationId == 30) {
            $locationId2 = 29; // 布袋港
            $locationId3 = 29;
        } elseif ($locationId == 140) {
            $locationId2 = 29; // 布袋港
            $locationId3 = 29;
        }
        
        //交通工具
        $traffic = DB::table('traffic') ->where('TrafficId', $trafficId)->first();
        

        // 查詢訂單
        $orders = DB::table('ordertraffic')
            ->join('traffic', 'ordertraffic.TrafficId', '=', 'traffic.TrafficId')
            ->join('location', 'ordertraffic.LocationId', '=', 'location.LocationId')
            ->select('ordertraffic.OrderId', 'traffic.TrafficName', 'ordertraffic.Date', 'location.LocationName')
            ->where('ordertraffic.TrafficId', $trafficId)
            ->where('ordertraffic.LocationId', $locationId)
            ->where('Date', 'LIKE', "{$date}%")
            ->orderBy('Date', 'ASC')
            ->get();

        $orderIdList = DB::table('ordertraffic')
            ->select('OrderId', 'CusList', 'Date')
            ->where('Date', 'LIKE', "{$date}%")
            ->where('LocationId', $locationId)
            ->where('TrafficId', $trafficId)
            ->orderBy('Date', 'ASC')
            ->get();
        
        // 顏色分配
        $groupColors = ['#FFDD55', '#FFFFFF'];
        $groupColorAssignments = [];
        $customers = [];
        $totalNum = 0;

        foreach ($orderIdList as $order) {
            // 查詢回程訂單日期
            $comebackDate = DB::table('ordertraffic')
                ->whereIn('LocationId', [$locationId2, $locationId3])
                ->where('OrderId', $order->OrderId)
                ->orderBy('Date', 'ASC')
                ->first();

            $comebackDate = $comebackDate ? $comebackDate->Date : '單趟';

            // 查詢客戶資料
            $customerList = [];
             $groupCount = 1;  // 分組編號
            if ($order->CusList == 'ALL') {
                $customersData = DB::table('customer')
                    ->where('OrderId', $order->OrderId)
                    ->where('Cancel', '!=', 1)
                    ->orderBy('Birthday', 'DESC')
                    ->get();
            } else {
                $cusIds = explode(',', $order->CusList);
                $customersData = DB::table('customer')
                    ->whereIn('CusId', $cusIds)
                    ->where('Cancel', '!=', 1)
                    ->orderBy('Birthday', 'DESC')
                    ->get();
            }

            // 如果這組沒有顏色，則分配新顏色
            if (!isset($groupColorAssignments[$order->OrderId])) {
                $groupColorAssignments[$order->OrderId] = $groupColors[count($groupColorAssignments) % count($groupColors)];
            }

            // 對每個客戶進行資料處理
            foreach ($customersData as $customer) {
                $customer->Sex = $customer->Sex == 1 ? '男' : ($customer->Sex == 2 ? '女' : '錯誤');
                $customer->TicketType = $this->getTicketType($customer->TicketType);
                $customer->Birthday = $this->formatBirthday($customer->Birthday);
                $customer->comebackDate = $comebackDate;
                $customer->totalNum = ++$totalNum;
                $customer->groupNum = $groupCount++; // 分組編號
                $customer->color = $groupColorAssignments[$order->OrderId]; // 使用已分配的顏色

                $customerList[] = $customer;
            }

            $customers[] = [
                'orderId' => $order->OrderId,
                'date' => $order->Date,
                'customerList' => $customerList,
                'comebackDate' => $comebackDate,
            ];
        }
 
         if($check==1){
           return view('output.index', compact('orders', 'customers', 'trafficId', 'locationId', 'date','traffic')); 
         }elseif($check==2){
           return view('output.index2', compact('orders', 'customers', 'trafficId', 'locationId', 'date','traffic'));
         }
        
    }

    private function getTicketType($ticketType)
    {
        switch ($ticketType) {
            case 1: return '兒童票';
            case 2: return '成人全票';
            case 3: return '敬老票';
            case 4: return '嬰幼票';
            case 5: return '殘障票';
            case 6: return '殘陪票';
            default: return '錯誤';
        }
    }

    private function formatBirthday($birthday)
    {
        if(empty($birthday)){
          $birthday="1911-00-00";
        }
        $year = substr($birthday, 0, 4) - 1911;
        return $year <= 0 ? '錯誤' : "{$year}." . substr($birthday, 5, 2) . "." . substr($birthday, 8, 2);
    }
}


@extends('layouts.app')
@push('styles')
    <style>
        /* 設置表格邊框為黑色 */
        .table-bordered th, .table-bordered td {
            border: 1px solid #5B5B5B; /* 設定黑色邊框 */
        }

        /* 可選：設置表格背景顏色 */
        .table th, .table td {
            padding: 8px; /* 設置內邊距，使內容不擁擠 */
            font-size:16px;
            font-weight:bold;
        }
    </style>
    
@endpush

@section('content')
<button type="button" id="copy-btn" class="btn btn-primary" style="margin-bottom: 20px;">
        轉檔圖片 直接LINE 貼上
    </button>
    <div class="container" id="capture-area">
        <a style="font-size:36px;font-family:標楷體">龍之嶺旅遊</a>
        
        <br>
        <table width="90%"  border="1" cellspacing="0" cellpadding="7"  style="font-size:16px; font-family:標楷體">
         <tr>
           <th colspan="6" align="left" style="font-size:24px">行程請款確認資料</th>
        </tr>
        <tr>
           <td colspan="6" align="left">訂位單位:{{ $moneys->OrderBuss}}&nbsp;&nbsp;&nbsp;訂單代號:{{$moneys->OrderId}}</td>
        </tr>
          <tr>
            <th align="left">旅客代表:{{ $customer->Name}}等{{ $moneys->CusNum}}人</th>
            <th align="left">聯絡電話:{{ $customer->Phone}}</th>
            <th align="left" colspan="4"></th>
          </tr>
          <tr>
            <td style="color:red;" align="center">時間</td>
            <td style="color:red;" align="center">出發地</td>
            <td style="color:red;" align="center">目的地</td>
            <td style="color:red;" align="center">交通工具</td>
            <td style="color:red;" align="center">人數</td>
            <td style="color:red;" align="center">資訊</td>
          </tr> 
          @foreach($ordertraffics as $ordertraffic)
          <tr style="text-align:center;">
            <td>{{$ordertraffic->Date}}</td>
            <td>{{$ordertraffic->StartLocation}}</td>
            <td>{{$ordertraffic->EndLocation}}</td>
            <td>{{$ordertraffic->TrafficName}}</td>
            <td>{{$ordertraffic->cusnum}}</td>
            <td>{{$ordertraffic->Ps}}</td>               
          </tr>
         @endforeach
          <!-- 應收款項表格 -->
          <tr style="background-color:#FF8EFF;"> 
            <td colspan="6">應收款項</td>
          </tr>
          <tr>
            <td colspan="2"></td>
            <td style="color:red;" align="left">品項</td>
            <td style="color:red;" align="right">單價</td>
            <td style="color:red;" align="right">數量</td>
            <td style="color:red;" align="right">小計</td>
          </tr> 
          @foreach ($receivables as $receivable)
           <tr>
            <td colspan="2"></td>
            <td>
             @foreach ($items as $itemId => $itemName)
              @if ($receivable->RItemId == $itemId)
               <span>{{ $itemName }}</span>
              @endif
             @endforeach
            </td>
            <td align="right">{{ $receivable->Price }}</td>
            <td align="right">{{ $receivable->Number }}</td>
            <td align="right">{{ $receivable->subtotal}}</td>
              @endforeach   
           </tr>
           <tr>
             <td colspan="5" align="right">應收款項小計</td>
             <td align="right">{{$total['rece']}}</td>
           </tr>
                <!-- 應扣款項表格 -->
           <tr style="background-color:#FF8EFF;"> 
             <td colspan="6">應扣款項</td>
           </tr>
              @foreach ($receivableoffs as $receivableoff)
           <tr>
             <td colspan="2"></td>
             <td>
              @foreach ($items as $itemId => $itemName)
              @if ($receivableoff->RItemId == $itemId)
               <span>{{ $itemName }}</span>
              @endif
              @endforeach                              
             </td>
             <td align="right">{{ $receivableoff->Price }}</td>
             <td align="right">{{ $receivableoff->Number }}</td>
             <td align="right">{{ $receivableoff->subtotal }}</td>
           </tr>
                @endforeach
           <tr>
             <td colspan="5" align="right">應扣款項小計</td>
             <td align="right">{{$total['receoff']}}</td>
           </tr>
           <tr style="background-color:yellow;">
             <td align="right" colspan="5">應收總團費合計</td>
             <td align="right">{{$total['all']}}</td>
           </tr>      
                <!-- 已收帳款表格 -->
           <tr style="background-color:#FF8EFF;"> 
             <td colspan="6">已收帳款</td>
           </tr>    
             @foreach ($okreces as $okrece)
           <tr>
             <td colspan="2"></td>
             <td>{{ $okrece->Date }}</td>
             <td colspan="2">{{ $okrece->Ps }}</td>
             <td align="right">{{ $okrece->Price }}</td>  
           </tr>
              @endforeach
            <tr bgcolor="yellow">
             <td colspan="5" align="right">已收帳款小計</td>
             <td align="right">{{$total['okrece']}}</td>
           </tr>
           <tr bgcolor="#A6FFA6">
             <td colspan="5" align="right">剩餘應收款</td>
             <td align="right">{{$total['end']}}</td>
           </tr>
           <tr>
             <td colspan="6">重要:請於{{ $moneys->DepositDate }}前付款訂金{{ $moneys->Deposit }}，已利作業，謝謝</td>
           </tr> 
           <tr>
             <th colspan="6">剩餘尾款請於{{ $moneys->FinalDate }}前付清，敬祝旅途愉快^^</th>
           </tr> 
           <tr style="font-size:14px">
             <th  align="left" style="vertical-align:top;font-size:18px">特別說明</th>
             <td align="left" colspan="5">
                 1.收到此『請款確認單』，請詳閱訂購行程與旅客等詳細核對是否有誤。<br>
                 2.請留意個別繳費期限，逾期視同放棄訂位
              </td>
           </tr>
           <tr>
             <th colspan="6">
               匯款帳號:<br>
               國泰世華銀行-文心分行(013)   帳號:2150-3500-9988  戶名:麗誠旅行社有限公司<br><br>
               匯款完成請來電告知以便快速完成帳款確認
             </th>
           </tr>
        </table>  
        
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    
   <script>
document.getElementById('copy-btn').addEventListener('click', async function() {
    const btn = this;
    const target = document.getElementById('capture-area');

    // 防止重複點擊
    btn.disabled = true;
    btn.innerText = '圖片生成中...';

    try {
        // Step 1: 將 HTML 元素轉為 Canvas 畫布
        const canvas = await html2canvas(target, {
            useCORS: true,      // 允許跨域圖片
            scale: 2,           // 提高清晰度 (2倍)
            backgroundColor: "#ffffff" // 確保背景不是透明的
        });

        // Step 2: 將 Canvas 轉成 Blob (二進位大物件)
        canvas.toBlob(async (blob) => {
            if (!blob) {
                alert('圖片轉換失敗');
                return;
            }

            try {
                // Step 3: 使用 Clipboard API 寫入剪貼簿
                // 這是關鍵，必須封裝在 ClipboardItem 內
                const data = [new ClipboardItem({ [blob.type]: blob })];
                await navigator.clipboard.write(data);
                
                alert('✅ 已成功複製！請切換到 LINE 按 Ctrl+V  貼上');
            } catch (err) {
                console.error('剪貼簿寫入錯誤:', err);
                alert('複製失敗！請確認您的網站是否為 HTTPS 環境。');
            }
        }, 'image/png');

    } catch (error) {
        console.error('發生錯誤:', error);
        alert('系統錯誤，請稍後再試');
    } finally {
        btn.disabled = false;
        btn.innerText = '轉檔圖片 直接 LINE貼上';
    }
});
</script>
@endsection



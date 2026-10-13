<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guestbook; // 確保你有這個模型
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GuestbookController extends Controller
{
    public function index(Request $request)
    {
    
        // 搜尋條件
        $query = Guestbook::query()->where('Type', 0); // 只顯示 Type 為 0 的資料
        
        if ($request->filled('content')) {
            $query->where('Main', 'like', '%' . $request->input('content') . '%');
        }

        if ($request->filled('starter')) {
            $query->where('Starter', 'like', '%' . $request->input('starter') . '%');
        }

        $guestbooks = $query->get(); // 獲取符合條件的資料

        return view('guestbook.index', compact('guestbooks'));
    }
    
    
    
    //新增
    public function store(Request $request)
    {
        // 驗證輸入資料
        $request->validate([
            'content' => 'required|string|max:255',
            'starter' => 'required|string|max:100',
        ]);

        // 將資料插入 guestbook 資料表
        DB::table('guestbook')->insert([
            'Main' => $request->input('content'),          // 交辦內容
            'Starter' => $request->input('starter'),       // 交辦人
            'S_Time' => Carbon::now(),                     // 記錄當前時間
            'Type' => 0                                    // 預設 type 為 0
        ]);

        // 重定向回 guestbook.index 頁面並顯示成功訊息
        return redirect()->route('guestbook.index');
    }
    
    // 刪除（將 type 設為 1）
    public function destroy($id)
    {
    
        // 更新 guestbook 資料表中的 type 欄位
        DB::table('guestbook')
            ->where('Gid', $id)
            ->update(['Type' => 1]);

        // 重定向回 guestbook.index 頁面並顯示成功訊息
        return redirect()->route('guestbook.index');
    }
    
     // 更新資料的方法
    public function update(Request $request, $id)
    {
        // 驗證輸入資料
        $request->validate([
            'content' => 'required|string',
            'starter' => 'required|string',
        ]);

        // 找到對應的 guestbook 資料
        $guestbook = Guestbook::findOrFail($id);

        // 更新資料
        $guestbook->update([
            'content' => $request->content,
            'starter' => $request->starter,
        ]);

        return redirect()->route('guestbook.index');
    }
    
}


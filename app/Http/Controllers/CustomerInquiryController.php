<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerInquiry;

class CustomerInquiryController extends Controller
{
    // 列表
    public function index()
    {
        $inquiries = CustomerInquiry::orderBy('id', 'desc')->get();
        return view('customer_inquiries.index', compact('inquiries'));
    }

    // 新增頁面
    public function create()
    {
        return view('customer_inquiries.create');
    }

    // 儲存資料
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'content' => 'required',
        ]);

        CustomerInquiry::create($request->all());

        return redirect()->route('customer_inquiries.index')
            ->with('success', '新增成功');
    }

    // 編輯頁面
    public function edit($id)
    {
        $inquiry = CustomerInquiry::findOrFail($id);
        return view('customer_inquiries.edit', compact('inquiry'));
    }

    // 更新
    public function update(Request $request, $id)
    {
        $inquiry = CustomerInquiry::findOrFail($id);

        $request->validate([
            'customer_name' => 'required',
            'content' => 'required',
        ]);

        $inquiry->update($request->all());

        return redirect()->route('customer_inquiries.index')
            ->with('success', '更新成功');
    }

    // 刪除
    public function destroy($id)
    {
        CustomerInquiry::destroy($id);

        return redirect()->route('customer_inquiries.index')
            ->with('success', '刪除成功');
    }
}
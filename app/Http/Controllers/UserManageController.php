<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManageController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'asc')->get();
        return view('usermanage.index', compact('users'));
    }

    public function create()
    {
        return view('usermanage.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'usercode'   => 'required|string|max:20|unique:users,usercode',
            'username'   => 'required|string|max:20',
            'phone'      => 'nullable|string|max:30',
            'permission' => 'required|integer|min:0|max:10',
            'password'   => 'required|string|min:4|confirmed',
        ]);

        User::create([
            'usercode'   => $request->usercode,
            'username'   => $request->username,
            'phone'      => $request->phone,
            'permission' => $request->permission,
            'password'   => Hash::make($request->password),
        ]);

        return redirect()->route('usermanage.index')->with('success', '使用者新增成功');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('usermanage.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'usercode'   => 'required|string|max:20|unique:users,usercode,' . $user->id,
            'username'   => 'required|string|max:20',
            'phone'      => 'nullable|string|max:30',
            'permission' => 'required|integer|min:0|max:10',
            'password'   => 'nullable|string|min:4|confirmed',
        ]);

        $data = [
            'usercode'   => $request->usercode,
            'username'   => $request->username,
            'phone'      => $request->phone,
            'permission' => $request->permission,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('usermanage.index')->with('success', '使用者資料更新成功');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (auth()->id() == $user->id) {
            return redirect()->route('usermanage.index')->with('error', '不可刪除目前登入中的帳號');
        }

        $user->delete();

        return redirect()->route('usermanage.index')->with('success', '使用者刪除成功');
    }
}
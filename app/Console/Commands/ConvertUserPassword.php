<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ConvertUserPassword extends Command
{
    protected $signature = 'user:convert-password';
    protected $description = '將舊 userpass 明碼轉為 bcrypt 存入 password 欄位';

    public function handle()
    {
        $users = User::all();
        $count = 0;

        foreach ($users as $user) {
            if (empty($user->password) && !empty($user->userpass)) {
                $user->password = Hash::make($user->userpass);
                $user->save();
                $count++;
            }
        }

        $this->info("完成轉換 {$count} 筆使用者密碼");
    }
}
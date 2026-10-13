<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('user') || !Schema::hasTable('users')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'usercode')) {
                $table->string('usercode', 20)->nullable()->after('id');
            }

            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username', 20)->nullable()->after('usercode');
            }

            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 30)->nullable()->after('username');
            }

            if (!Schema::hasColumn('users', 'permission')) {
                $table->tinyInteger('permission')->default(0)->after('phone');
            }
        });

        $oldUsers = DB::table('user')->get();

        foreach ($oldUsers as $oldUser) {
            $exists = DB::table('users')
                ->where('usercode', $oldUser->usercode)
                ->exists();

            if (!$exists) {
                DB::table('users')->insert([
                    'id' => $oldUser->userid,
                    'usercode' => $oldUser->usercode,
                    'username' => $oldUser->username,
                    'phone' => null,
                    'permission' => $oldUser->permission,
                    'password' => Hash::make($oldUser->userpass),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('users')) {
            return;
        }

        $oldUsers = DB::table('user')->pluck('usercode')->toArray();

        if (!empty($oldUsers)) {
            DB::table('users')->whereIn('usercode', $oldUsers)->delete();
        }
    }
};
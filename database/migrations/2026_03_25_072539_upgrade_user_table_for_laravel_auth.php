<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user', function (Blueprint $table) {
            if (!Schema::hasColumn('user', 'password')) {
                $table->string('password')->nullable()->after('userpass');
            }

            if (!Schema::hasColumn('user', 'remember_token')) {
                $table->rememberToken();
            }

            if (!Schema::hasColumn('user', 'created_at')) {
                $table->timestamp('created_at')->nullable();
            }

            if (!Schema::hasColumn('user', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }
        });

        DB::table('user')
            ->whereNull('created_at')
            ->update([
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $columns = [];

            if (Schema::hasColumn('user', 'password')) {
                $columns[] = 'password';
            }

            if (Schema::hasColumn('user', 'remember_token')) {
                $columns[] = 'remember_token';
            }

            if (Schema::hasColumn('user', 'created_at')) {
                $columns[] = 'created_at';
            }

            if (Schema::hasColumn('user', 'updated_at')) {
                $columns[] = 'updated_at';
            }

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
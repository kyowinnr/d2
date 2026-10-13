<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('user')) {
            return;
        }

        if (Schema::hasTable('users')) {
            Schema::drop('users');
        }

        Schema::rename('user', 'users');

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'userid')) {
                $table->renameColumn('userid', 'id');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable()->after('remember_token');
            }
        });

        $indexes = DB::select("SHOW INDEX FROM users WHERE Key_name = 'users_usercode_unique'");
        if (empty($indexes) && Schema::hasColumn('users', 'usercode')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unique('usercode');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('users')) {
            return;
        }

        $indexes = DB::select("SHOW INDEX FROM users WHERE Key_name = 'users_usercode_unique'");
        if (!empty($indexes)) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropUnique('users_usercode_unique');
            });
        }

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'email_verified_at')) {
                $table->dropColumn('email_verified_at');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'id')) {
                $table->renameColumn('id', 'userid');
            }
        });

        if (!Schema::hasTable('user')) {
            Schema::rename('users', 'user');
        }
    }
};
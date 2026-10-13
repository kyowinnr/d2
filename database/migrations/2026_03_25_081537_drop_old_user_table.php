<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('user')) {
            Schema::drop('user');
        }
    }

    public function down(): void
    {
        //
    }
};
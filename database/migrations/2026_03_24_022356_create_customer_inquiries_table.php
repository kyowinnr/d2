<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name')->comment('客戶名稱');
            $table->text('content')->comment('詢問內容');
            $table->string('phone', 30)->nullable()->comment('聯絡電話');
            $table->string('salesperson', 100)->nullable()->comment('報價業務人員');
            $table->date('inquiry_date')->nullable()->comment('詢問日期');
            $table->text('note')->nullable()->comment('備註');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_inquiries');
    }
};
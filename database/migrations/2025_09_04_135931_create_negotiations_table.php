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
        Schema::create('negotiations', function (Blueprint $table) {
            $table->bigIncrements('negotiation_id');
            $table->unsignedBigInteger('customer_id')->nullable()->comment('顧客ID');
            $table->unsignedBigInteger('status_id')->comment('ステータスID');
            $table->string('title', 255)->default('')->comment('商談タイトル');
            $table->text('description')->nullable()->comment('商談詳細');
            $table->unsignedBigInteger('amount')->default(0)->comment('商談金額');
            $table->dateTime('scheduled_date')->comment('予定日時)');
            $table->dateTime('created_at')->comment('作成日時');
            $table->dateTime('updated_at')->comment('更新日時');
            $table->foreign('customer_id')->references('customer_id')->on('customers')->nullOnDelete();
            $table->foreign('status_id')->references('negotiation_status_id')->on('negotiation_statuses')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('negotiations');
    }
};

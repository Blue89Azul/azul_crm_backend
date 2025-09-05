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
        Schema::create('negotiation_statuses', function (Blueprint $table) {
            $table->bigIncrements('negotiation_status_id');
            $table->unsignedBigInteger('negotiation_status_group_id')->comment('ステータスグループID');
            $table->string('status_name', 100)->comment('ステータス名');
            $table->unsignedInteger('sort_order')->default(0)->comment('表示順序');
            $table->unsignedInteger('created_at')->comment('作成日時(UNIX timestamp)');
            $table->unsignedInteger('updated_at')->comment('更新日時(UNIX timestamp)');
            $table->foreign('negotiation_status_group_id')->references('negotiation_status_group_id')->on('negotiation_status_groups')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('negotiation_statuses');
    }
};

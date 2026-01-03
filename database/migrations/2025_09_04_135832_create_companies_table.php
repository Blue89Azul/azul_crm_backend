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
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('company_id');
            $table->string('name', 255)->default('')->comment('会社名');
            $table->unsignedInteger('employees')->default(0)->comment('従業員数');
            $table->unsignedBigInteger('revenue')->default(0)->comment('売上高');
            $table->unsignedBigInteger('address_id')->nullable()->comment('住所ID');
            $table->dateTime('created_at')->comment('作成日時(UNIX timestamp)');
            $table->dateTime('updated_at')->comment('更新日時(UNIX timestamp)');
            $table->foreign('address_id')->references('address_id')->on('addresses')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};

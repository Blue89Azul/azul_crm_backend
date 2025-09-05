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
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('customer_id');
            $table->string('name_last', 100)->default('')->comment('姓');
            $table->string('name_first', 100)->default('')->comment('名');
            $table->string('email', 255)->default('')->comment('メールアドレス');
            $table->unsignedBigInteger('company_id')->default(0)->comment('会社ID');
            $table->unsignedBigInteger('address_id')->nullable()->comment('住所ID');
            $table->string('title', 100)->default('')->comment('役職');
            $table->unsignedInteger('created_at')->comment('作成日時(UNIX timestamp)');
            $table->unsignedInteger('updated_at')->comment('更新日時(UNIX timestamp)');
            $table->foreign('company_id')->references('company_id')->on('companies')->restrictOnDelete();
            $table->foreign('address_id')->references('address_id')->on('addresses')->nullOnDelete();
            $table->index('company_id', 'idx_company_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};

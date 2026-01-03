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
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('address_id');
            $table->char('country_code', 2)->comment('ISO 3166-1 alpha-2 国コード');
            $table->string('postal_code', 20)->nullable()->comment('郵便番号');
            $table->string('state_province', 100)->nullable()->comment('都道府県/州');
            $table->string('city', 100)->comment('市区町村');
            $table->string('street_address', 255)->comment('住所1（番地、建物名等）');
            $table->string('building', 255)->nullable()->comment('住所2（部屋番号等）');
            $table->dateTime('created_at')->comment('作成日時');
            $table->dateTime('updated_at')->comment('更新日時');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};

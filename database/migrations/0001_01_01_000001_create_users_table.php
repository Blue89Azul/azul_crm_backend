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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name_last', 128)->default('')->comment('姓');
            $table->string('name_first', 128)->default('')->comment('名');
            $table->string('email', 255)->default('')->unique()->comment('メールアドレス');
            $table->string('password', 255)->comment('パスワード');
            $table->unsignedBigInteger('user_role_id')->nullable()->comment('ユーザーロールID');
            $table->integer('created_at')->unsigned()->comment('作成日時(UNIX timestamp)');
            $table->integer('updated_at')->unsigned()->comment('更新日時(UNIX timestamp)');
            $table->integer('loggedin_at')->unsigned()->comment('最終ログイン日時(UNIX timestamp)');
            $table->foreign('user_role_id')->references('id')->on('user_roles')->nullOnDelete();
        });

        // Schema::create('password_reset_tokens', function (Blueprint $table) {
        //     $table->string('email')->primary();
        //     $table->string('token');
        //     $table->timestamp('created_at')->nullable();
        // });

        // Schema::create('sessions', function (Blueprint $table) {
        //     $table->string('id')->primary();
        //     $table->foreignId('user_id')->nullable()->index();
        //     $table->string('ip_address', 45)->nullable();
        //     $table->text('user_agent')->nullable();
        //     $table->longText('payload');
        //     $table->integer('last_activity')->index();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};

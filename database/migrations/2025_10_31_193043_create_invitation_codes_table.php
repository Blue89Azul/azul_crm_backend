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
        Schema::create('invitation_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code', 24)->unique()->comment('招待コード');
            $table->foreignId('role_id')->nullable()->constrained('user_roles')->nullOnDelete();
            $table->foreignId('organization_id')->nullable()->constrained('user_organizations')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('redeemed_at')->nullable()->comment('招待コードが使用（償却）された日時');
            $table->dateTime('expires_at')->nullable()->comment('有効期限');
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitation_codes');
    }
};

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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('bank_account_currency', 3)->nullable()->after('payment_method');
            $table->timestamp('payment_submitted_at')->nullable()->after('paid_at');
            $table->index('payment_submitted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['payment_submitted_at']);
            $table->dropColumn(['bank_account_currency', 'payment_submitted_at']);
        });
    }
};

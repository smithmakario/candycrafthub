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
        Schema::table('products', function (Blueprint $table) {
            $table->text('taste_profile')->nullable()->after('description');
            $table->text('memory_quote')->nullable()->after('taste_profile');
            $table->string('badge')->nullable()->after('memory_quote');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['taste_profile', 'memory_quote', 'badge']);
        });
    }
};

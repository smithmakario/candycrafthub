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
        Schema::create('event_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tagline')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('price_label')->nullable();
            $table->string('price_interval')->default('event');
            $table->json('features');
            $table->boolean('is_featured')->default(false);
            $table->string('badge_text')->nullable();
            $table->string('button_text')->default('Get a Quote');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_packages');
    }
};

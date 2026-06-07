<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('category_id')
                ->nullable()
                ->after('origin')
                ->constrained()
                ->nullOnDelete();
        });

        $categoryNames = DB::table('products')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        foreach ($categoryNames as $index => $name) {
            $slug = Str::slug($name);
            $baseSlug = $slug;
            $suffix = 1;

            while (Category::query()->where('slug', $slug)->exists()) {
                $slug = $baseSlug.'-'.$suffix;
                $suffix++;
            }

            $category = Category::query()->create([
                'name' => $name,
                'slug' => $slug,
                'sort_order' => $index,
                'is_active' => true,
            ]);

            DB::table('products')
                ->where('category', $name)
                ->update(['category_id' => $category->id]);
        }

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('category')->nullable()->after('origin');
        });

        $products = DB::table('products')
            ->whereNotNull('category_id')
            ->get(['id', 'category_id']);

        foreach ($products as $product) {
            $categoryName = Category::query()->whereKey($product->category_id)->value('name');

            if ($categoryName !== null) {
                DB::table('products')
                    ->where('id', $product->id)
                    ->update(['category' => $categoryName]);
            }
        }

        Schema::table('products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
        });
    }
};

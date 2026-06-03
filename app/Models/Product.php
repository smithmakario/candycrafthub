<?php

namespace App\Models;

use App\ProductOrigin;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'sku',
        'description',
        'taste_profile',
        'memory_quote',
        'badge',
        'image_path',
        'origin',
        'category',
        'unit_price',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'origin' => ProductOrigin::class,
            'unit_price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    /**
     * @return HasOne<InventoryItem, $this>
     */
    public function inventoryItem(): HasOne
    {
        return $this->hasOne(InventoryItem::class);
    }

    /**
     * @return HasMany<OrderItem, $this>
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function formattedPrice(): string
    {
        return '₦'.number_format((float) $this->unit_price, 0);
    }

    /**
     * @param  Builder<Product>  $query
     * @return Builder<Product>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * @param  Builder<Product>  $query
     * @return Builder<Product>
     */
    public function scopeOrigin(Builder $query, ?ProductOrigin $origin): Builder
    {
        if ($origin === null) {
            return $query;
        }

        return $query->where('origin', $origin);
    }

    /**
     * Get the public URL for the product image.
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::get(function (): ?string {
            if (! $this->image_path) {
                return null;
            }

            if (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://')) {
                return $this->image_path;
            }

            return Storage::disk('public')->url($this->image_path);
        });
    }
}

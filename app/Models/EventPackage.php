<?php

namespace App\Models;

use Database\Factories\EventPackageFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventPackage extends Model
{
    /** @use HasFactory<EventPackageFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'tagline',
        'price',
        'price_label',
        'price_interval',
        'features',
        'is_featured',
        'badge_text',
        'button_text',
        'sort_order',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'features' => 'array',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * @param  Builder<EventPackage>  $query
     * @return Builder<EventPackage>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * @param  Builder<EventPackage>  $query
     * @return Builder<EventPackage>
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function hasCustomPricing(): bool
    {
        return $this->price === null;
    }

    public function formattedPrice(): string
    {
        if ($this->hasCustomPricing()) {
            return $this->price_label ?? 'Custom';
        }

        return '₦'.number_format((float) $this->price, 0);
    }
}

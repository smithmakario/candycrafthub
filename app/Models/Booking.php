<?php

namespace App\Models;

use App\BookingStatus;
use App\EventType;
use Database\Factories\BookingFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    /** @use HasFactory<BookingFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'event_type',
        'status',
        'event_date',
        'guest_count',
        'theme_color',
        'customer_name',
        'customer_email',
        'customer_phone',
        'notes',
        'progress',
        'is_priority',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'event_type' => EventType::class,
            'status' => BookingStatus::class,
            'event_date' => 'date',
            'guest_count' => 'integer',
            'progress' => 'integer',
            'is_priority' => 'boolean',
        ];
    }

    public function isActive(): bool
    {
        return $this->status !== BookingStatus::Completed;
    }

    /**
     * @param  Builder<Booking>  $query
     * @return Builder<Booking>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', '!=', BookingStatus::Completed);
    }

    /**
     * @param  Builder<Booking>  $query
     * @return Builder<Booking>
     */
    public function scopeStatus(Builder $query, BookingStatus $status): Builder
    {
        return $query->where('status', $status);
    }
}

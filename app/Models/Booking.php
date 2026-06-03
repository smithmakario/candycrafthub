<?php

namespace App\Models;

use App\BookingStatus;
use App\EventType;
use Database\Factories\BookingFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    /** @use HasFactory<BookingFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
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
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param  Builder<Booking>  $query
     * @return Builder<Booking>
     */
    public function scopeForCustomer(Builder $query, User $user): Builder
    {
        return $query->where(function (Builder $query) use ($user): void {
            $query->where('user_id', $user->id)
                ->orWhere('customer_email', $user->email);
        });
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

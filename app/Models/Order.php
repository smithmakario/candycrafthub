<?php

namespace App\Models;

use App\FulfillmentType;
use App\OrderStatus;
use App\PaymentMethod;
use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    /** @use HasFactory<OrderFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'email',
        'fulfillment_type',
        'delivery_address',
        'reference',
        'payment_method',
        'bank_account_currency',
        'paystack_reference',
        'status',
        'total_amount',
        'currency',
        'paid_at',
        'payment_submitted_at',
        'payment_metadata',
    ];

    protected $attributes = [
        'payment_method' => PaymentMethod::Paystack,
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fulfillment_type' => FulfillmentType::class,
            'payment_method' => PaymentMethod::class,
            'status' => OrderStatus::class,
            'total_amount' => 'decimal:2',
            'paid_at' => 'datetime',
            'payment_submitted_at' => 'datetime',
            'payment_metadata' => 'array',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany<OrderItem, $this>
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function isPaid(): bool
    {
        return $this->status === OrderStatus::Paid;
    }

    public function isBankTransfer(): bool
    {
        return $this->payment_method === PaymentMethod::BankTransfer;
    }

    public function hasSubmittedPayment(): bool
    {
        return $this->payment_submitted_at !== null;
    }

    public function isPendingApproval(): bool
    {
        return $this->status === OrderStatus::Pending
            && $this->isBankTransfer()
            && $this->hasSubmittedPayment();
    }

    /**
     * @return array{currency: string, label: string, number: string}|null
     */
    public function paidToBankAccount(): ?array
    {
        if ($this->bank_account_currency === null) {
            return null;
        }

        foreach (config('bank.accounts') as $account) {
            if ($account['currency'] === $this->bank_account_currency) {
                return $account;
            }
        }

        return null;
    }

    public function paidToBankAccountLabel(): ?string
    {
        $account = $this->paidToBankAccount();

        if ($account === null) {
            return null;
        }

        return "{$account['label']} ({$account['number']})";
    }

    public function statusLabel(): string
    {
        if ($this->isPendingApproval()) {
            return 'Pending approval';
        }

        if ($this->status === OrderStatus::Pending && $this->isBankTransfer()) {
            return 'Awaiting bank transfer';
        }

        return $this->status->label();
    }

    /**
     * @param  Builder<Order>  $query
     * @return Builder<Order>
     */
    public function scopePendingApproval(Builder $query): Builder
    {
        return $query
            ->where('payment_method', PaymentMethod::BankTransfer)
            ->where('status', OrderStatus::Pending)
            ->whereNotNull('payment_submitted_at');
    }

    public static function generateReference(): string
    {
        return 'CCH_'.Str::upper(Str::random(16));
    }

    public function amountInKobo(): int
    {
        return (int) round((float) $this->total_amount * 100);
    }

    /**
     * @param  Builder<Order>  $query
     * @return Builder<Order>
     */
    public function scopeForCustomer(Builder $query, User $user): Builder
    {
        return $query->where(function (Builder $query) use ($user): void {
            $query->where('user_id', $user->id)
                ->orWhere('email', $user->email);
        });
    }
}

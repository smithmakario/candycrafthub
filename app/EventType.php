<?php

namespace App;

enum EventType: string
{
    case Wedding = 'wedding';
    case Corporate = 'corporate';
    case Birthday = 'birthday';
    case Retirement = 'retirement';
    case LuxuryGift = 'luxury_gift';

    public function label(): string
    {
        return match ($this) {
            self::Wedding => 'Wedding',
            self::Corporate => 'Corporate',
            self::Birthday => 'Birthday',
            self::Retirement => 'Retirement',
            self::LuxuryGift => 'Luxury Gift',
        };
    }

    public function colorClass(): string
    {
        return match ($this) {
            self::Wedding => 'text-primary',
            self::Corporate => 'text-primary',
            self::Birthday => 'text-secondary',
            self::Retirement => 'text-tertiary',
            self::LuxuryGift => 'text-primary',
        };
    }
}

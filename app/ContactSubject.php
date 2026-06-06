<?php

namespace App;

enum ContactSubject: string
{
    case GeneralInquiry = 'general_inquiry';
    case EventBooking = 'event_booking';
    case OrderSupport = 'order_support';
    case Wholesale = 'wholesale';

    public function label(): string
    {
        return match ($this) {
            self::GeneralInquiry => 'General Inquiry',
            self::EventBooking => 'Event Booking',
            self::OrderSupport => 'Order Support',
            self::Wholesale => 'Wholesale',
        };
    }
}

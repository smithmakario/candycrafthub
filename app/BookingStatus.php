<?php

namespace App;

enum BookingStatus: string
{
    case InquiryReceived = 'inquiry_received';
    case Planning = 'planning';
    case InProduction = 'in_production';
    case Completed = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::InquiryReceived => 'Inquiry Received',
            self::Planning => 'Planning',
            self::InProduction => 'In Production',
            self::Completed => 'Completed',
        };
    }

    public function dotColorClass(): string
    {
        return match ($this) {
            self::InquiryReceived => 'bg-outline',
            self::Planning => 'bg-secondary',
            self::InProduction => 'bg-primary',
            self::Completed => 'bg-tertiary',
        };
    }

    /**
     * @return list<self>
     */
    public static function pipelineOrder(): array
    {
        return [
            self::InquiryReceived,
            self::Planning,
            self::InProduction,
            self::Completed,
        ];
    }
}

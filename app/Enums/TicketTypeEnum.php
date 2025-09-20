<?php

namespace App\Enums;

enum TicketTypeEnum: string
{
    case ONE_WAY = 'one_way';
    case ROUND_TRIP = 'round_trip';

    public function label(): string
    {
        return match ($this) {
            self::ONE_WAY => 'ذهاب فقط',
            self::ROUND_TRIP => 'ذهاب وعودة',
        };
    }
    public static function toArray(): array
    {
        return array_map(fn($case) => [
            'value' => $case->value,
            'label' => $case->label(),
        ], self::cases());
    }
}

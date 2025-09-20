<?php

namespace App\Enums;

enum ClassTypeEnum: string
{
    case ECONOMY = 'economy';
    case BUSINESS = 'business';
    case FIRST = 'first';

    public function label(): string
    {

        return match ($this) {
            self::ECONOMY => 'اقتصادية',
            self::BUSINESS => 'رجال أعمال',
            self::FIRST => 'أولى',
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

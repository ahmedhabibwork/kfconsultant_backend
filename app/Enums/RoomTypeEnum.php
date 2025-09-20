<?php

namespace App\Enums;

enum RoomTypeEnum: string
{
    case Single = 'single';
    case Double = 'double';
    case Suite  = 'suite';


    public function label(): string
    {
        return match ($this) {
            self::Single => __('Single Room'),
            self::Double => __('Double Room'),
            self::Suite  => __('Suite'),
        };
    }
    public function color(): string
    {
        return match ($this) {
            self::Single => 'success',
            self::Double => 'warning',
            self::Suite  => 'danger',
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

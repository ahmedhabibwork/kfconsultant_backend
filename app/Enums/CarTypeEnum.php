<?php

namespace App\Enums;

enum CarTypeEnum: string
{
    case MiniBus = "mini_bus";
    case BigBus = "big_bus";
    case PrivateCar = "private_car";


    public function label(): string
    {
        return match ($this) {
            self::MiniBus => __('Mini Bus'),
            self::BigBus => __('Big Bus'),
            self::PrivateCar => __('Private Car'),
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

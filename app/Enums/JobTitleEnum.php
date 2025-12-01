<?php

namespace App\Enums;

enum JobTitleEnum: string
{
    case ArchitectEngineer = 'Architect Engineer';
    case StructuralEngineer = 'Structural Engineer';
    case CivilEngineer = 'Civil Engineer';


    public function label(): string
    {
        return match ($this) {
            self::ArchitectEngineer => __('Architect Engineer'),
            self::StructuralEngineer => __('Structural Engineer'),
            self::CivilEngineer => __('Civil Engineer'),
        };
    }
}

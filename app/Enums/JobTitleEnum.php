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
            self::ArchitectEngineer => 'Architect Engineer',
            self::StructuralEngineer => 'Structural Engineer',
            self::CivilEngineer => 'Civil Engineer',
        };
    }
}

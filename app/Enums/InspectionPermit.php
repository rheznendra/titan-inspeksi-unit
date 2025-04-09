<?php

namespace App\Enums;

enum InspectionPermit: string
{
    case REQUIREMENT_MET = 'requirement_met';
    case OPERATIONAL_PERMIT = 'operational_permit';
    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::REQUIREMENT_MET => 'Diijinkan dan telah memenuhi persyaratan',
            self::OPERATIONAL_PERMIT => 'Tidak diijinkan untuk dioperasikan',
            self::OTHER => 'Lainnya',
        };
    }

    public function hasNote(): bool
    {
        return match ($this) {
            self::REQUIREMENT_MET => false,
            default => true
        };
    }

    public function toArray(): array
    {
        return [
            'value' => $this->name,
            'label' => $this->label(),
        ];
    }
}

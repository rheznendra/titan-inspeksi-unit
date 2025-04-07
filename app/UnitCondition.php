<?php

namespace App;

enum UnitCondition
{
    case GOOD;
    case BAD;

    public function toString(): string
    {
        return match ($this) {
            self::GOOD => 'baik',
            self::BAD => 'buruk',
        };
    }

    public static function fromString(string $value): self
    {
        return match ($value) {
            'baik' => self::GOOD,
            'buruk' => self::BAD,
        };
    }

    public function toArray(): array
    {
        return [
            'value' => $this->toString(),
            'label' => $this->toString(),
        ];
    }
}

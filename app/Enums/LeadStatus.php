<?php

namespace App\Enums;

enum LeadStatus: string
{
    case Hot = 'hot';
    case Medium = 'medium';
    case Cold = 'cold';

    public static function fromScore(int $score): self
    {
        if ($score > 75) {
            return self::Hot;
        }

        if ($score >= 40) {
            return self::Medium;
        }

        return self::Cold;
    }
}

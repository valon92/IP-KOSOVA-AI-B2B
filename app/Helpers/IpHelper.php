<?php

namespace App\Helpers;

class IpHelper
{
    public static function toLong(string $ip): int
    {
        $packed = @inet_pton($ip);

        if ($packed === false || strlen($packed) !== 4) {
            return 0;
        }

        $unpacked = unpack('N', $packed);

        return $unpacked[1] ?? 0;
    }

    public static function isInRange(string $ip, int $rangeStart, int $rangeEnd): bool
    {
        $long = self::toLong($ip);

        return $long >= $rangeStart && $long <= $rangeEnd;
    }
}

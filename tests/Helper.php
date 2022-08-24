<?php
declare(strict_types=1);

namespace Tests;

final class Helper
{
    public static function unset(array $data, array $keys): array
    {
        return array_filter(
            $data,
            fn ($k) => !in_array($k, $keys),
            ARRAY_FILTER_USE_KEY
        );
    }

    public static function replace(array $data, array $newData): array
    {
        return array_merge($data, $newData);
    }
}

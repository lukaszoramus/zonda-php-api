<?php

declare(strict_types=1);

namespace ZondaPhpApi\HttpClient\Util;

final class JsonArray
{
    public static function decode(string $json)
    {
        return json_decode($json, true);
    }
}

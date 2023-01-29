<?php

declare(strict_types=1);

namespace ZondaPhpApi\HttpClient\Util;

final class HttpQueryBuilder
{
    public static function build(array $query = []): ?string
    {
        $getQuery = http_build_query($query);
        return $getQuery ? '?' . $getQuery : null;
    }
}

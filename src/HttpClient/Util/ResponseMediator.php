<?php

declare(strict_types=1);

namespace ZondaPhpApi\HttpClient\Util;

use Psr\Http\Message\ResponseInterface;
use ZondaPhpApi\HttpClient\Enum\ContentType;
use ZondaPhpApi\HttpClient\Enum\Header;

final class ResponseMediator
{
    public static function getContents(ResponseInterface $response)
    {
        $content = $response->getBody()->getContents();

        if (0 === strlen($content)) {
            return $content;
        }

        if (str_contains($response->getHeaderLine(Header::CONTENT_TYPE->value), ContentType::JSON->value)) {
            return json_decode($content, true);
        }

        return $content;
    }
}

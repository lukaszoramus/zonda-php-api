<?php

declare(strict_types=1);

namespace ZondaPhpApi\Api;

use Psr\Http\Message\ResponseInterface;
use ZondaPhpApi\Client;
use ZondaPhpApi\HttpClient\Util\HttpQueryBuilder;
use ZondaPhpApi\HttpClient\Util\ResponseMediator;

abstract class AbstractApi
{
    private const URI_PREFIX = '/rest/';
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    protected function getAsResponse(
        string $uri,
        array $params = [],
        array $query = [],
        array $headers = []
    ): ResponseInterface {
        return $this->client->getHttpClient()->get(self::prepareUri($uri, $params, $query), $headers);
    }

    protected function get(string $uri, array $params = [], array $query = [], array $headers = [])
    {
        $response = $this->getAsResponse($uri, $params, $query, $headers);
        return ResponseMediator::getContents($response);
    }

    protected static function prepareUri(string $uri, array $params = [], array $query = []): string
    {
        $concatUri = sprintf('%s%s', self::URI_PREFIX, $uri) . implode('/', $params);
        $trimmed = rtrim($concatUri, '/');
        return $trimmed . HttpQueryBuilder::build($query);
    }
}

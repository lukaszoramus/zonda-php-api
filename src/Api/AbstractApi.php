<?php

declare(strict_types=1);

namespace ZondaPhpApi\Api;

use ZondaPhpApi\Client;
use ZondaPhpApi\HttpClient\Util\HttpQueryBuilder;
use ZondaPhpApi\HttpClient\Util\JsonArray;
use ZondaPhpApi\HttpClient\Util\ResponseMediator;

abstract class AbstractApi
{
    private const URI_PREFIX = '/rest/';
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    protected function get(string $uri, array $params = [], array $query = [], array $headers = [])
    {
        $response = $this->client->getHttpClient()->get(self::prepareUri($uri, $params, $query), $headers);

        return ResponseMediator::getContent($response);
    }

    protected function post(string $uri, array $params = [], array $data = [], array $query = [], array $headers = [])
    {
        $response = $this->client->getHttpClient()->post(
            self::prepareUri($uri, $params, $query),
            $headers,
            self::prepareJsonBody($data)
        );

        return ResponseMediator::getContent($response);
    }

    protected function delete(string $uri, array $params = [], array $data = [], array $query = [], array $headers = [])
    {
        $response = $this->client->getHttpClient()->delete(
            self::prepareUri($uri, $params, $query),
            $headers,
            self::prepareJsonBody($data)
        );

        return ResponseMediator::getContent($response);
    }

    private static function prepareUri(string $uri, array $params = [], array $query = []): string
    {
        $concatUri = sprintf('%s%s', self::URI_PREFIX, $uri) . implode('/', $params);
        $trimmed = rtrim($concatUri, '/');

        return $trimmed . HttpQueryBuilder::build($query);
    }

    private function prepareJsonBody(array $data): ?string
    {
        if (empty($data)) {
            return null;
        }

        return JsonArray::encode($data);
    }
}

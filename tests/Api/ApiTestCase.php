<?php

namespace ZondaPhpApi\Tests\Api;

use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use ZondaPhpApi\Client;

abstract class ApiTestCase extends TestCase
{
    protected const METHODS = ['getAsResponse', 'get'];

    protected function getApiMock(): object
    {
        $httpClient = $this->getMockBuilder(ClientInterface::class)
            ->onlyMethods(['sendRequest'])
            ->getMock();
        $httpClient
            ->expects($this->any())
            ->method('sendRequest');

        $client = Client::createWithHttpClient($httpClient);

        return $this->getMockBuilder($this->getApiClass())
            ->onlyMethods(self::METHODS)
            ->setConstructorArgs([$client, null])
            ->getMock();
    }

    abstract protected function getApiClass(): string;
}

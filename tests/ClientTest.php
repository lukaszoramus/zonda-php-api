<?php

declare(strict_types=1);

namespace ZondaPhpApi\Tests;

use Http\Client\Common\HttpMethodsClient;
use PHPUnit\Framework\TestCase;
use ZondaPhpApi\Client;

/**
 * @covers \ZondaPhpApi\Client
 */
class ClientTest extends TestCase
{
    public function testCreateClient(): void
    {
        $client = new Client();

        $this->assertInstanceOf(Client::class, $client);
        $this->assertInstanceOf(HttpMethodsClient::class, $client->getHttpClient());
    }
}

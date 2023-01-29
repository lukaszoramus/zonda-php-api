<?php

declare(strict_types=1);

use Http\Client\Common\HttpMethodsClient;
use PHPUnit\Framework\TestCase;
use ZondaPhpApi\Client;

class ClientTest extends TestCase
{
    public function testCreateClient(): void
    {
        $client = new Client();

        $this->assertInstanceOf(Client::class, $client);
        $this->assertInstanceOf(HttpMethodsClient::class, $client->getHttpClient());
    }
}

<?php

declare(strict_types=1);

namespace ZondaPhpApi\Tests\HttpClient\Util;


use PHPUnit\Framework\TestCase;
use ZondaPhpApi\HttpClient\Util\JsonArray;

class JsonArrayTest extends TestCase
{
    /**
     * @test
     */
    public function shouldDecodeJson(): void
    {
        $expected = ['status' => 'OK'];
        $jsonString = '{"status": "OK"}';

        $this->assertEquals($expected, JsonArray::decode($jsonString));
    }
}

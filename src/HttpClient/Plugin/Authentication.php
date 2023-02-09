<?php

declare(strict_types=1);

namespace ZondaPhpApi\HttpClient\Plugin;

use Http\Message\Authentication\Header;
use Psr\Http\Message\RequestInterface;

final class Authentication implements \Http\Message\Authentication
{
    private string $publicApiKey;
    private string $privateApiKey;

    public function __construct(string $publicApiKey, string $privateApiKey)
    {
        $this->publicApiKey = $publicApiKey;
        $this->privateApiKey = $privateApiKey;
    }

    public function authenticate(RequestInterface $request): RequestInterface
    {
        foreach ($this->buildAuthHeaders($request) as $header) {
            $request = $header->authenticate($request);
        }

        return $request;
    }

    private function buildAuthHeaders(RequestInterface $request): array
    {
        $content = null;
        if (in_array($request->getMethod(), ['POST', 'PUT', 'DELETE'])) {
            $content = $request->getBody()->getContents();
        }

        $time = (string) time();

        return [
            new Header('API-Key', $this->publicApiKey),
            new Header(
                'API-Hash',
                hash_hmac('sha512', $this->publicApiKey . $time . $content, $this->privateApiKey)
            ),
            new Header('operation-id', $this->getUUID()),
            new Header('Request-Timestamp', $time),
        ];
    }

    private function getUUID(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0F | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3F | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}

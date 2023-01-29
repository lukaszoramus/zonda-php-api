<?php

declare(strict_types=1);

namespace ZondaPhpApi\Api;

class Trading extends AbstractApi
{
    private const URI_PREFIX = 'trading/';

    public function ticker(?string $tradingPair): array
    {
        return $this->get(self::URI_PREFIX . 'ticker/', [$tradingPair]);
    }

    public function marketStatistics(?string $tradingPair): array
    {
        return $this->get(self::URI_PREFIX . 'stats/', [$tradingPair]);
    }

    public function orderBook(string $tradingPair): array
    {
        return $this->get(self::URI_PREFIX . 'orderbook/', [$tradingPair]);
    }

    public function orderBookLimited(string $tradingPair, int $limit)
    {
        return $this->get(self::URI_PREFIX . 'orderbook-limited/', [$tradingPair, $limit]);
    }
}

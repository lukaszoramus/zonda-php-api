<?php

declare(strict_types=1);

namespace ZondaPhpApi\Api;

class Trading extends AbstractApi
{
    private const ENDPOINT_PREFIX = 'trading/';

    public function ticker(?string $tradingPair): array
    {
        return $this->get(self::ENDPOINT_PREFIX . 'ticker/', [$tradingPair]);
    }

    public function marketStatistics(?string $tradingPair): array
    {
        return $this->get(self::ENDPOINT_PREFIX . 'stats/', [$tradingPair]);
    }

    public function orderBook(string $tradingPair): array
    {
        return $this->get(self::ENDPOINT_PREFIX . 'orderbook/', [$tradingPair]);
    }

    public function orderBookLimited(string $tradingPair, int $limit)
    {
        return $this->get(self::ENDPOINT_PREFIX . 'orderbook-limited/', [$tradingPair, $limit]);
    }

    public function lastTransactions(string $tradingPair, array $query = [])
    {
        return $this->get(self::ENDPOINT_PREFIX . 'transactions/', [$tradingPair], $query);
    }

    public function candlestickChart(string $tradingPair, int $resolution, array $query = [])
    {
        return $this->get(self::ENDPOINT_PREFIX . 'candle/history/', [$tradingPair, $resolution], $query);
    }

    public function newOrder(string $tradingPair, array $data)
    {
        return $this->post(self::ENDPOINT_PREFIX . 'offer/', [$tradingPair], $data);
    }

    public function activeOrders(string $tradingPair)
    {
        return $this->get(self::ENDPOINT_PREFIX . 'offer/', [$tradingPair]);
    }

    public function cancelOrder(string $tradingPair, string $offerId, string $offerType, float $price)
    {
        return $this->delete(self::ENDPOINT_PREFIX . 'offer/', [$tradingPair, $offerId, $offerType, $price]);
    }

    public function feeAndMarketConfiguration(string $tradingPair)
    {
        return $this->get(self::ENDPOINT_PREFIX . 'config/', [$tradingPair]);
    }

    public function changeMarketConfiguration(string $tradingPair, array $data)
    {
        return $this->post(self::ENDPOINT_PREFIX . 'config/', [$tradingPair], $data);
    }
}

<?php

declare(strict_types=1);

namespace ZondaPhpApi\Api;

class TradingStop extends AbstractApi
{
    private const ENDPOINT_PREFIX = 'trading/stop/';

    public function newOrder(string $tradingPair, array $data)
    {
        return $this->post(self::ENDPOINT_PREFIX . 'offer/', [$tradingPair], $data);
    }

    public function activeOrders(string $tradingPair)
    {
        return $this->get(self::ENDPOINT_PREFIX . 'offer/', [$tradingPair]);
    }

    public function cancelOrder(string $tradingPair, string $offerId)
    {
        return $this->delete(self::ENDPOINT_PREFIX . 'offer/', [$tradingPair, $offerId]);
    }
}

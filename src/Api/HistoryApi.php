<?php

declare(strict_types=1);

namespace ZondaPhpApi\Api;

use ZondaPhpApi\HttpClient\Util\JsonArray;

class HistoryApi extends AbstractApi
{
    public function transactionHistory(array $query = [])
    {
        $endpointPrefix = 'trading/history/';

        return $this->get($endpointPrefix . 'transactions/', [], ['query' => JsonArray::encode($query)]);
    }

    public function operationalHistory(array $query = [])
    {
        $endpointPrefix = 'balances/BITBAY/';

        return $this->get($endpointPrefix . 'history/', [], ['query' => JsonArray::encode($query)]);
    }
}

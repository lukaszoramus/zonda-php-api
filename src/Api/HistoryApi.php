<?php

declare(strict_types=1);

namespace ZondaPhpApi\Api;

class HistoryApi extends AbstractApi
{
    public function transactionHistory(array $query = [])
    {
        return $this->get('trading/history/transactions/', [], $query);
    }

    public function operationalHistory(array $query = [])
    {
        return $this->get('balances/BITBAY/history/', [], $query);
    }
}

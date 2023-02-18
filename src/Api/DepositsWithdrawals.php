<?php

declare(strict_types=1);

namespace ZondaPhpApi\Api;

class DepositsWithdrawals extends AbstractApi
{
    private const ENDPOINT_PREFIX = 'api_payments/';

    public function depositAddressesForCrypto(array $query = [])
    {
        return $this->get(self::ENDPOINT_PREFIX . 'deposits/crypto/addresses/', [], $query);
    }

    public function cryptoWithdrawal(array $data)
    {
        return $this->post(self::ENDPOINT_PREFIX . 'withdrawals/crypto/', [], $data);
    }

    public function flatWithdrawal(array $data)
    {
        return $this->post(self::ENDPOINT_PREFIX . 'withdrawals/flat/', [], $data);
    }
}

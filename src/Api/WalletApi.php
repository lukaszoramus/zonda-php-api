<?php

declare(strict_types=1);

namespace ZondaPhpApi\Api;

class WalletApi extends AbstractApi
{
    private const ENDPOINT_PREFIX = 'balances/BITBAY/';

    public function listOfWallets()
    {
        return $this->get(self::ENDPOINT_PREFIX . 'balance/');
    }

    public function newWallet(array $data = [])
    {
        return $this->post(self::ENDPOINT_PREFIX . 'balance/', [], $data);
    }

    public function changeName(string $walletId, string $newName)
    {
        return $this->put(self::ENDPOINT_PREFIX . 'balance/', [$walletId], ['name' => $newName]);
    }

    public function internalTransfer(string $sourceId, string $destinationId, array $data)
    {
        return $this->post(self::ENDPOINT_PREFIX . 'balance/transfer/', [$sourceId, $destinationId], $data);
    }
}

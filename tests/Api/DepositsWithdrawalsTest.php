<?php

declare(strict_types=1);

namespace ZondaPhpApi\Tests\Api;

use ZondaPhpApi\Api\DepositsWithdrawals;

/**
 * @covers \ZondaPhpApi\Api\DepositsWithdrawals
 */
class DepositsWithdrawalsTest extends ApiTestCase
{
    /**
     * @test
     */
    public function shouldShowDepositAddressesForCrypto()
    {
        $depositsWithdrawals = $this->getApiMock();
        $depositsWithdrawals
            ->expects($this->once())
            ->method('get')
            ->with('api_payments/deposits/crypto/addresses/', [], [])
        ;
        $depositsWithdrawals->depositAddressesForCrypto();
    }

    /**
     * @test
     */
    public function shouldCryptoWithdrawal()
    {
        $data = [
            'currency' => 'BTC',
            'amount' => 0.1,
            'address' => '1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa'
        ];

        $depositsWithdrawals = $this->getApiMock();
        $depositsWithdrawals
            ->expects($this->once())
            ->method('post')
            ->with('api_payments/withdrawals/crypto/', [], $data)
        ;

        $depositsWithdrawals->cryptoWithdrawal($data);
    }

    /**
     * @test
     */
    public function flatWithdrawal()
    {
        $data = [
            'currency' => 'PLN',
            'amount' => 0.1,
            'address' => 'PL61109010140000071219812874'
        ];

        $depositsWithdrawals = $this->getApiMock();
        $depositsWithdrawals
            ->expects($this->once())
            ->method('post')
            ->with('api_payments/withdrawals/flat/', [], $data)
        ;

        $depositsWithdrawals->flatWithdrawal($data);
    }

    protected function getApiClass(): string
    {
        return DepositsWithdrawals::class;
    }
}

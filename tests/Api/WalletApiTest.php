<?php

declare(strict_types=1);

namespace ZondaPhpApi\Tests\Api;

use ZondaPhpApi\Api\WalletApi;

/**
 * @covers \ZondaPhpApi\Api\WalletApi
 */
class WalletApiTest extends ApiTestCase
{
    /**
     * @test
     */
    public function shouldReturnListOfWallets()
    {
        $expected = [
            'status' => 'Ok',
            'balances' => [
                [
                    'id' => '01931d52-536b-4ca5-a9f4-be28c86d0cc3',
                    'userId' => '4bc43956-423f-47fd-9faa-acd37c58ed9f',
                    'availableFunds' => 9830.28785615,
                    'totalFunds' => 9840.28785615,
                    'lockedFunds' => 10,
                    'currency' => 'ETH',
                    'type' => 'CRYPTO',
                    'name' => 'Domyślny rachunek ETH',
                    'balanceEngine' => 'BITBAY'
                ]
            ],
            'errors' => null
        ];

        $walletApi = $this->getApiMock();
        $walletApi
            ->expects($this->once())
            ->method('get')
            ->with('balances/BITBAY/balance/')
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $walletApi->listOfWallets());
    }

    /**
     * @test
     */
    public function shouldCreateNewWallet()
    {
        $expected = [
            'status' => 'Ok',
            'balances' => [
                [
                    'id' => '01931d52-536b-4ca5-a9f4-be28c86d0cc3',
                    'userId' => '4bc43956-423f-47fd-9faa-acd37c58ed9f',
                    'availableFunds' => 9830.28785615,
                    'totalFunds' => 9840.28785615,
                    'lockedFunds' => 10,
                    'currency' => 'ETH',
                    'type' => 'CRYPTO',
                    'name' => 'Domyślny rachunek ETH',
                    'balanceEngine' => 'BITBAY'
                ]
            ],
            'errors' => null
        ];

        $data = [
            'currency' => 'BTC',
            'name' => 'My BTC wallet',
        ];

        $walletApi = $this->getApiMock();
        $walletApi
            ->expects($this->once())
            ->method('post')
            ->with('balances/BITBAY/balance/', [], $data)
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $walletApi->newWallet($data));
    }

    /**
     * @test
     */
    public function shouldChangeWalletName()
    {
        $expected = [
            'status' => 'Ok',
            'message' => null,
        ];

        $walletId = '01931d52-536b-4ca5-a9f4-be28c86d0cc3';
        $data = [
            'name' => 'My BTC wallet',
        ];

        $walletApi = $this->getApiMock();
        $walletApi
            ->expects($this->once())
            ->method('put')
            ->with('balances/BITBAY/balance/', [$walletId], $data)
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $walletApi->changeName($walletId, $data['name']));
    }

    /**
     * @test
     */
    public function shouldTransferFundsBetweenWallets()
    {
        $expected = [
            'status' => 'Ok',
            'from' => [
                'id' => '01931d52-536b-4ca5-a9f4-be28c86d0cc3',
                'userId' => '4bc43956-423f-47fd-9faa-acd37c58ed9f',
                'availableFunds' => 0.01803472,
                'totalFunds' => 0.01804161,
                'lockedFunds' => 6.89E-6,
                'currency' => 'BTC',
                'type' => 'CRYPTO',
                'name' => 'BTC',
                'balanceEngine' => 'BITBAY'
            ],
            'to' => [
                'id' => '01931d52-536b-4ca5-a9f4-be28c86d0cc4',
                'userId' => '4bc43956-423f-47fd-9faa-acd37c58ed9f',
                'availableFunds' => 0.0001,
                'totalFunds' => 0.0001,
                'lockedFunds' => 0,
                'currency' => 'BTC',
                'type' => 'CRYPTO',
                'name' => 'Prowizja',
                'balanceEngine' => 'BITBAY'
            ],
            'errors' => null
        ];


        $sourceId = '01931d52-536b-4ca5-a9f4-be28c86d0cc3';
        $destinationId = '01931d52-536b-4ca5-a9f4-be28c86d0cc4';
        $data = [
            'funds' => '10',
            'currency' => 'BTC',
        ];

        $walletApi = $this->getApiMock();
        $walletApi
            ->expects($this->once())
            ->method('post')
            ->with('balances/BITBAY/balance/transfer/', [$sourceId, $destinationId], $data)
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $walletApi->internalTransfer($sourceId, $destinationId, $data));
    }

    protected function getApiClass(): string
    {
        return WalletApi::class;
    }
}

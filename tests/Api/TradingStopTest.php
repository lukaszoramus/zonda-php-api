<?php

declare(strict_types=1);

namespace ZondaPhpApi\Tests\Api;

use ZondaPhpApi\Api\TradingStop;

class TradingStopTest extends ApiTestCase
{
    private const TRADING_PAIR = 'BTC-PLN';

    /**
     * @test
     */
    public function shouldCreateNewOrder()
    {
        $expected = [
            'status' => 'Ok',
            'stopOfferId' => '6388963b-1d0d-4a70-ab6b-2ada1f9c06ea',
        ];

        $data = [
            'offerType' => 'BUY',
            'amount' => 20.2,
            'stopRate' => 1.1,
            'mode' => 'market',
            'rate' => null,
            'balances' => [],
            'ignoreInvalidStopRate' => false,
        ];

        $tradingStop = $this->getApiMock();
        $tradingStop->expects($this->once())
            ->method('post')
            ->with('trading/stop/offer/', [self::TRADING_PAIR], $data)
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $tradingStop->newOrder(self::TRADING_PAIR, $data));
    }

    /**
     * @test
     */
    public function shouldShowActiveOrders()
    {
        $expected = [
            'status' => 'Ok',
            'offers' => [
                [
                    'market' => 'BTC-PLN',
                    'offerType' => 'Sell',
                    'id' => 'f424817e-9910-4688-8f08-50336d88f4c6',
                    'currentAmount' => '0.001',
                    'lockedAmount' => '0.001',
                    'rate' => '30000',
                    'startAmount' => '0.001',
                    'time' => '1508230579837',
                    'postOnly' => false,
                    'mode' => 'limit',
                    'receivedAmount' => '0',
                    'firstBalanceId' => 'aa1c89b7-103a-4ad2-8002-b4a68002b60c',
                    'secondBalanceId' => '6c25f724-4b07-4a0f-bad2-843280027b12'
                ]
            ]
        ];

        $tradingStop = $this->getApiMock();
        $tradingStop->expects($this->once())
            ->method('get')
            ->with('trading/stop/offer/', [self::TRADING_PAIR])
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $tradingStop->activeOrders(self::TRADING_PAIR));
    }

    /**
     * @test
     */
    public function shouldCancelOrder()
    {
        $expected = [
            'status' => 'Ok',
            'errors' => [],
        ];

        $data = [
            self::TRADING_PAIR,
            'f424817e-9910-4688-8f08-50336d88f4c6',
        ];

        $tradingStop = $this->getApiMock();
        $tradingStop->expects($this->once())
            ->method('delete')
            ->with('trading/stop/offer/', $data)
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $tradingStop->cancelOrder(
            $data[0],
            $data[1],
        ));
    }

    protected function getApiClass(): string
    {
        return TradingStop::class;
    }
}

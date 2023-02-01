<?php

declare(strict_types=1);

namespace ZondaPhpApi\Tests\Api;

use ZondaPhpApi\Api\Trading;

class TradingTest extends ApiTestCase
{
    private const TRADING_PAIR = 'BTC-PLN';

    /**
     * @test
     */
    public function shouldShowTicker()
    {
        $expected = [
            'status' => 'Ok',
            'ticker' => [
                'market' => [
                    'code' => 'BTC-PLN',
                    'first' => [
                        'currency' => 'BTC',
                        'minOffer' => '0.000045',
                        'scale' => 8
                    ],
                    'second' => [
                        'currency' => 'PLN',
                        'minOffer' => '5',
                        'scale' => 2
                    ],
                    'amountPrecision' => 8,
                    'pricePrecision' => 2,
                    'ratePrecision' => 2
                ],
                'time' => '1674909625135',
                'highestBid' => '99511.03',
                'lowestAsk' => '99787.18',
                'rate' => '99713.03',
                'previousRate' => '99790.69'
            ]
        ];
        $trading = $this->getApiMock();
        $trading->expects($this->once())
            ->method('get')
            ->with('trading/ticker/', [self::TRADING_PAIR])
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $trading->ticker(self::TRADING_PAIR));
    }

    /**
     * @test
     */
    public function shouldShowMarketStatistics()
    {
        $expected = [
            'status' => 'Ok',
            'stats' => [
                'm' => 'BTC-PLN',
                'h' => '101439.36',
                'l' => '99300',
                'v' => '49.01320123',
                'r24h' => '99618.7'
            ]
        ];

        $trading = $this->getApiMock();
        $trading->expects($this->once())
            ->method('get')
            ->with('trading/stats/', [self::TRADING_PAIR])
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $trading->marketStatistics(self::TRADING_PAIR));
    }

    /**
     * @test
     */
    public function shouldShowOrderBook()
    {
        $expected = [
            'status' => 'Ok',
            'sell' => array_fill(0, 299, [
                'ra' => '100057.65',
                'ca' => '0.23662314',
                'sa' => '0.23662314',
                'pa' => '0.23662314',
                'co' => 1
            ]),
            'buy' => array_fill(0, 299, [
                'ra' => '100057.65',
                'ca' => '0.23662314',
                'sa' => '0.23662314',
                'pa' => '0.23662314',
                'co' => 1
            ]),
            'timestamp' => '1674913254548',
            'seqNo' => '1151810797'
        ];

        $trading = $this->getApiMock();
        $trading->expects($this->once())
            ->method('get')
            ->with('trading/orderbook/', [self::TRADING_PAIR])
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $trading->orderBook(self::TRADING_PAIR));
    }

    /**
     * @test
     */
    public function shouldShowOrderBookLimited()
    {
        $limit = 10;
        $expected = [
            'status' => 'Ok',
            'sell' => array_fill(0, $limit - 1, [
                'ra' => '100057.65',
                'ca' => '0.23662314',
                'sa' => '0.23662314',
                'pa' => '0.23662314',
                'co' => 1
            ]),
            'buy' => array_fill(0, $limit - 1, [
                'ra' => '100057.65',
                'ca' => '0.23662314',
                'sa' => '0.23662314',
                'pa' => '0.23662314',
                'co' => 1
            ]),
            'timestamp' => '1674913254548',
            'seqNo' => '1151810797'
        ];

        $trading = $this->getApiMock();
        $trading->expects($this->once())
            ->method('get')
            ->with('trading/orderbook-limited/', [self::TRADING_PAIR, $limit])
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $trading->orderBookLimited(self::TRADING_PAIR, $limit));
    }

    protected function getApiClass(): string
    {
        return Trading::class;
    }
}

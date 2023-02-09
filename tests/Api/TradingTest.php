<?php

declare(strict_types=1);

namespace ZondaPhpApi\Tests\Api;

use ZondaPhpApi\Api\Trading;

/**
 * @covers \ZondaPhpApi\Api\Trading
 */
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
                        'scale' => 8,
                    ],
                    'second' => [
                        'currency' => 'PLN',
                        'minOffer' => '5',
                        'scale' => 2,
                    ],
                    'amountPrecision' => 8,
                    'pricePrecision' => 2,
                    'ratePrecision' => 2,
                ],
                'time' => '1674909625135',
                'highestBid' => '99511.03',
                'lowestAsk' => '99787.18',
                'rate' => '99713.03',
                'previousRate' => '99790.69',
            ],
        ];
        $trading = $this->getApiMock();
        $trading->expects($this->once())
            ->method('get')
            ->with('trading/tickers/', [self::TRADING_PAIR])
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
                'r24h' => '99618.7',
            ],
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
                'co' => 1,
            ]),
            'buy' => array_fill(0, 299, [
                'ra' => '100057.65',
                'ca' => '0.23662314',
                'sa' => '0.23662314',
                'pa' => '0.23662314',
                'co' => 1,
            ]),
            'timestamp' => '1674913254548',
            'seqNo' => '1151810797',
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
                'co' => 1,
            ]),
            'buy' => array_fill(0, $limit - 1, [
                'ra' => '100057.65',
                'ca' => '0.23662314',
                'sa' => '0.23662314',
                'pa' => '0.23662314',
                'co' => 1,
            ]),
            'timestamp' => '1674913254548',
            'seqNo' => '1151810797',
        ];

        $trading = $this->getApiMock();
        $trading->expects($this->once())
            ->method('get')
            ->with('trading/orderbook-limited/', [self::TRADING_PAIR, $limit])
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $trading->orderBookLimited(self::TRADING_PAIR, $limit));
    }

    /**
     * @test
     */
    public function shouldShowLastTransactions()
    {
        $query = [
            'limit' => 2,
            'sort' => 'desc',
        ];

        $expected = [
            'status' => 'Ok',
            'items' => [
                [
                    'id' => '7addbf72-a266-11ed-9bda-0242ac110005',
                    't' => '1675279655007',
                    'a' => '0.06752256',
                    'r' => '99985.1',
                    'ty' => 'Buy',
                ],
                [
                    'id' => '7addbf71-a266-11ed-9bda-0242ac110005',
                    't' => '1675279655007',
                    'a' => '0.0825',
                    'r' => '99985.09',
                    'ty' => 'Buy',
                ],
            ],
        ];

        $trading = $this->getApiMock();
        $trading->expects($this->once())
            ->method('get')
            ->with('trading/transactions/', [self::TRADING_PAIR], $query)
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $trading->lastTransactions(self::TRADING_PAIR, $query));
    }

    /**
     * @test
     */
    public function shouldShowCandlestickChart()
    {
        $threeMinutes = 3 * 60;

        $query = [
            'from' => (new \DateTime('01.02.2023'))->format('Uu'),
            'to' => (new \DateTime('02.02.2023'))->format('Uu'),
        ];

        $expected = [
            'status' => 'Ok',
            'items' => [
                [
                    '1675365660000',
                    [
                        'o' => '102213.09',
                        'c' => '102213.09',
                        'h' => '102213.09',
                        'l' => '102213.09',
                        'v' => '0',
                        'co' => '0'
                    ]
                ]
            ]
        ];

        $trading = $this->getApiMock();
        $trading->expects($this->once())
            ->method('get')
            ->with('trading/candle/history/', [self::TRADING_PAIR, $threeMinutes], $query)
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $trading->candlestickChart(self::TRADING_PAIR, $threeMinutes, $query));
    }

    /**
     * @test
     */
    public function shouldShowFeeAndMarketConfiguration()
    {
        $expected = [
            'status' => 'Ok',
            'config' => [
                'buy' => [
                    'commissions' => [
                        'maker' => '0.0028',
                        'taker' => '0.0041'
                    ]
                ],
                'sell' => [
                    'commissions' => [
                        'maker' => '0.0028',
                        'taker' => '0.0041'
                    ]
                ],
                'first' => [
                    'balanceId' => 'ad9397c5-3bd9-4372-82ba-22da6a90cb56',
                    'minValue' => '0.00003'
                ],
                'second' => [
                    'balanceId' => 'f1ed4490-54f6-450b-a87c-16f13d14a949',
                    'minValue' => '0.1'
                ]
            ]
        ];

        $trading = $this->getApiMock();
        $trading->expects($this->once())
            ->method('get')
            ->with('trading/config/', [self::TRADING_PAIR])
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $trading->feeAndMarketConfiguration(self::TRADING_PAIR));
    }

    protected function getApiClass(): string
    {
        return Trading::class;
    }
}

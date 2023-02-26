<?php

declare(strict_types=1);

namespace ZondaPhpApi\Tests\Api;

use ZondaPhpApi\Api\HistoryApi;
use ZondaPhpApi\HttpClient\Util\JsonArray;

/**
 * @covers \ZondaPhpApi\Api\HistoryApi
 */
class HistoryApiTest extends ApiTestCase
{
    /**
     * @test
     */
    public function shouldReturnTransactionsHistory()
    {
        $query = [
            'markets' => [
                'BTC-PLN'
            ],
        ];

        $expected = [
            'status' => 'Ok',
            'totalRows' => '31503',
            'items' => [
                [
                    'id' => 'd0e4746b-288e-4869-8107-d8277fcf4b9d',
                    'market' => 'BTC-PLN',
                    'time' => '1529670604532',
                    'amount' => '0.01281693',
                    'rate' => '23572.84',
                    'initializedBy' => 'Sell',
                    'wasTaker' => false,
                    'userAction' => 'Buy',
                    'offerId' => '0325186f-c750-4aaa-98a2-d54e363f30bb',
                    'commissionValue' => '1.14'
                ]
            ],
            'query' => [
                'markets' => [
                    'BTC-PLN'
                ],
                'limit' => [
                ],
                'offset' => [
                ],
                'fromTime' => [
                ],
                'toTime' => [
                ],
                'initializedBy' => [
                ],
                'rateFrom' => [
                ],
                'rateTo' => [
                ],
                'userAction' => [
                ],
                'nextPageCursor' => [
                    'start'
                ]
            ],
            'nextPageCursor' => 'QW9ON3cvcjk2T0lDUHdWallXVTRPRFV3WWkwelpUQTVMVFEyTXpndFlqVmtOQzA1TldJeU56RmxOR1U0WWpZL0kxc2lSVlJJTFZCTVRpSXNJakUxTWpNNU5ERXhNREkyTlRFaUxDSmpZV1U0T0RVd1lpMHpaVEE1TFRRMk16Z3RZalZrTkMwNU5XSXlOekZsTkdVNFlqWWlYUT09'
        ];

        $historyApi = $this->getApiMock();
        $historyApi
            ->expects($this->once())
            ->method('get')
            ->with('trading/history/transactions/', [], ['query' => JsonArray::encode($query)])
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $historyApi->transactionHistory($query));
    }

    /**
     * @test
     */
    public function shouldReturnOperationalHistory()
    {
        $query = [
            'balancesId' => [
                '69d14efe-0b1b-413f-ada4-4a8a975b7d76'
            ],
        ];

        $expected = [
            'status' => 'Ok',
            'items' => [
                [
                    'historyId' => '21607612-7b64-4e2a-bac3-22185c556183',
                    'balance' => [
                        'id' => '69d14efe-0b1b-413f-ada4-4a8a975b7d76',
                        'currency' => 'PLN',
                        'type' => 'FIAT',
                        'userId' => 'b47f9af4-081d-4f5d-8cd7-9f3a1411d2e2',
                        'name' => 'PLN'
                    ],
                    'detailId' => null,
                    'time' => 1530265764420,
                    'type' => 'CREATE_BALANCE',
                    'value' => 0,
                    'fundsBefore' => [
                        'total' => null,
                        'available' => null,
                        'locked' => null
                    ],
                    'fundsAfter' => [
                        'total' => 0,
                        'available' => 0,
                        'locked' => 0
                    ],
                    'change' => [
                        'total' => 0,
                        'available' => 0,
                        'locked' => 0
                    ]
                ]
            ],
            'hasNextPage' => true,
            'fetchedRows' => 10,
            'limit' => 10,
            'offset' => 0,
            'queryTime' => 1,
            'totalTime' => 46,
            'settings' => [
                'balancesId' => null,
                'balanceCurrencies' => [
                ],
                'balanceTypes' => [
                ],
                'users' => [
                    'b47f9af4-081d-4f5d-8cd7-9f3a1411d2e2'
                ],
                'engine' => 'BITBAY',
                'fromTime' => 0,
                'toTime' => 2229729760000,
                'absValue' => false,
                'fromValue' => null,
                'toValue' => null,
                'sort' => [
                ],
                'limit' => 10,
                'offset' => 0,
                'types' => null
            ],
            'errors' => null
        ];

        $historyApi = $this->getApiMock();
        $historyApi
            ->expects($this->once())
            ->method('get')
            ->with('balances/BITBAY/history/', [], ['query' => JsonArray::encode($query)])
            ->will($this->returnValue($expected));

        $this->assertEquals($expected, $historyApi->operationalHistory($query));
    }

    protected function getApiClass(): string
    {
        return HistoryApi::class;
    }
}

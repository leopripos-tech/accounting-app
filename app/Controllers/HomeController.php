<?php

namespace App\Controllers;

use App\Models\StatisticModel;

class HomeController extends BaseController
{
    public function index()
    {
        $year = date("Y");
        $months = [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "Septermber",
            "Oktober",
            "November",
            "Desember",
        ];

        $growths = model(StatisticModel::class)->getGrowth($year);
        $debitCredit = model(StatisticModel::class)->getDebitCredit($year);
        $debitCreditActiva = model(StatisticModel::class)->getAccountDebitCredit($year, '1');
        $debitCreditHutang = model(StatisticModel::class)->getAccountDebitCredit($year, '2');
        $debitCreditModal = model(StatisticModel::class)->getAccountDebitCredit($year, '3');
        $debitCreditPendapatan = model(StatisticModel::class)->getAccountDebitCredit($year, '4');
        $debitCreditBeban = model(StatisticModel::class)->getAccountDebitCredit($year, '5');

        $data = [
            'year' => $year,
            'charts' => [
                'growth' => [
                    'title' => "Pertumbuhan $year",
                    'labels' => $months,
                    'datasets' => [
                        [
                            'title' => 'Activa',
                            'borderColor' => 'purple',
                            'data' => array_map(function ($item) {
                                return $item['activa'];
                            }, $growths),
                        ],
                        [
                            'title' => 'Hutang',
                            'borderColor' => 'red',
                            'data' => array_map(function ($item) {
                                return $item['hutang'];
                            }, $growths),
                        ],
                        [
                            'title' => 'Modal',
                            'borderColor' => 'blue',
                            'data' => array_map(function ($item) {
                                return $item['modal'];
                            }, $growths),
                        ],
                        [
                            'title' => 'Pendapatan',
                            'borderColor' => 'green',
                            'data' => array_map(function ($item) {
                                return $item['pendapatan'];
                            }, $growths),
                        ],
                        [
                            'title' => 'Beban',
                            'borderColor' => 'orange',
                            'data' => array_map(function ($item) {
                                return $item['beban'];
                            }, $growths),
                        ],
                    ]
                ],
                'debit_credit' => [
                    'title' => "Debit Kredit Tahun $year",
                    'labels' => array_map(function ($item) {
                        return $item['name'];
                    }, $debitCredit),
                    'datasets' => [
                        [
                            'title' => 'Debit',
                            'backgroundColor' => 'orange',
                            'data' => array_map(function ($item) {
                                return $item['debit'];
                            }, $debitCredit),
                        ],
                        [
                            'title' => 'Kredit',
                            'backgroundColor' => 'purple',
                            'data' => array_map(function ($item) {
                                return $item['credit'];
                            }, $debitCredit)
                        ]
                    ]
                ],
                'debit_credit_activa' => [
                    'title' => "Activa Tahun $year",
                    'labels' => array_map(function ($item) {
                        return $item['name'];
                    }, $debitCreditActiva),
                    'datasets' => [
                        [
                            'title' => 'Debit',
                            'backgroundColor' => 'orange',
                            'data' => array_map(function ($item) {
                                return $item['debit'];
                            }, $debitCreditActiva),
                        ],
                        [
                            'title' => 'Kredit',
                            'backgroundColor' => 'purple',
                            'data' => array_map(function ($item) {
                                return $item['credit'];
                            }, $debitCreditActiva)
                        ]
                    ]
                ],
                'debit_credit_hutang' => [
                    'title' => "Hutang Tahun $year",
                    'labels' => array_map(function ($item) {
                        return $item['name'];
                    }, $debitCreditHutang),
                    'datasets' => [
                        [
                            'title' => 'Debit',
                            'backgroundColor' => 'orange',
                            'data' => array_map(function ($item) {
                                return $item['debit'];
                            }, $debitCreditHutang),
                        ],
                        [
                            'title' => 'Kredit',
                            'backgroundColor' => 'purple',
                            'data' => array_map(function ($item) {
                                return $item['credit'];
                            }, $debitCreditHutang)
                        ]
                    ]
                ],
                'debit_credit_modal' => [
                    'title' => "Modal Tahun $year",
                    'labels' => array_map(function ($item) {
                        return $item['name'];
                    }, $debitCreditModal),
                    'datasets' => [
                        [
                            'title' => 'Debit',
                            'backgroundColor' => 'orange',
                            'data' => array_map(function ($item) {
                                return $item['debit'];
                            }, $debitCreditModal),
                        ],
                        [
                            'title' => 'Kredit',
                            'backgroundColor' => 'purple',
                            'data' => array_map(function ($item) {
                                return $item['credit'];
                            }, $debitCreditModal)
                        ]
                    ]
                ],
                'debit_credit_pendapatan' => [
                    'title' => "Pendapatan Tahun $year",
                    'labels' => array_map(function ($item) {
                        return $item['name'];
                    }, $debitCreditPendapatan),
                    'datasets' => [
                        [
                            'title' => 'Debit',
                            'backgroundColor' => 'orange',
                            'data' => array_map(function ($item) {
                                return $item['debit'];
                            }, $debitCreditPendapatan),
                        ],
                        [
                            'title' => 'Kredit',
                            'backgroundColor' => 'purple',
                            'data' => array_map(function ($item) {
                                return $item['credit'];
                            }, $debitCreditPendapatan)
                        ]
                    ]
                ],
                'debit_credit_beban' => [
                    'title' => "Beban Tahun $year",
                    'labels' => array_map(function ($item) {
                        return $item['name'];
                    }, $debitCreditBeban),
                    'datasets' => [
                        [
                            'title' => 'Debit',
                            'backgroundColor' => 'orange',
                            'data' => array_map(function ($item) {
                                return $item['debit'];
                            }, $debitCreditBeban),
                        ],
                        [
                            'title' => 'Kredit',
                            'backgroundColor' => 'purple',
                            'data' => array_map(function ($item) {
                                return $item['credit'];
                            }, $debitCreditBeban)
                        ]
                    ]
                ],
            ],
        ];

        return view('home/index', $data);
    }
}

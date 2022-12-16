<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdjustmentSeeder extends Seeder
{
    public function run()
    {
        $adjustments = [
            [
                'adjustment' => [
                    'id' => 1,
                    'date' => '12/31/2021',
                    'value' => 15_000_000,
                    'time' => 6,
                    'description' => 'Sewa gedung selama 6 bulan',
                ],
                'items' => [
                    ['account_id' => '42', 'credit' => 15_000_000, 'debit' => 0]
                ]
            ],
            [
                'adjustment' => [
                    'id' => 2,
                    'date' => '12/5/2021',
                    'value' => '42000000',
                    'time' => 12,
                    'description' => 'Asuransi selama 1 tahun',
                ],
                'items' => [
                    ['adjustment_id',]
                ]
            ]
        ];

        foreach ($adjustments as $index => $adjustment) {
            $adjustments[$index]['adjustment']['total'] = $adjustments['value'] / $adjustments['time'];
            foreach ($adjustments[$index]['items'] as $itemIndex => item) {
                $adjustments[$index]['items'][$itemIndex]['adjustment_id'] = $adjustment['id'];
            }
        }

        $this->db->table("adjustments")->insertBatch($adjustments);
    }
}

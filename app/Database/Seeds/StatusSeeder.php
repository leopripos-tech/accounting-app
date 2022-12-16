<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StatusSeeder extends Seeder
{
    public function run()
    {
        $this->db->table("transaction_statuses")->insertBatch([
            [
                'id' => 1,
                'name' => 'Penerimaan',
                'description' => 'Penerimaan adalah ...'
            ],
            [
                'id' => 2,
                'name' => 'Pengeluaran',
                'description' => 'Pengeluaran adalah ...'
            ],
            [
                'id' => 3,
                'name' => 'Investasi Masuk',
                'description' => 'Investasi Masuk adalah ...'
            ],
            [
                'id' => 4,
                'name' => 'Investasi Keluar',
                'description' => 'Investasi Keluar adalah ...'
            ],
            [
                'id' => 5,
                'name' => 'Normal',
                'description' => 'Normal adalah ...'
            ],
        ]);
    }
}

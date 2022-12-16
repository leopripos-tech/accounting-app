<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AccountSeeder extends Seeder
{
    public function run()
    {
        $this->db->table("accounts")->insertBatch([
            ['id' => 1, 'code' => '1', 'name' => 'Activa', 'level' => 0],
            ['id' => 2, 'code' => '2', 'name' => 'Hutang', 'level' => 0],
            ['id' => 3, 'code' => '3', 'name' => 'Modal', 'level' => 0],
            ['id' => 4, 'code' => '4', 'name' => 'Pendapatan', 'level' => 0],
            ['id' => 5, 'code' => '5', 'name' => 'Beban', 'level' => 0],
        ]);

        $this->db->table("accounts")->insertBatch([
            ['id' => 6, 'code' => '11', 'name' => 'Activa Lancar', 'parent_id' => 1, 'level' => 1],
            ['id' => 7, 'code' => '12', 'name' => 'Activa Tetap', 'parent_id' => 1, 'level' => 1],
            ['id' => 8, 'code' => '21', 'name' => 'Hutang Jangka Pendek', 'parent_id' => 2, 'level' => 1],
            ['id' => 9, 'code' => '22', 'name' => 'Hutang Jangka Panjang', 'parent_id' => 2, 'level' => 1],
            ['id' => 10, 'code' => '31', 'name' => 'Modal Pemilik', 'parent_id' => 3, 'level' => 1],
            ['id' => 11, 'code' => '32', 'name' => 'Prive Pemilik', 'parent_id' => 3, 'level' => 1],
            ['id' => 12, 'code' => '41', 'name' => 'Pendapatan Usaha', 'parent_id' => 4, 'level' => 1],
            ['id' => 13, 'code' => '42', 'name' => 'Pendapatan Diluar Usaha', 'parent_id' => 4, 'level' => 1],
            ['id' => 14, 'code' => '51', 'name' => 'Beban Usaha', 'parent_id' => 5, 'level' => 1],
            ['id' => 15, 'code' => '52', 'name' => 'Beban Diluar Usaha', 'parent_id' => 5, 'level' => 1],
        ]);

        $this->db->table("accounts")->insertBatch([
            ['id' => 16, 'code' => '1101', 'name' => 'Kas', 'parent_id' => 6, 'level' => 2],
            ['id' => 17, 'code' => '1102', 'name' => 'Piutang Usaha', 'parent_id' => 6, 'level' => 2],
            ['id' => 18, 'code' => '1103', 'name' => 'Perlengkapan Kantor', 'parent_id' => 6, 'level' => 2],
            ['id' => 19, 'code' => '1104', 'name' => 'Sewa Dibayar Dimuka', 'parent_id' => 6, 'level' => 2],
            ['id' => 20, 'code' => '1105', 'name' => 'Asuransi Dibayar Dimuka', 'parent_id' => 6, 'level' => 2],
            ['id' => 21, 'code' => '1201', 'name' => 'Peralatan Kantor', 'parent_id' => 7, 'level' => 2],
            ['id' => 22, 'code' => '1202', 'name' => 'Penyusutan Peralatan Kantor', 'parent_id' => 7, 'level' => 2],
            ['id' => 23, 'code' => '1203', 'name' => 'Tanah', 'parent_id' => 7, 'level' => 2],
            ['id' => 24, 'code' => '2101', 'name' => 'Utang Usaha', 'parent_id' => 8, 'level' => 2],
            ['id' => 25, 'code' => '2102', 'name' => 'Utang Gaji', 'parent_id' => 8, 'level' => 2],
            ['id' => 26, 'code' => '2103', 'name' => 'Pendapatan Diterima Dimuka', 'parent_id' => 8, 'level' => 2],
            ['id' => 27, 'code' => '2201', 'name' => 'Utang Hipotek', 'parent_id' => 9, 'level' => 2],
            ['id' => 28, 'code' => '2202', 'name' => 'Utang Obligasi', 'parent_id' => 9, 'level' => 2],
            ['id' => 29, 'code' => '3101', 'name' => 'Modal Pemilik', 'parent_id' => 10, 'level' => 2],
            ['id' => 30, 'code' => '3102', 'name' => 'Modal Lainnya', 'parent_id' => 10, 'level' => 2],
            ['id' => 31, 'code' => '3201', 'name' => 'Prive Tuam Najwan', 'parent_id' => 11, 'level' => 2],
            ['id' => 32, 'code' => '3202', 'name' => 'Prive Tuan A', 'parent_id' => 11, 'level' => 2],
            ['id' => 33, 'code' => '4101', 'name' => 'Pendapatan Jasa', 'parent_id' => 12, 'level' => 2],
            ['id' => 34, 'code' => '4102', 'name' => 'Pendapatan Diterima Dimuka', 'parent_id' => 12, 'level' => 2],
            ['id' => 35, 'code' => '4201', 'name' => 'Pendapatan Diluar Usaha', 'parent_id' => 13, 'level' => 2],
            ['id' => 36, 'code' => '4202', 'name' => 'Pendapatan Lainnya', 'parent_id' => 13, 'level' => 2],
            ['id' => 37, 'code' => '5101', 'name' => 'Beban Gaji Karyawan', 'parent_id' => 14, 'level' => 2],
            ['id' => 38, 'code' => '5102', 'name' => 'Beban Iklan', 'parent_id' => 14, 'level' => 2],
            ['id' => 39, 'code' => '5103', 'name' => 'Beban Asuransi', 'parent_id' => 14, 'level' => 2],
            ['id' => 40, 'code' => '5104', 'name' => 'Beban Telepon', 'parent_id' => 14, 'level' => 2],
            ['id' => 41, 'code' => '5105', 'name' => 'Beban Listrik', 'parent_id' => 14, 'level' => 2],
            ['id' => 42, 'code' => '5106', 'name' => 'Beban Sewa', 'parent_id' => 14, 'level' => 2],
            ['id' => 43, 'code' => '5107', 'name' => 'Beban Peyusutan Perlengkapan Kantor', 'parent_id' => 14, 'level' => 2],
            ['id' => 44, 'code' => '5108', 'name' => 'Beban Perlengkapan Kantor', 'parent_id' => 14, 'level' => 2],
            ['id' => 45, 'code' => '5201', 'name' => 'Beban Bunga', 'parent_id' => 15, 'level' => 2],
            ['id' => 46, 'code' => '5201', 'name' => 'Beban Lainnya   ', 'parent_id' => 15, 'level' => 2],
        ]);
    }
}

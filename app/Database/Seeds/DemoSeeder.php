<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run()
    {
        $this->call("UserSeeder");
        $this->call("StatusSeeder");;
        $this->call("AccountSeeder");
    }
}

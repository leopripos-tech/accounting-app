<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $this->db->table("users")->insertBatch([
            [
                'id' => 1,
                'username' => 'admin',
                'created_at' => '2022-10-15 07:08:12',
                'updated_at' => '2022-10-15 07:08:12'
            ],
        ]);

        $this->db->table("auth_identities")->insertBatch([
            [
                'id' => 1,
                'user_id' => 1,
                'type' => 'email_password',
                "secret" => "admin@test.com",
                'secret2' => '$2y$10$qMaTg9tcU8sjhjhe95orWu5wfQ1UrsWt7IY5OwvBEPA.p9SRxHetS',
                'created_at' => '2022-10-15 07:08:12',
                'updated_at' => '2022-10-15 07:08:12',
            ],
        ]);
    }
}

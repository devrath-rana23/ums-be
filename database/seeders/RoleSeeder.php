<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $inputData = [
            ['id' => 1, 'name' => 'superadmin', 'created_at' => time(), 'updated_at' => time()],
            ['id' => 2, 'name' => 'admin', 'created_at' => time(), 'updated_at' => time()],
        ];
        Role::insert($inputData);
    }
}

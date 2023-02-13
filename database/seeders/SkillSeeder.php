<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $inputData = [
        //     ['id' => 1, 'name' => 'laravel', 'created_at' => time(), 'updated_at' => time()],
        //     ['id' => 2, 'name' => 'php', 'created_at' => time(), 'updated_at' => time()],
        // ];
        // Skill::insert($inputData);

        // Skill::factory()
        //     ->count(50000)
        //     ->create(['created_at' => time(), 'updated_at' => time()]);

        for ($i = 50000; $i < 1150000; $i++) {
            Skill::insert(
                [
                    'name' => "{$i}-laravel-{$i}",
                    'created_at' => time(),
                    'updated_at' => time()
                ]
            );
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Team::insert([
            [
                'name' => 'Finance',
                'icon' => '',
                'company_id' => 1,
            ],
            [
                'name' => 'Human Resources',
                'icon' => '',
                'company_id' => 1,
            ],
            [
                'name' => 'Marketing',
                'icon' => '',
                'company_id' => 1,
            ],
            [
                'name' => 'Production',
                'icon' => '',
                'company_id' => 1,
            ],
            [
                'name' => 'Engineering',
                'icon' => '',
                'company_id' => 1,
            ],
        ]);
    }
}

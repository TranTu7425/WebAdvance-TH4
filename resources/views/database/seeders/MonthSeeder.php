<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MonthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $months = [
            ['name' => 'Tháng 1'],
            ['name' => 'Tháng 2'],
            ['name' => 'Tháng 3'],
            ['name' => 'Tháng 4'],
            ['name' => 'Tháng 5'],
            ['name' => 'Tháng 6'],
            ['name' => 'Tháng 7'],
            ['name' => 'Tháng 8'],
            ['name' => 'Tháng 9'],
            ['name' => 'Tháng 10'],
            ['name' => 'Tháng 11'],
            ['name' => 'Tháng 12'],
        ];
        
        DB::table('month_names')->insert($months);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = [
            ['region_name' => 'Toshkent Shahar'],
            ['region_name' => 'Andijon'],
            ['region_name' => 'Buxoro'],
            ['region_name' => 'Farg‘ona'],
            ['region_name' => 'Jizzax'],
            ['region_name' => 'Qoraqalpog‘iston'],
            ['region_name' => 'Xorazm'],
            ['region_name' => 'Namangan'],
            ['region_name' => 'Navoiy'],
            ['region_name' => 'Samarqand'],
            ['region_name' => 'Sirdaryo'],
            ['region_name' => 'Surxondaryo'],
            ['region_name' => 'Toshkent viloyati'],
            ['region_name' => 'Qashqadaryo'],
        ];

        Region::insert($regions);
    }
}

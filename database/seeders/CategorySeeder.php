<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use App\Models\Categories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['category' => 'Hepatitis B'],
            ['category' => 'Polio'],
            ['category' => 'BCG'],
            ['category' => 'DTP'],
            ['category' => 'Hib'],
            ['category' => 'PCV'],
            ['category' => 'Rotavirus'],
            ['category' => 'Influenza'],
            ['category' => 'MR/MMR'],
            ['category' => 'JE'],
            ['category' => 'Varisela'],
            ['category' => 'Hepatitis A'],
            ['category' => 'Tifoid'],
            ['category' => 'Dengue'],
            ['category' => 'HPV'],
        ];

        DB::table('category')->insert($categories);
    }
}

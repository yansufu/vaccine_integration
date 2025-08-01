<?php

namespace Database\Seeders;

use App\Models\Vaccines;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class VaccineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() 
    {
        $vaccines = [
            ['name' => 'Hepatitis B', 'cat_id' => 1, 'period' => 0],
            ['name' => 'Hepatitis B', 'cat_id' => 1, 'period' => 1],
            ['name' => 'Hepatitis B', 'cat_id' => 1, 'period' => 2],
            ['name' => 'Hepatitis B', 'cat_id' => 1, 'period' => 6],

            ['name' => 'Polio', 'cat_id' => 2, 'period' => 0],
            ['name' => 'Polio', 'cat_id' => 2, 'period' => 2],
            ['name' => 'Polio', 'cat_id' => 2, 'period' => 3],
            ['name' => 'Polio', 'cat_id' => 2, 'period' => 4],

            ['name' => 'BCG', 'cat_id' => 3, 'period' => 1],

            ['name' => 'DTP', 'cat_id' => 4, 'period' => 2],
            ['name' => 'DTP', 'cat_id' => 4, 'period' => 3],
            ['name' => 'DTP', 'cat_id' => 4, 'period' => 4],
            ['name' => 'DTP', 'cat_id' => 4, 'period' => 18],
            ['name' => 'DTP', 'cat_id' => 4, 'period' => 60],

            ['name' => 'Hib', 'cat_id' => 5, 'period' => 2],
            ['name' => 'Hib', 'cat_id' => 5, 'period' => 3],
            ['name' => 'Hib', 'cat_id' => 5, 'period' => 4],
            ['name' => 'Hib', 'cat_id' => 5, 'period' => 18],

            ['name' => 'PCV', 'cat_id' => 6, 'period' => 2],
            ['name' => 'PCV', 'cat_id' => 6, 'period' => 4],
            ['name' => 'PCV', 'cat_id' => 6, 'period' => 6],
            ['name' => 'PCV', 'cat_id' => 6, 'period' => 12],

            ['name' => 'Rotavirus', 'cat_id' => 7, 'period' => 2],
            ['name' => 'Rotavirus', 'cat_id' => 7, 'period' => 4],
            ['name' => 'Rotavirus', 'cat_id' => 7, 'period' => 6],

            ['name' => 'Influenza', 'cat_id' => 8, 'period' => 6],
            ['name' => 'Influenza', 'cat_id' => 8, 'period' => 18],
            ['name' => 'Influenza', 'cat_id' => 8, 'period' => 30],
            ['name' => 'Influenza', 'cat_id' => 8, 'period' => 42],
            ['name' => 'Influenza', 'cat_id' => 8, 'period' => 54],
            ['name' => 'Influenza', 'cat_id' => 8, 'period' => 66],
            ['name' => 'Influenza', 'cat_id' => 8, 'period' => 78],
            ['name' => 'Influenza', 'cat_id' => 8, 'period' => 90],
            ['name' => 'Influenza', 'cat_id' => 8, 'period' => 102],
            ['name' => 'Influenza', 'cat_id' => 8, 'period' => 114],
            ['name' => 'Influenza', 'cat_id' => 8, 'period' => 126],
            ['name' => 'Influenza', 'cat_id' => 8, 'period' => 138],
            ['name' => 'Influenza', 'cat_id' => 8, 'period' => 150],
            ['name' => 'Influenza', 'cat_id' => 8, 'period' => 162],
            ['name' => 'Influenza', 'cat_id' => 8, 'period' => 174],
            ['name' => 'Influenza', 'cat_id' => 8, 'period' => 186],
            ['name' => 'Influenza', 'cat_id' => 8, 'period' => 198],
            ['name' => 'Influenza', 'cat_id' => 8, 'period' => 210],
            ['name' => 'Influenza', 'cat_id' => 8, 'period' => 222],

            ['name' => 'MR/MMR', 'cat_id' => 9, 'period' => 9],
            ['name' => 'MR/MMR', 'cat_id' => 9, 'period' => 18],
            ['name' => 'MR/MMR', 'cat_id' => 9, 'period' => 72],
            ['name' => 'MR/MMR', 'cat_id' => 9, 'period' => 132],

            ['name' => 'JE', 'cat_id' => 10, 'period' => 10],
            ['name' => 'JE', 'cat_id' => 10, 'period' => 12],

            ['name' => 'Varisela', 'cat_id' => 11, 'period' => 12],

            ['name' => 'Hepatitis A', 'cat_id' => 12, 'period' => 24],
            ['name' => 'Hepatitis A', 'cat_id' => 12, 'period' => 30],

            ['name' => 'Tifoid', 'cat_id' => 13, 'period' => 24],
            ['name' => 'Tifoid', 'cat_id' => 13, 'period' => 60],
            ['name' => 'Tifoid', 'cat_id' => 13, 'period' => 96],
            ['name' => 'Tifoid', 'cat_id' => 13, 'period' => 132],
            ['name' => 'Tifoid', 'cat_id' => 13, 'period' => 168],

            ['name' => 'Dengue', 'cat_id' => 14, 'period' => 90],
            ['name' => 'Dengue', 'cat_id' => 14, 'period' => 96],

            ['name' => 'HPV', 'cat_id' => 15, 'period' => 120],
            ['name' => 'HPV', 'cat_id' => 15, 'period' => 132],
            ['name' => 'HPV', 'cat_id' => 15, 'period' => 144],
        ];
        
        DB::table('vaccine')->insert($vaccines);
    }
}

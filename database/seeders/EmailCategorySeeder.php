<?php

namespace Database\Seeders;

use App\Models\EmailCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmailCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Attended Service', 
            'Abscent From Service', 
            'Birthday', 
            'Birthday Celebrant', 
            'Wedding Anniversay',
            'Annivasary Celebrant'
        ];

        foreach($categories as $category)
        {
            EmailCategory::updateOrCreate(['name' => $category]);
        }
    }
}

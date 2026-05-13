<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Category::insert([
            ['name' => 'Pant', 'status' => 1],
            ['name' => 'Shirt', 'status' => 1],
            ['name' => 'T-shirt', 'status' => 0],
            ['name' => 'Jeans', 'status' => 1],
            ['name' => 'Jacket', 'status' => 0],
        ]);
    }
}

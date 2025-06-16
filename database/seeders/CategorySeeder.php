<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 100; $i++) {
            Category::create([
                'name' => 'Category ' . $i,
                'slug' => Str::slug('Category ' . $i),
                'code_category' => strtoupper(Str::random(10)),
                'description' => 'Description for Category ' . $i,
                'user_id' => 1, // sesuaikan dengan user_id yang ada di database-mu
                'role_id' => 1, // sesuaikan juga role_id supaya permission jalan
            ]);
        }
    }
}

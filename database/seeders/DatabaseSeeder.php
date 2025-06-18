<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            PermissionSeeder::class,
            PermissionRoleSeeder::class,
            CategorySeeder::class,
            SPKSeeder::class,
            // KriteriaSeeder::class, // php artisan db:seed --class=KriteriaSeeder
            // AlternatifSeeder::class, // php artisan db:seed --class=AlternatifSeeder
        ]);
    }
}

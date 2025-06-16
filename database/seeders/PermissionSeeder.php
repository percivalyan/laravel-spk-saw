<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'Dashboard', 'slug' => 'Dashboard', 'groupby' => 0],
            ['name' => 'User', 'slug' => 'User', 'groupby' => 1],
            ['name' => 'Add User', 'slug' => 'Add User', 'groupby' => 1],
            ['name' => 'Edit User', 'slug' => 'Edit User', 'groupby' => 1],
            ['name' => 'Delete User', 'slug' => 'Delete User', 'groupby' => 1],
            ['name' => 'Role', 'slug' => 'Role', 'groupby' => 2],
            ['name' => 'Add Role', 'slug' => 'Add Role', 'groupby' => 2],
            ['name' => 'Edit Role', 'slug' => 'Edit Role', 'groupby' => 2],
            ['name' => 'Delete Role', 'slug' => 'Delete Role', 'groupby' => 2],
            ['name' => 'Category', 'slug' => 'Category', 'groupby' => 3],
            ['name' => 'Add Category', 'slug' => 'Add Category', 'groupby' => 3],
            ['name' => 'Edit Category', 'slug' => 'Edit Category', 'groupby' => 3],
            ['name' => 'Delete Category', 'slug' => 'Delete Category', 'groupby' => 3],
            ['name' => 'Show Category', 'slug' => 'Show Category', 'groupby' => 3],
            ['name' => 'Sub Category', 'slug' => 'Sub Category', 'groupby' => 4],
            ['name' => 'Add Sub Category', 'slug' => 'Add Sub Category', 'groupby' => 4],
            ['name' => 'Edit Sub Category', 'slug' => 'Edit Sub Category', 'groupby' => 4],
            ['name' => 'Delete Sub Category', 'slug' => 'Delete Sub Category', 'groupby' => 4],
            ['name' => 'Product', 'slug' => 'Product', 'groupby' => 5],
            ['name' => 'Add Product', 'slug' => 'Add Product', 'groupby' => 5],
            ['name' => 'Edit Product', 'slug' => 'Edit Product', 'groupby' => 5],
            ['name' => 'Delete Product', 'slug' => 'Delete Product', 'groupby' => 5],
            ['name' => 'Setting', 'slug' => 'Setting', 'groupby' => 6],
        ];

        DB::table('permissions')->insert($permissions);
    }
}

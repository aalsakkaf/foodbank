<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $permissions = [
           'role-list',
           'role-create',
           'role-edit',
           'role-delete',
           'donation-list',
           'donation-create',
           'donation-edit',
           'donation-delete',
           'foodItem-list',
           'foodItem-create',
           'foodItem-edit',
           'foodItem-delete',
           'delivery-list',
           'delivery-create',
           'delivery-edit',
           'delivery-delete',
           'post-list',
           'post-create',
           'post-edit',
           'post-delete',
           'bundle-list',
           'bundle-create',
           'bundle-edit',
           'bundle-delete',
           'category-list',
           'category-create',
           'category-edit',
           'category-delete',
           'status-list',
           'status-create',
           'status-edit',
           'status-delete',
           'point-list',
           'point-create',
           'point-edit',
           'point-delete'
        ];
   
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}
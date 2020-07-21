<?php
  
use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
  
class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
        	'name' => 'Abobakr Ahmed', 
        	'email' => 'alsakkaf232@gmail.com',
            'password' => bcrypt('123456'),
            'phone' => '0123123',
            'address' => 'Uni garden 12',
            'status' => 'Approved',
            'icNumber' => '34534'
        ]);
  
        $role = Role::create(['name' => 'Admin']);
   
        $permissions = Permission::pluck('id','id')->all();
  
        $role->syncPermissions($permissions);
   
        $user->assignRole([$role->id]);
    }
}
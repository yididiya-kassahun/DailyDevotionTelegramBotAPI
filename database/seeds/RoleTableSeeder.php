<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user = new Role();
        $role_user->name ='Admin';
        $role_user->description= 'A fellow admin';
        $role_user->save();

        $role_admin = new Role();
        $role_admin->name ='Super Admin';
        $role_admin->description= 'A System admin';
        $role_admin->save();
    }
}

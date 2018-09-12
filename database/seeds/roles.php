<?php

use Illuminate\Database\Seeder;
use App\Role;

class roles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new Role();
        $user->name         = 'user';
        $user->display_name = 'Project user'; // optional
        $user->description  = 'User is the user of a given project'; // optional
        $user->save();

        $admin = new Role();
        $admin->name         = 'admin';
        $admin->display_name = 'User Administrator'; // optional
        $admin->description  = 'admin is allowed to manage and edit other users'; // optional
        $admin->save();

        $super_admin = new Role();
        $super_admin->name         = 'super_admin';
        $super_admin->display_name = 'Project super_admin'; // optional
        $super_admin->description  = 'User is the super_admin of a given project'; // optional
        $super_admin->save();
    }
}

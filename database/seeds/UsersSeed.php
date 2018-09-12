<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UsersSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // \App\User::create([
        //     'name' => 'vikash',
        //     'email' => 'vikash@codilar.com',
        //     'password' => Hash::make('password'),
        // ]);


        $role_user = Role::where('name','user')->first();
        $role_admin = Role::where('name','admin')->first();
        $role_super_admin = Role::where('name','super_admin')->first();

        $admin = new User();
        $admin->name = 'admin';
        $admin->email = 'admin@codilar.com ';
        $admin->password = Hash::make('password');
        $admin->save();
        $admin->roles()->attach($role_user);

        $user = new User();
        $user->name = 'user';
        $user->email = 'user@codilar.com ';
        $user->password = Hash::make('password');
        $user->save();
        $user->roles()->attach($role_admin);

        $super = new User();
        $super->name = 'super';
        $super->email = 'super@codilar.com ';
        $super->password = Hash::make('password');
        $super->save();
        $super->roles()->attach($role_super_admin);


    }
}

<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createPost = new Permission();
        $createPost->name         = 'create-post';
        $createPost->display_name = 'Create Posts'; // optional
        $createPost->description  = 'create new blog posts'; // optional
        $createPost->save();

        $editUser = new Permission();
        $editUser->name         = 'edit-user';
        $editUser->display_name = 'Edit Users'; // optional
        $editUser->description  = 'edit existing users'; // optional
        $editUser->save();

        $editUser = new Permission();
        $editUser->name         = 'delete-user';
        $editUser->display_name = 'Delete Users'; // optional
        $editUser->description  = 'delete existing users'; // optional
        $editUser->save();

        // $admin->attachPermission($createPost);
        // equivalent to $admin->perms()->sync(array($createPost->id));

        // $owner->attachPermissions(array($createPost, $editUser));
        // equivalent to $owner->perms()->sync(array($createPost->id, $editUser->id));
    }
}

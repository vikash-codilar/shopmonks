<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Role;
use App\Permission;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    public function roleBasedUser($userId, $role)
    {
        $user = User::find($userId);
        $role_id = Role::where('name', $role)->first();
        $user->roles()->attach($role_id);
        return $user;
    }

    public function getUserRole($userId)
    {
        return User::find($userId)->roles;
    }

    public function attachPermission(Request $request)
    {
        $parameters = $request->only('permission', 'role');

        $permission_param = $parameters['permission'];
        $role_param = $parameters['role'];

        $role = Role::where('name', $role_param)->first();
        
        $permission = Permission::where('name', $permission_param)->first();

        $role->attachPermission($permission);

        return $role->permissions;
    }

    public function getPermission($roleParam)
    {
        $role = Role::where('name',$roleParam)->first();
        return $role->perms;
    }

    public function getAuthorPage()
    {
        return view('author');
    }

    public function getAdminPage()
    {
        $users = User::all();
        return view('admin', ['users' => $users]);
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

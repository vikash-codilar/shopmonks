<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginIn(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = User::where('email', $request->email)->first();
            return view('home', ['user' => $user]);
        }
        return redirect()->route('login');
    }
    
    public function addNewUser(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->remember_token = $request->_token;
        
        $user->save();
        $user->roles()->attach(Role::where('name', $request->role)->first());
        Auth::login($user);

        $user = User::where('email', $request->email)->first();
        return view('home', ['user' => $user]);
    }
}

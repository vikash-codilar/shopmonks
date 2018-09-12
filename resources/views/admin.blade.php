@extends('layouts.master')

@section('content')


<div class="container">
    <div class="row">
        <div class="col-md-12">
        <form action="{{ route('add-new-user') }}" method="post">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label for="email">E-Mail</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="form-group">
            <label for="sel1">Role</label>
            <select class="form-control" name="role" id="sel1">
                <option value="user">User</option>
                <option value="admin">Admin</option>
                <option value="super_admin">Super Admin</option>
            </select>
        </div>
        {{ csrf_field() }}
        <button type="submit" class="btn btn-default">Sign Up</button>
    </form>

        </div>
    </div>
</div>
    



<!-- <table>
        <thead>
        <th>First Name</th>
        <th>E-Mail</th>
        <th>User</th>
        <th>Author</th>
        <th>Admin</th>
        <th></th>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <form method="post">
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }} <input type="hidden" name="email" value="{{ $user->email }}"></td>
                    <td><input type="checkbox" {{ $user->hasRole('User') ? 'checked' : '' }} name="role_user"></td>
                    <td><input type="checkbox" {{ $user->hasRole('admin') ? 'checked' : '' }} name="role_author"></td>
                    <td><input type="checkbox" {{ $user->hasRole('super_admin') ? 'checked' : '' }} name="role_admin"></td>
                    {{ csrf_field() }}
                </form>
            </tr>
        @endforeach
        </tbody>
    </table> -->

    @endsection
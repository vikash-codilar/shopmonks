@extends('layouts.master')

@section('content')
<header>
    <nav>
        <ul>
        @if($user->hasRole('super_admin') )      
            <li><a href="{{ route('main') }}">Main Page</a></li>
            <li><a href="{{ route('author') }}">super_admin</a></li>
            <li><a href="{{ route('admin') }}">Admin</a></li>
        @elseif($user->hasRole('admin')) 
            <li><a href="{{ route('main') }}">Main Page</a></li>
            <li><a href="{{ route('admin') }}">Admin</a></li>   
        @else        
            <li><a href="{{ route('main') }}">Main Page</a></li>
        @endif
        </ul>
    </nav>
</header>

<h1>welcome to homepage</h1>
@endsection
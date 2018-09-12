<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
    <h5 class="my-0 mr-md-auto font-weight-normal">
        <a href="#">ShopMonk</a>
    </h5>
    <nav class="my-2 my-md-0 mr-md-3">
        @if(isset($user) && $user->hasRole('super_admin') )      
            <a class="p-2 text-dark" href="{{ route('main') }}">Main</a>
            <a class="p-2 text-dark" href="{{ route('author') }}">Admin</a>
            <a class="p-2 text-dark" href="{{ route('admin') }}">Super Admin</a>
        @elseif(isset($user) && $user->hasRole('admin')) 
            <a class="p-2 text-dark" href="{{ route('main') }}">Main</a>
            <a class="p-2 text-dark" href="{{ route('author') }}">Admin</a>
        @elseif(isset($user))        
            <li><a href="{{ route('main') }}">Main</a></li>
        @endif
    </nav>

    @if(!Auth::check())
        <!-- <li><a href="{{ route('signup') }}">Sign Up</a></li> -->
        <a class="btn btn-outline-primary" href="{{ route('login') }}">Sign In</a>
    @else
        <a class="btn btn-outline-primary" href="{{ route('login') }}">Logout</a>
    @endif
</div>
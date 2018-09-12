@extends('layouts.master')

@section('content')

<div class="container">
  <h5>Login User</h5>

  <form action="{{ route('main') }}" method="post">
    <div class="form-group">
      <label for="email">E-Mail</label>
      <input type="email" class="form-control"  id="email" name="email">
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" class="form-control" id="password" name="password">
    </div>
    {{ csrf_field() }}
    <button type="submit" class="btn btn-default">Sign In</button>
  </form>



  <!-- <form method="POST" onsubmit="authenticate()">
  <meta name="csrf-token" content="{{ csrf_token() }}" />

    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
    </div>
    <div class="form-group">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd">
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
  </form> -->
</div>

<script>
    function authenticate() {
        var email = $('#email').val();
        var pwd = $('#pwd').val();
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        
        $.ajax({
            type: 'POST', 
            url : '/login',
            headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
            data:'_token = <?php echo csrf_token() ?>',
            data: { _token : CSRF_TOKEN, email:email, pwd:pwd },
            dataType: 'JSON',
              success : function(response) {
                  console.log(response);
                  window.location = "/";
                  // if (Object.keys(response).length > 0) {
                  //   console.log("You will now be redirected.");
                  //     window.location = "/";
                  // }
              },
              failure: function (response) {
                console.log(response);
              }
  		});

    }
</script>

@endsection

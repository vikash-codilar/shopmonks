<!doctype html>
<html lang="en">
<head>
    <!-- <meta charset="UTF-8"> -->
    <title>ShopMonk</title>
    <!-- <link rel="stylesheet" href="{{ URL::to('src/css/main.css') }}"> -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    

</head>
<body>
@include('header.header')
<div class="main">
    @yield('content')
</div>
</body>
</html>
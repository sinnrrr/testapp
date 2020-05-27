<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>
<body>
<header>
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <a href="{{ url('/home') }}">-> Home <-</a>
            @else
                <a href="{{ route('login') }}">Login</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </div>
    @endif
</header>

<<<<<<< Updated upstream
@include('gmap')

<div class="spacer"></div>
</body>
=======
<div class="gmap-wrapper">
    @include('gmap')
</div>

<div class="spacer"></div>
</body>

<script>
    let xhr = new XMLHttpRequest();

    xhr.open('GET', '/', false);
    xhr.send();

    if (xhr.status !== 200) {
        alert( xhr.status + ': ' + xhr.statusText );
    } else {
        const response = JSON.parse(xhr.response);
        console.log(response)
    }
</script>
>>>>>>> Stashed changes
</html>

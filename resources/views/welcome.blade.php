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
                <a href="{{ url('/home') }}">Home</a>
            @else
                <a href="{{ route('login') }}">Login</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </div>
        @endif
</header>
<div id="map"></div>
<div class="spacer"></div>
<script>
    function initMap() {
        let map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 50.7593, lng: 25.3424},
            zoom: 4
        });
        // let marker = new google.maps.Marker({
        //     position: myLatLng,
        //     map: map,
        //     title: 'Hello World!'
        // });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCtRwPhPwGJgjuQJhNXq__cjCo6oU_XQdM&callback=initMap"
        async defer></script>
</body>
</html>

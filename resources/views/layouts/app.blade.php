<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ secure_asset(mix('css/app.css')) }}" rel="stylesheet">

    <script>
      window.App = {!! json_encode([
          'signedIn' => Auth::check()
      ]) !!};
    </script>
</head>
<body>
  <div id="app">
<nav class="navbar navbar-toggleable-md navbar-inverse bg-faded">
  <span class="navbar-brand" href="#">
    <img src="/storage/images/rise-text-small.png" height="40" class="d-inline-block align-middle" alt="">
  </span>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
    <ul class="navbar-nav my-auto mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li>
    </ul>
    <!-- Authentication Links -->
    @if (Auth::guest())
    <div class="navbar-text my-auto characterMenu">
      <div class="p-1 mx-2 h-100">
          Login with: <a class="bi_battlenet" href="{{ url('/oauth/battlenet') }}">Battle.net</a>
      </div>
    </div>
    @else
      <usermenu :data="{{ json_encode(['id' => auth()->user()->id]) }}"/>
    @endif
  </div>
</nav>
      
    @yield('content')
  </div>

<!-- Scripts -->
<script src="{{ secure_asset(mix('js/app.js')) }}"></script>
</body>
</html>

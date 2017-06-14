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
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">

    <script>
      window.App = {!! json_encode([
          'signedIn' => Auth::check()
      ]) !!};
    </script>
</head>
<body>
  <div id="app">
  <!-- Image and text -->
    <nav class="navbar navbar-inverse bg-faded navbar-static-top" id="navbarNavDropdown">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">
            <img src="/storage/images/rise-text-small.png" height="40" class="d-inline-block align-middle" alt="">
          </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <!-- Authentication Links -->
            @if (Auth::guest())
            <li>Login with:</li>
            <li><a class="bi_battlenet" href="{{ url('/oauth/battlenet') }}">Battle.net</a></li>
            {{-- <li><a href="{{ route('register') }}">Register</a></li> --}}
            @else
            <usermenu :data="{{ auth()->user() }}"/>
            @endif
          </ul>
        </div>          
      </div>
    </nav>
      
    @yield('content')
  </div>

<!-- Scripts -->
<script src="{{ secure_asset('js/app.js') }}"></script>
</body>
</html>

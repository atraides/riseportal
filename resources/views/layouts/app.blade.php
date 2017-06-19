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
          'signedIn' => Auth::check(),
          'user_id' => Auth::check() ? Auth::user()->id : null,
          'user_rank' => Auth::check() ? Auth::user()->getGuildRank() : null
      ]) !!};
    </script>
</head>
<body>
  <div id="app">
   <navbar></navbar>
   @yield('content')
   @if (Auth::check())
    <rlpvote></rlpvote>
    <characters :attributes={{ json_encode([]) }}></characters>
  @endif
  </div>

<!-- Scripts -->
<script src="{{ secure_asset(mix('js/app.js')) }}"></script>
</body>
</html>

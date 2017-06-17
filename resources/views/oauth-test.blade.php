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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

    <script>
      window.App = {!! json_encode([
          'signedIn' => Auth::check()
      ]) !!};
    </script>
</head>
<body>
  <div id="app">
  	<div class="container">
    	<passport-clients></passport-clients>
		<passport-authorized-clients></passport-authorized-clients>
		<passport-personal-access-tokens></passport-personal-access-tokens>
	</div>
  </div>
  
<!-- Scripts -->
<script src="{{ secure_asset(mix('js/app.js')) }}"></script>
</body>
</html>

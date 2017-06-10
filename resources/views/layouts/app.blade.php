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
    <link href="{{ secure_asset('css/materialize.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
            <!-- Dropdown Structure -->
            <ul id='dropdown1' class='dropdown-content'>
                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">Logout</a>
                </li>
                
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </ul>
           <nav>
            <div class="nav-wrapper">
              <a href="#" class="brand-logo">{{ config('app.name', 'Laravel') }}</a>
              <ul id="nav-mobile" class="right hide-on-med-and-down">
              <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li>Login with:</li>
                            <li><a class="bi_battlenet" href="{{ url('/oauth/battlenet') }}">Battle.net</a></li>
                            {{-- <li><a href="{{ route('register') }}">Register</a></li> --}}
                        @else
                            <!-- Dropdown Trigger -->
                            <li>
                                <a class="dropdown-button" href="#!" data-activates="dropdown1">{{ Auth::user()->name }}<i class="material-icons right">arrow_drop_down</i></a>
                            </li>
                        @endif
              </ul>
            </div>
          </nav>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ secure_asset('js/app.js') }}"></script>
    <script src="{{ secure_asset('js/materialize.js') }}"></script>
</body>
</html>

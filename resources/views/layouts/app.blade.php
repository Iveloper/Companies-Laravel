<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

        <!-- Styles -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
                <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
        <script
            src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
            integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
        crossorigin="anonymous"></script>
        
        <style>
            
            body {
                font-family: 'Lato';
            }

            .fa-btn {
                margin-right: 6px;
            }
        </style>
    </head>
    <body id="app-layout">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse" style="margin: 10px;">
                    <!-- Left Side Of Navbar -->

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        @else

                        <ul class="nav navbar-nav">

                            <li><a href="{{ url('/company') }}">{{trans('company.companies')}}</a></li>
                            <li><a href="{{ url('/people') }}">{{trans('company.people')}}</a></li>
                            <li><a href="{{ url('/users') }}">{{trans('company.users')}}</a></li>

                        </ul>
                        <li class="dropdown" style="display: flex;">

                            <a href="{{ route('user_upload', Auth::user()->id) }}"><img src="{{ url('/') }}/uploads/avatars/{{ Auth::user()->username }}/{{ Auth::user()->avatar }}" style="width: 45px; max-height: 40px; border-radius: 89%;"></a>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->username }} <span class="caret"></span>
                            </a>


                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ route('user_edit', Auth::user()->id) }}"><i class="fa fa-btn fa-edit"></i>{{trans('company.edit_profile')}}</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>{{trans('company.logout')}}</a></li>
                            </ul>
                        </li>
<!--                        <a href="{{ route('user_edit', Auth::user()->id) }}"><img src="{{ url('/') }}/uploads/flags/{{ Auth::user()->language_id }}.png" style="width: 45px; max-height: 40px; border-radius: 89%; margin-top: 14px; margin-left: 20px;"></a>-->
                        @foreach ($languageAll as $language => $val)
                        <a href="{{ route('change_language', $val->id) }}"><img src="{{ url('/') }}/uploads/flags/{{ $val->id }}.png" style="width: 25px; max-height: 22px; border-radius: 89%; margin: 16px;"></a>
                        @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="row"> 
                @yield('content')
            </div>
        </div>

        <!-- JavaScripts -->

    </body>
</html>

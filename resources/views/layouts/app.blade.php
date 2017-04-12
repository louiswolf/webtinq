<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="WebTinq is een gratis, online HTML editor voor kinderen, om webpagina's mee te bouwen én direct te publiceren.">

    <title>WebTinq | Websites bouwen voor kinderen</title>
    {!! Html::favicon('favicon.png') !!}

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <style>
        .btn-primary {
            background-color: #cc3c73;
            border-color: #cc3c73;
            color: #ffed66;
        }
        .btn-primary:hover,
        .btn-primary:active,
        .btn-primary:focus {
            background-color: #ffed66;
            border-color: #cc3c73;
            color: #cc3c73;
        }

        .btn-container {
                padding: 10px;
                display: inline-block;
        }

        a,
        a:hover,
        a:active,
        a:focus,
        .btn-link,
        .btn-link:hover,
        .btn-link:active,
        .btn-link:focus {
            color: #cc3c73;
        }

        a.active {
            font-weight: bold;
        }

        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }

        html {
          position: relative;
          min-height: 100%;
        }

        body {
          /* Margin bottom by footer height */
          margin-bottom: 60px;
        }

        h1 {
            font-size: 22px;
            color: #cc3c73;
        }

        .navbar-brand {
            padding-top: 5px;
        }

        #editor { 
            position: relative;
        }

        .footer {
          position: absolute;
          bottom: 0;
          width: 100%;
          /* Set the fixed height of the footer here */
          height: 60px;
          background-color: #f5f5f5;
          border-top: 1px #ccc solid;
          color: #bbb;
          padding-top: 8px;
        }

        .active a {
            font-weight: bold;
            color: #00008B;
        }

        .social a {
            width: 20px;
            display: inline-block;
            font-size: 14px;
        }

        .status-light {
            color: #aaaaaa;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#name').on('input', function() {
                $('#slug').val( $('#name').val().split(' ').join('-').toLowerCase() );
            });
        });
    </script>
    <!-- Piwik -->
    <script type="text/javascript">
        var _paq = _paq || [];
        // tracker methods like "setCustomDimension" should be called before "trackPageView"
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        (function() {
            var u="//piwik.louiswolf.nl/";
            _paq.push(['setTrackerUrl', u+'piwik.php']);
            _paq.push(['setSiteId', '2']);
            var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
            g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
        })();
    </script>
    <!-- End Piwik Code -->
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

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ url('/logo-webtinq.png') }}" width="150">
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">

                <!-- Left Side Of Navbar -->
                @if (!Auth::guest())
                    <ul class="nav navbar-nav">
                        <li><a href="{{ url('/download/instruction') }}" target="_blank">Download Instructie</a></li>
                        <li><a href="{{ url('/contact') }}">Contact</a></li>
                    </ul>
                @endif

            <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/download/instruction') }}" target="_blank">Download Instructie</a></li>
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Registreer</a></li>
                        <li><a href="{{ url('/over') }}">Over</a></li>
                        <li><a href="{{ url('/contact') }}">Contact</a></li>
                    @else
                        @if (!empty(Auth::user()->avatar))
                        <li>
                            <img src="{{ url(str_replace('public', '', Auth::user()->avatar->location)) }}" style="max-width:50px;">
                        </li>
                        @endif
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/dashboard') }}"><i class="fa fa-btn fa-sign-in"></i>Dashboard</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Loguit</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="footer" style="text-align:center;position:absolute;bottom:0;width:100%;height:40px;vertical-align:center;">
        <span style="float:left;margin-left:20px;font-size:14px;">&copy; WebTinq | {{ date( 'Y' ) }}</span>
        <span class="social" style="float:right;margin-right:20px;">
            <a href="https://twitter.com/webtinq" target="_blank"><i class="fa fa-twitter"></i></a>
            <a href="https://facebook.com/webtinq" target="_blank"><i class="fa fa-facebook"></i></a>
            <a href="https://coderdojonederland.slack.com/archives/webtinq" target="_blank"><i class="fa fa-slack"></i></a>
            <a href="https://github.com/louiswolf/webtinq" target="_blank"><i class="fa fa-github"></i></a>
        </span>
    </footer>
    
    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>

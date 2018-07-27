<!DOCTYPE html>
<html lang="en">
@include('layouts.header')

<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container-fluid">
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
                    <img src="images/logo.jpg" width="75" height="75">
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    @if (Auth::guest())
                    <li><a href="{{ url('/home') }}">Home</a></li>
                    @else
                    <li><a href="{{ url('/home') }}">Home</a></li>
                    <li><a href="{{ url('/tasks') }}">Tasks</a></li>
                        @if (Auth::user()->role == 'admin')
                            <li><a href="{{ url('/tasks') }}">Manage Users</a></li>
                        @endif
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="tel:5615551212" class="phone">(561) 555-1212</a></li>
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <!-- oz quick fix span class="caret"></span -->
                            </a>

                            <!-- ul class="dropdown-menu" role="menu"-->
                            <ul>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                    
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    @include('layouts.footer')
    
</body>
</html>

<header>
    <div class="header">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                    <div class="full">
                        <div class="center-desk">
                            <div class="logo">
                                <a href="{{ url('/') }}"><img src="images/logo.png" style="height: 100px; width: 350px; padding-bottom: 40px;"" alt="Logo" /></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                    <nav class="navigation navbar navbar-expand-md navbar-dark ">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarsExample04">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('/') }}">Home</a>
                                </li>
                                <li class="nav-item {{ request()->routeIs('about.details') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('about_details') }}">About</a>
                                </li>
                                <li class="nav-item {{ request()->routeIs('our_room.details') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('our_room_details') }}">Our room</a>
                                </li>
                                <li class="nav-item {{ request()->routeIs('gallery.details') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('gallery_details') }}">Gallery</a>
                                </li>
                                <li class="nav-item {{ request()->routeIs('contact.details') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('contact_details') }}">Contact Us</a>
                                </li>

                                @if (Route::has('login'))
                                    @auth
                                        <li class="nav-item {{ request()->routeIs('my.bookings') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ url('my_bookings') }}">My Bookings</a>
                                        </li>
                                        <li class="nav-item">
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">Logout</button>
                                            </form>
                                        </li>
                                    @else
                                        <li class="nav-item {{ request()->routeIs('login') ? 'active' : '' }}" style="padding-right: 10px">
                                            <a class="btn btn-success" href="{{ url('login') }}">Login</a>
                                        </li>
                                        @if (Route::has('register'))
                                            <li class="nav-item {{ request()->routeIs('register') ? 'active' : '' }}">
                                                <a class="btn btn-primary" href="{{ url('register') }}">Register</a>
                                            </li>
                                        @endif
                                    @endauth
                                @endif
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>


<header class="section-header">
    <section class="header-main border-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-1 col-6 mr-lg-5">
                    <a href="\" class="brand-wrap" >
                        <img class="rounded-5" style="height: 100px" src="{{ asset('assets/images/logos/imagineshirt.png') }}" alt="Shirt Image"
                             style="max-width: 100%; height: auto;">
                    </a> <!-- brand-wrap.// -->
                </div>
                <div class="col-lg-6 col-12 col-sm-12">
                    <form action="#" class="search">
                        <div class="input-group w-100">
                            <input type="text" class="form-control" placeholder="Search">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form> <!-- search-wrap .end// -->
                </div> <!-- col.// -->
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="widgets-wrap float-md-right">
                        <div class="widget-header  mr-3">
                            <a href="{{ route('cart.show') }}"
                               class="icon icon-sm rounded-circle border nav-link {{ Route::currentRouteName() == 'cart.show' ? 'active' : '' }}"><i
                                    class="fa fa-shopping-cart"></i></a>
                            <span
                                class="badge badge-pill badge-danger notify">{{ count(session('cart', [])) }}</span>
                        </div>

                        <div class="widget-header icontext">
                            <a href="#" class="icon icon-sm rounded-circle border"><i
                                    class="fa fa-user"></i></a>
                            <div class="text">
                                <span class="text-muted">Welcome!</span>
                                <!-- Right Side Of Navbar -->
                                <ul class="navbar-nav ms-auto">
                                    <!-- Authentication Links -->
                                    @guest
                                        @if (Route::has('login'))
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                            </li>
                                        @endif

                                        @if (Route::has('register'))
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                   href="{{ route('register') }}">{{ __('Register') }}</a>
                                            </li>
                                        @endif
                                    @else
                                        <li class="nav-item dropdown">
                                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#"
                                               role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                               aria-expanded="false" v-pre>
                                                {{ Auth::user()->name }}
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-end"
                                                 aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="{{ route('logout') }}"
                                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                    {{ __('Logout') }}
                                                </a>

                                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                      class="d-none">
                                                    @csrf
                                                </form>
                                            </div>
                                        </li>
                                    @endguest
                                </ul>
                            </div>
                        </div>
                    </div> <!-- widgets-wrap.// -->
                </div> <!-- col.// -->
            </div> <!-- row.// -->
        </div> <!-- container.// -->
    </section> <!-- header-main .// -->
<nav class="navbar navbar-main navbar-expand-lg navbar-light border-bottom">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav"
                aria-controls="main_nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="main_nav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link"
                       href="\">Main Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="\catalog">Catalog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About Us</a>
                </li>
            </ul>
        </div> <!-- collapse .// -->
    </div> <!-- container .// -->
</nav>
</header>
<!-- section-header.// -->

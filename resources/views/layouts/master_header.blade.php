<!DOCTYPE html>
<html>
<head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    @yield('pageIcon')

    <title>
        @yield('title')
    </title>

    <!-- slider stylesheet -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href={{asset('css/bootstrap.css')}} />

    <!-- Custom styles for this template -->
    <link href={{asset('css/style.css')}} rel="stylesheet" />
    <!-- responsive style -->
    <link href={{asset('css/responsive.css')}} rel="stylesheet" />

</head>
<body>
<div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
            <a class="navbar-brand" href={{route('home')}}>
          <span>
            Ecommerce
          </span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class=""></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav  ">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{route('home')}}">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('shop')}}">
                            Shop
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('why')}}">
                            Why Us
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('test')}}">
                            Testimonial
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('contact')}}">Contact Us</a>
                    </li>
                </ul>
            <div class="user_option">
                @if(Route::has('login'))
                    @auth
                        <a href="" class="nav-item">{{ Auth::user()->first_name }}</a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                        <a href="{{route('myCart')}}">
                            <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                            [{{$count}}]
                        </a>
                        <a href="{{route('myOrders')}}">
                            My orders
                        </a>
                        <form class="form-inline ">
                            <button class="btn nav_search-btn" type="submit">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                    @else

                    <a href="{{url('/login')}}">
                        <i class="fa fa-user" aria-hidden="true"></i>
             <span>
                     Login
                 <a href="{{url('/register')}}">
                        <i class="fa fa-vcard" aria-hidden="true"></i>
                        <span>
                                register
                        </span>
                </a>
                 @endauth
                 @endif
                    </form>


            </div>
            </div>
        </nav>
    </header>
</div>
@yield('content')
</body>
</html>

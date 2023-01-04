@php
    use App\Models\Admin\ProductSection;
    $navsections = ProductSection::all();
@endphp



<body style="position: relative;">
    <div id="loading"
        style="display: none;position: absolute; height: 100vh; width: 100vw;  top: 0; left: 0; z-index:1;">
        <img style="position: absolute; top: 50%; left: 50%;" src="{{ asset('images/loading.gif') }}" alt="">
    </div>
    <script>
        function loading() {
            let loading = document.getElementById('loading');
            if (loading.style.display != 'none') {
                loading.style.display = 'none'
            } else {
                loading.style.display = 'block'
            }
        }
        loading();
    </script>
    <div id="header">

        <div class="container">
            <div id="welcomeLine" class="row">

                <div class="span6">Welcome!<strong>
                        @guest
                            User
                        @endguest
                        @auth
                            {{ Auth::user()->name }}
                        @endauth

                    </strong></div>

                <div class="span6">
                    <div class="pull-right">
                        <a href="{{ route('frontend.cart.index') }}"><span class="btn btn-mini btn-primary"><i
                                    class="icon-shopping-cart icon-white"></i> [
                                <span class="cartitem">
                                    @if (Session::has('numberOfCartItem'))
                                        {{ Session::get('numberOfCartItem') }}
                                    @else
                                        0
                                    @endif
                                </span> ] Items in your cart </span> </a>
                    </div>
                </div>
            </div>
            <!-- Navbar ================================================== -->
            <section id="navbar">
                <div class="navbar">
                    <div class="navbar-inner">
                        <div class="container">
                            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </a>
                            <a class="brand" href="{{ route('frontend.index') }}">AdvEcommerce</a>
                            <div class="nav-collapse">
                                <ul class="nav">
                                    <li class="active"><a href="{{ route('frontend.index') }}">Home</a>
                                    </li>

                                    @foreach ($navsections as $section)
                                        @if (count($section->product_categories) > 0)
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle"
                                                    data-toggle="dropdown">{{ $section->title }} <b
                                                        class="caret"></b></a>
                                                <ul class="dropdown-menu">
                                                    @foreach ($section->product_categories as $category)
                                                        <li class="divider"></li>
                                                        <li class="nav-header"><a
                                                                href="{{ url('c/' . $category->url) }}"><strong>{{ $category->title }}</strong></a>
                                                        </li>
                                                        @foreach ($section->product_sub_categories as $sub_cat)
                                                            @if ($sub_cat->product_categories_id == $category->id)
                                                                @if (count($sub_cat->products) > 0)
                                                                    <li><a href="{{ url('s/' . $sub_cat->url) }}">>
                                                                            {{ $sub_cat->title }}</a></li>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                        <li class="divider"></li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endif
                                    @endforeach

                                    <li><a href="#">About</a></li>
                                </ul>
                                <form class="navbar-search pull-left" action="#">
                                    <input type="text" class="search-query span2" placeholder="Search" />
                                </form>
                                <ul class="nav pull-right">
                                    <li><a href="#">Contact</a></li>
                                    <li class="divider-vertical"></li>
                                    @auth
                                        <li><a href="{{ route('frontend.user.account') }}">My Account</a></li>
                                        <li class="divider-vertical"></li>
                                        <li><a href="{{ route('frontend.user.logout') }}">Logout</a></li>
                                    @endauth
                                    @guest
                                        <li><a href="{{ route('frontend.logreg.index') }}">Login / Register</a></li>
                                    @endguest
                                </ul>
                            </div><!-- /.nav-collapse -->
                        </div>
                    </div><!-- /navbar-inner -->
                </div><!-- /navbar -->
            </section>
        </div>
    </div>

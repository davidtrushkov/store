<!-- Navigation -->
<nav class="navbar z-depth-2" id="nav-bar-id">
    <div class="container-fluid" style="width: 90%;">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand waves-effect waves-light" href="{{ url('/') }}" id="nav-bar-logo"><i class="material-icons md-48">whatshot</i></a>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                @if (!$signedIn)
                    <li><a href="{{ url('/login') }}" class="btn-flat" id="nav-bar-Login">Login</a></li>
                    <li><a href="{{ url('/register') }}" class="btn btn-primary waves-effect waves-light">Register</a></li>
                @else
                    <li><a href="{{ route('cart') }}"><i class="material-icons" style="color: black;">shopping_basket</i><span class="badge green">{{ $cart_count }}</span>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle btn btn-sm btn-primary waves-effect waves-light" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            {{ $user->username }} <span class="caret"></span></a>
                        <ul class="dropdown-menu" id="dropdwon">
                            <li><a href="{{ url('/profile') }}">Profile</a></li>
                            <li><a href="{{ url('/logout') }}">Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
            <ul class="nav navbar-nav navbar-right" id="navbar-right">
                <li id="search-li">
                    @include('pages.partials.search_box')
                </li>
            </ul>
        </div>

    </div>
</nav>
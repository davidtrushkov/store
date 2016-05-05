@extends('app')

@section('content')


    <div id="wrapper">

        @include('pages.partials.side-nav')

       <!-- Button to toggle side-nav -->
        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle"><i class="fa fa-bars fa-5x"></i></a>

        <div class="container-fluid">

            <h4 class="h4-responsive">Your Cart</h4><br>

            @include('cart.partials.cart_table')


            @if ($cart_total === 0)
                <a href="{{ url('/') }}" class="btn btn-primary">Continue Shopping</a>
            @else
                <a href="{{ url('/') }}" class="btn btn-primary">Continue Shopping</a>
                <a href="{{ route('checkout') }}" class="btn btn-default">Checkout</a>
            @endif

            <br><br><br>

        </div>  <!-- close container -->

    </div>  <!-- close wrapper -->

@stop

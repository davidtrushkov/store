@extends('app')

@section('content')

<div id="wrapper">

    @include('pages.partials.side-nav')
    @include('pages.partials.carousel')

    @include('pages.partials.mobile-header')

    <!-- Button to toggle side-nav -->
    <a href="#menu-toggle" class="btn btn-default" id="menu-toggle"><i class="fa fa-bars fa-5x"></i></a>

    <!-- Featured Products section -->
    @include('pages.partials.featured')

    <section class="parallax" id="section2">
        <div class="carousel-caption hidden-xs" id="brand-caption">
            <div class="animated fadeInDown">
                <h3><strong><span class="color">Shop By Brands</span></strong></h3>
                @foreach($rand_brands as $rand)
                    <h6 id="random_brands"><a href="{{ url('brand', $rand->id) }}">{{ $rand->brand_name }}</a></h6>
                @endforeach
            </div>
        </div>
    </section>

    @include('pages.partials.mobile-parallax')

    <!-- New Products section -->
    @include('pages.partials.new')


    @include('pages.partials.footer')

    </div>  <!-- close wrapper -->

@stop

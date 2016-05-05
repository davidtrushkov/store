@extends('admin.dash')

@section('content')

    <div class="container" id="admin-brand-container">

        <br><br>
        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle"><i class="fa fa-bars fa-5x"></i></a>
        <a href="{{ url('admin/brands') }}" class="btn btn-danger">Back</a>
        <br><br>

        <div class="col-xs-12 col-sm-9 col-md-9" id="admin-brand-container">

            <ul class="collection with-header">
                <li class="collection-header">
                    @foreach($brands as $brand)
                        <h5 class="text-center">ALL PRODUCTS UNDER  - <b>{{ $brand->brand_name }}</b> - BRAND</h5>
                    @endforeach
                </li>
                @if ($count === 0)
                    <h6 class="text-center">There are no products under this brand</h6>
                @else()
                    <?php $i = 1; ?>
                    @foreach($products as $product)
                        <li class="collection-item">
                            # {{ $i }}&nbsp;&nbsp;&nbsp;
                            <a href="{{ route('admin.product.edit', $product->id) }}" id="Show-Product-Under-Sub-Category">
                                {{$product->product_name}}
                            </a>
                        </li>
                        <?php $i++; ?>
                    @endforeach
                @endif
            </ul>


        </div>  <!-- close col-md-9 -->
    </div>  <!-- close container -->

@endsection
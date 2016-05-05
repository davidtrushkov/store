@extends('admin.dash')

@section('content')

    <div class="container-fluid" id="admin-product-container">

        <br><br>
        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle"><i class="fa fa-bars fa-5x"></i></a>
        <a href="{{ url('admin/product/add') }}" class="btn btn-primary">Add new Product</a>
        <br><br>

        <h6>There are {{ $productCount }} products</h6><br>


        <table class="table table-bordered table-condensed table-hover">
            <thead>
            <tr>
                <th class="text-center blue white-text">Delete</th>
                <th class="text-center blue white-text">Edit</th>
                <th class="text-center blue white-text">Images</th>
                <th class="text-center blue white-text">Image</th>
                <th class="text-center blue white-text">Name</th>
                <th class="text-center blue white-text" id="td-display-mobile">Price</th>
                <th class="text-center blue white-text" id="td-display-mobile">Featured</th>
            </tr>
            </thead>
            <tbody>
            @foreach($product as $products)
            <tr>
                <td class="text-center">
                    <form method="post" action="{{ route('admin.product.delete', $products->id) }}" class="delete_form_product">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="DELETE">
                        <button id="delete-product-btn">
                            <i class="material-icons red-text">delete_forever</i>
                        </button>
                    </form>
                </td>
                <td class="text-center">
                    <a href="{{ route('admin.product.edit', $products->id) }}">
                        <i class="material-icons green-text">mode_edit</i>
                    </a>
                </td>
                <td class="text-center">
                    <a href="{{ URL('/admin/products', $products->id) }}">
                        <i class="material-icons">add_a_photo</i>
                    </a>
                </td>
                <td class="text-center" style="width: 20%;">
                    @if ($products->photos->count() === 0)
                        No Images
                    @else
                        @if ($products->featuredPhoto)
                            <img src="/store/{{ $products->featuredPhoto->thumbnail_path }}" alt="Photo ID: {{ $products->featuredPhoto->id }}" />
                        @elseif(!$products->featuredPhoto)
                            <img src="/store/{{ $products->photos->first()->thumbnail_path}}" alt="Photo" />
                        @else
                            N/A
                        @endif
                    @endif
                </td>
                <td class="text-center">{{ $products->product_name }}</td>
                <td class="text-center" id="td-display-mobile">
                    @if($products->reduced_price == 0)
                        $ {{ $products->price }}
                    @else
                        <div class="text-danger list-price"><s>$ {{ $products->price }}</s></div>
                        $ {{ $products->reduced_price }}
                    @endif
                </td>
                <td class="text-center" id="td-display-mobile">
                    @if ($products->featured == 1)
                        Yes
                    @else
                        No
                    @endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>

        {!! $product->links() !!}

    </div>

@endsection
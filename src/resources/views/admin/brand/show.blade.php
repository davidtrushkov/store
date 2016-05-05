@extends('admin.dash')

@section('content')

    <div class="container-fluid" id="admin-brand-container">
            <br><br>
        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle"><i class="fa fa-bars fa-5x"></i></a>
        <a href="{{ url('admin/brands/create') }}" class="btn btn-primary">Add new Brand</a>
            <br><br>

        <div class="col-md-9" id="admin-brand-container">

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th class="text-center blue white-text"></th>
                    <th class="text-center blue white-text"></th>
                    <th class="text-center blue white-text"></th>
                    <th class="text-center blue white-text">Brands</th>
                    <th class="text-center blue white-text" id="td-display-mobile"># Products</th>
                </tr>
                </thead>
                <tbody>
                @foreach($brands as $brand)
                <tr>
                    <td class="text-center">
                        <form method="post" action="{{ route('admin.brand.delete', $brand->id) }}" class="delete_form_brand">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="DELETE">
                            <button id="delete-btn-brand">
                                <i class="material-icons red-text">delete_forever</i>
                            </button>
                        </form>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.brands.edit', $brand->id) }}">
                            <i class="material-icons green-text">mode_edit</i>
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.brand.products', $brand->id) }}">
                            <i class="material-icons">remove_red_eye</i>
                        </a>
                    </td>
                    <td class="text-center">{{ $brand->brand_name }}</td>
                    <td class="text-center" id="td-display-mobile">
                        {{ $brand->productBrand->count() }}
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>

        </div>

    </div>  <!-- close container -->

@endsection

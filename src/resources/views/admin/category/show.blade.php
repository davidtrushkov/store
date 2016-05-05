@extends('admin.dash')

@section('content')

    <div class="container-fluid" id="admin-category-container">
            <br><br>
        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle"><i class="fa fa-bars fa-5x"></i></a>
        <a href="{{ url('admin/categories/add') }}" class="btn btn-primary">Add new Category</a>
            <br><br>

        <div class="col-md-10" id="admin-category-container">
        <ul class="collection with-header">
            @foreach ($categories as $category)
            <li class="collection-item blue">
                <h5 class="white-text">
                    {{ $category->category }}
                </h5>
                <li class="collection-item primary-color">
                    <div class="col-xs-3 col-sm-2 col-md-2">
                        <form method="post" action="{{ route('admin.category.delete', $category->id) }}" class="delete_form">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="delete-btn">
                                <i class="material-icons delete-white">delete_forever</i>
                            </button>
                        </form>
                    </div>
                    <a href="{{ route('admin.category.edit', $category->id) }}">
                        <i class="material-icons edit-white">mode_edit</i>
                    </a>
                    <a href="{{ route('admin.category.addsub', $category->id) }}" id="sub-category">+ Sub-Category</a>
                </li>
            </li>
                @foreach ($category->children as $children)
                <li class="collection-item">
                        <a href="{{ route('admin.category.editsub', $children->id) }}">
                            <i class="material-icons edit">mode_edit</i>
                        </a>&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="{{ route('admin.category.products', $children->id) }}">
                            <i class="material-icons">remove_red_eye</i>
                        </a>
                        &nbsp;&nbsp;&nbsp;&nbsp;{{ $children->category }}
                        <a href="#!" class="secondary-content">
                            <form method="post" action="{{ route('admin.category.deletesub', $children->id) }}" class="delete_form_sub">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="DELETE">
                                <button class="delete-btn-sub">
                                    <i class="material-icons delete">delete_forever</i>
                                </button>
                            </form>
                        </a>
                </li>
                @endforeach
            @endforeach
        </ul>
        </div>

    </div>  <!-- close container -->

@endsection

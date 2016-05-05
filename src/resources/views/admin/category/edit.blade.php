@extends('admin.dash')

@section('content')

    <div class="container" id="admin-category-container">

        <br><br>
        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle"><i class="fa fa-bars fa-5x"></i></a>
        <a href="{{ url('admin/categories') }}" class="btn btn-danger">Back</a>
        <br><br>

        <div class="col-sm-8 col-md-9" id="admin-category-container">
            <ul class="collection with-header">
                <form role="form" method="POST" action="{{ route('admin.category.update', $category->id) }}">
                    {{ csrf_field() }}
                    <li class="collection-item blue">
                        <h4 class="white-text text-center">
                            Edit Category
                        </h4>
                    </li>
                    <li class="collection-item">
                        <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                            <input type="text" class="form-control" name="category"  value="{{  Request::old('category') ? : $category->category }}" placeholder="Edit Category">
                            @if($errors->has('category'))
                                <span class="help-block">{{ $errors->first('category') }}</span>
                            @endif
                        </div>
                    </li>
                    <li class="collection-item blue">
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-link grey lighten-5">Edit Category</button>
                        </div>
                    </li>
                </form>
            </ul>
        </div>

    </div>

@endsection
@extends('admin.dash')

@section('content')

    <div class="container" id="admin-brand-container">

        <br><br>
        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle"><i class="fa fa-bars fa-5x"></i></a>
        <a href="{{ url('admin/brands') }}" class="btn btn-danger">Back</a>
        <br><br>

        <h4 class="text-center">Add new Brand</h4><br><br>

        <div class="col-md-12" id="admin-brand-container">

            <form role="form" method="POST" action="{{ url('admin/brands') }}">
                {{ csrf_field() }}

                <div class="col-sm-8 col-md-8 col-md-offset-2 text-center">
                    <div class="form-group{{ $errors->has('brand_name') ? ' has-error' : '' }}">
                        <input type="text" class="form-control" name="brand_name" value="{{ old('brand_name') }}" placeholder="Add New Brand">
                        @if($errors->has('brand_name'))
                            <span class="help-block">{{ $errors->first('brand_name') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group col-sm-8 col-md-8 col-md-offset-2 text-center">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Create Brand</button>
                </div>

            </form>

        </div> <!-- Close col-md-12 -->

    </div>  <!-- Close container -->
@endsection

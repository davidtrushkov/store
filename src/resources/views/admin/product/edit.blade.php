@extends('admin.dash')

@section('content')

    <div class="container" id="admin-product-container">

        <br><br>
        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle"><i class="fa fa-bars fa-5x"></i></a>
        <a href="{{ url('admin/products') }}" class="btn btn-danger">Back</a>
        <br><br>

        <h4 class="text-center">Edit {{ $product->product_name }}</h4><br><br>

        <div class="col-md-12">

            <form role="form" method="POST" action="{{ route('admin.product.update', $product->id) }}">
                {{ csrf_field() }}

                <div class="col-sm-6 col-md-6" id="Product-Input-Field">
                    <div class="form-group{{ $errors->has('product_name') ? ' has-error' : '' }}">
                        <label>Product Name</label>
                        <input type="text" class="form-control" name="product_name" value="{{ Request::old('product_name') ? : $product->product_name }}" placeholder="Edit New Product">
                        @if($errors->has('product_name'))
                            <span class="help-block">{{ $errors->first('product_name') }}</span>
                        @endif
                    </div>
                </div>

                <div class="col-sm-6 col-md-6" id="Product-Input-Field">
                    <div class="form-group{{ $errors->has('brand_id') ? ' has-error' : '' }}">
                        <label>Brand</label>
                        <select class="form-control" name="brand_id" id="brand_id">
                            <option value=""></option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? "selected" : "" }}>{{ $brand->brand_name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('brand_id'))
                            <span class="help-block">{{ $errors->first('brand_id') }}</span>
                        @endif
                    </div>
                </div>

                <div class="col-sm-6 col-md-6" id="Product-Input-Field">
                    <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                        <label>Price</label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="material-icons">attach_money</i></div>
                            <input type="text" class="form-control" name="price" value="{{ Request::old('price') ? : $product->price }}" placeholder="Edit Product Price">
                        </div>
                        @if($errors->has('price'))
                            <span class="help-block">{{ $errors->first('price') }}</span>
                        @endif
                    </div>
                </div>


                <div class="col-sm-6 col-md-6" id="Product-Input-Field">
                    <div class="form-group{{ $errors->has('reduced_price') ? ' has-error' : '' }}">
                        <label>Reduced Price</label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="material-icons">attach_money</i></div>
                            <input type="text" class="form-control" name="reduced_price" value="{{ Request::old('reduced_price') ? : $product->reduced_price }}" placeholder="Edit Product Reduced Price">
                        </div>
                        @if($errors->has('reduced_price'))
                            <span class="help-block">{{ $errors->first('reduced_price') }}</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-12" id="category-dropdown-container">

                    <div class="col-sm-6 col-md-6" id="Product-Input-Field">
                        <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                            <label>Parent Category</label>
                            <select class="form-control" name="category" id="category" data-url="{{ url('api/dropdown')}}">
                                <option value=""></option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                                @endforeach
                            </select>
                             @if($errors->has('category'))
                                <span class="help-block">{{ $errors->first('category') }}</span>
                            @endif
                        </div>
                        <br>
                    </div>

                    <div class="col-sm-6 col-md-6" id="Product-Input-Field">
                        <div class="form-group{{ $errors->has('cat_id') ? ' has-error' : '' }}">
                            <label>Sub-Category Category</label>
                            <select class="form-control" name="cat_id" id="sub_category">
                                <option value=""></option>
                            </select>
                            @if($errors->has('cat_id'))
                                <span class="help-block">{{ $errors->first('cat_id') }}</span>
                            @endif
                        </div>
                        <br>
                    </div>

                </div>

                <div class="col-sm-3 col-md-3" id="Product-Input-Field">
                    <div class="form-group">
                        <label>Featured Product</label><br>
                        <input type="checkbox" name="featured" value="1" {{ $product->featured === 1 ? "checked=checked" : "" }}>
                    </div>
                </div>

                <div class="col-sm-3 col-md-3" id="Product-Input-Field">
                    <div class="form-group{{ $errors->has('product_qty') ? ' has-error' : '' }}">
                        <label>Product Quantity</label>
                        <input type="number" class="form-control" name="product_qty" value="{{ Request::old('product_qty') ? : $product->product_qty }}" placeholder="Edit Product Quantity" min="0">
                        @if($errors->has('product_qty'))
                            <span class="help-block">{{ $errors->first('product_qty') }}</span>
                        @endif
                    </div>
                </div>


                <div class="col-sm-6 col-md-6" id="Product-Input-Field">
                    <div class="form-group{{ $errors->has('product_sku') ? ' has-error' : '' }}">
                        <label>Product SKU</label>
                        <input type="text" class="form-control" name="product_sku"  id="product_sku" value="{{ Request::old('product_sku') ? : $product->product_sku }}" placeholder="Generate Product SKU" readonly="readonly">
                        <button class="btn btn-info btn-sm waves-effect waves-light" onclick="GetRandom()" type="button" id="product_sku">generate</button>
                        @if($errors->has('product_sku'))
                            <span class="help-block">{{ $errors->first('product_sku') }}</span>
                        @endif
                    </div>
                </div>

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">DESCRIPTION</a></li>
                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">SPECS</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">

                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description">Product Description</label>
                                <textarea id="product-description" name="description">
                                    {{ Request::old('description') ? : $product->description }}
                                </textarea>
                                @if($errors->has('description'))
                                    <span class="help-block">{{ $errors->first('description') }}</span>
                                @endif
                            </div>
                        </div>

                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile">


                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('product_spec') ? ' has-error' : '' }}">
                                <label for="product_spec">Product Specs - <i>Optional</i></label>
                                <textarea id="product_spec" name="product_spec">
                                    {{ Request::old('product_spec') ? : $product->product_spec }}
                                </textarea>
                                @if($errors->has('product_spec'))
                                    <span class="help-block">{{ $errors->first('product_spec') }}</span>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>


                <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Edit Product</button>
                </div>

            </form>

        </div> <!-- Close col-md-12 -->

    </div>  <!-- Close container -->
@endsection

@section('footer')
        <!-- Include Froala Editor JS files. -->
    <script type="text/javascript" src="{{ asset('src/public/js/libs/froala_editor.min.js') }}"></script>

    <!-- Include Plugins. -->
    <script type="text/javascript" src="{{ asset('src/public/js/plugins/align.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('src/public/js/plugins/char_counter.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('src/public/js/plugins/font_family.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('src/public/js/plugins/font_size.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('src/public/js/plugins/line_breaker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('src/public/js/plugins/lists.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('src/public/js/plugins/paragraph_format.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('src/public/js/plugins/paragraph_style.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('src/public//js/plugins/quote.min.js') }}"></script>


    <script>
        $(function() {
            $('#product-description').froalaEditor({
                charCounterMax: 2500,
                height: 500,
                codeBeautifier: true,
                placeholderText: 'Edit Product description...',
            })
        });
    </script>

    <script>
        $(function() {
            $('#product_spec').froalaEditor({
                charCounterMax: 3500,
                height: 500,
                codeBeautifier: true,
                placeholderText: 'Edit Product specs...',
            })
        });
    </script>

@endsection

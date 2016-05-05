@extends('app')

@section('content')

    <div id="wrapper">

        @include('pages.partials.side-nav')

        <!-- Button to toggle side-nav -->
        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle"><i class="fa fa-bars fa-5x"></i></a>
        <a href="{{ URL::previous() }}" class="btn btn-warning" id="menu-toggle"><i class="fa fa-arrow-left fa-5x" aria-hidden="true"></i></a>

        <div class="container-fluid">

            <div class="col-md-12">

                <div class="col-xs-12 col-sm-12 col-md-8 gallery">
                    @if ($product->photos->count() === 0)
                        <p>No Images found for this Product.</p><br>
                        <img src="/store/src/public/images/no-image-found.jpg" alt="No Image Found Tag" id="Product-similar-Image">
                    @else
                        @foreach ($product->photos->slice(0, 8) as $photo)
                            <div class="col-xs-6 col-sm-4 col-md-3 gallery_image text-center">
                                <a href="/store/{{ $photo->path }}" data-lity>
                                    <img src="/store/{{ $photo->thumbnail_path }}" alt="Photo ID: {{ $photo->id  }}" data-id="{{ $photo->id }}" class="img-thumbnail">
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="col-sm-12 col-md-4">
                    <h5 id="Product_Name">{{ $product->product_name }}</h5>
                    <p id="Product_Brand">Brand: {{ $product->brand->brand_name }}</p>
                    <p id="Product_ISBN">ISBN: {{ $product->product_sku }}</p>
                    <br>
                    @if($product->reduced_price == 0)
                        <div class="light-300 black-text medium-500" id="Product_Reduced-Price">$ {{  $product->price }}</div>
                        <br>
                    @else
                        <div class="discount light-300 black-text medium-500" id="Product_Reduced-Price"><s>$ {{ $product->price }}</s></div>
                        <div class="green-text medium-500" id="Product_Reduced-Price">$ {{ $product->reduced_price }}</div>
                    @endif
                    <hr>

                    @if ($product->product_qty == 0)
                        <h5 class="text-center red-text">Sold Out</h5>
                        <p class="text-center"><b>Available: {{ $product->product_qty }}</b></p>
                    @else
                        <form action="/store/cart/add" method="post" name="add_to_cart">
                            {!! csrf_field() !!}
                            <input type="hidden" name="product" value="{{$product->id}}" />
                            <label>QTY</label>
                            <select name="qty" class="form-control" id="Product_QTY" title="Product Quantity">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>

                            <br><br>

                            <p><b>Available: {{ $product->product_qty }}</b></p>

                            <button class="btn btn-default waves-effect waves-light">ADD TO CART</button>
                        </form>
                    @endif

                </div>

            </div>  <!-- close col-md-12 -->


            <div class="col-md-12">

                <div class="col-sm-12 col-md-8" id="Product-Description-Container">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#product_description" aria-controls="home" role="tab" data-toggle="tab">DESCRIPTION</a></li>
                        <li role="presentation"><a href="#product_spec" aria-controls="profile" role="tab" data-toggle="tab">SPECS</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="product_description">
                            {!! $product->description !!}
                        </div>
                        <div role="tabpanel" class="tab-pane" id="product_spec">
                            {!! $product->product_spec !!}
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-4" id="Similar-Products-Container">

                    <h6 class="text-center">SIMILAR PRODUCTS</h6><br>

                    @foreach($similar_product->slice(0, 4) as $similar)
                        <div class="col-xs-6 col-md-6 text-center" id="Similar-Product-Sub-Container">
                            <a href="{{ route('show.product', $similar->product_name) }}">
                                @if ($similar->photos->count() === 0)
                                    <p id="Similar-Title">{{ str_limit($similar->product_name, $limit = 28, $end = '...') }}</p>
                                    <img src="/store/src/public/images/no-image-found.jpg" alt="No Image Found Tag" id="Product-similar-Image">
                                @else
                                    @if ($similar->featuredPhoto)
                                        <p id="Similar-Title">{{ str_limit($similar->product_name, $limit = 28, $end = '...') }}</p>
                                        <img src="/store/{{ $similar->featuredPhoto->thumbnail_path }}" alt="Photo ID: {{ $similar->featuredPhoto->id }}" id="Product-similar-Image" />
                                    @elseif(!$similar->featuredPhoto)
                                        <p id="Similar-Title">{{ $similar->product_name }}</p>
                                        <img src="/store/{{ $similar->photos->first()->thumbnail_path}}" alt="Photo" id="Product-similar-Image" />
                                    @else
                                        N/A
                                    @endif
                                @endif
                            </a>
                        </div>
                    @endforeach

                </div>

            </div>  <!-- close col-md-12 -->

            <br><br><hr>

        </div>  <!-- close container-fluid -->

        <div class="container-fluid" id="comments-container">
            <div class="col-md-12">
                <div id="disqus_thread"></div>
            </div>
        </div>

        @include('pages.partials.footer')

    </div>  <!-- close wrapper -->


    <script>
        /**
         * RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
         * LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables
         */
        /*
         var disqus_config = function () {
         this.page.url = PAGE_URL; // Replace PAGE_URL with your page's canonical URL variable
         this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
         };
         */
        (function() { // DON'T EDIT BELOW THIS LINE
            var d = document, s = d.createElement('script');

            s.src = '//httpdavidtrushkovcomstore.disqus.com/embed.js';

            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>

@stop
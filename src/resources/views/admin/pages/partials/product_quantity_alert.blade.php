
@if ($product_quantity->count() == 0)
    <p>All products are stocked</p>
@else
    <table class="table table-bordered table-responsive table-condensed">
        <thead>
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Product QTY</th>
            <th>Update QTY</th>
        </tr>
        </thead>
        <tbody>
        @foreach($product_quantity as $product)
            <tr>
                <td>#{{ $product->id }}</td>
                <td>{{ $product->product_name }}</td>
                <td>{{ $product->product_qty }}</td>
                <td>
                    <form action="update" method="post" class="form-inline">
                        {{ csrf_field() }}
                        <input type="hidden" name="product" value="{{ $product->id }}" />
                        <div class="form-group{{ $errors->has('product_qty') ? ' has-error' : '' }}">
                            <input type="number" name="product_qty" class="form-control" title="Product Quantity" min="0">
                            @if($errors->has('product_qty'))
                                <span class="help-block">{{ $errors->first('product_qty') }}</span>
                            @endif
                            <button class="btn btn-sm btn-default"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                        </div>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
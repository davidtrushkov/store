
@if ($carts->count() == 0)
    <p>No active Carts found</p>
@else
    <table class="table table-bordered table-responsive table-condensed">
        <thead>
        <tr>
            <th></th>
            <th>Cart ID</th>
            <th>Username</th>
            <th>Products</th>
            <th>Quantity</th>
            <th>Created At</th>
        </tr>
        </thead>
        <tbody>
            @foreach($carts as $cart)
            <tr>
                <td class="text-center">
                    <form method="post" action="{{ route('admin.cart.delete', $cart->id) }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="DELETE">
                        <button id="delete-cart-btn">
                            <i class="material-icons red-text">delete_forever</i>
                        </button>
                    </form>
                </td>
                <td>#{{ $cart->id }}</td>
                <td>{{ $cart->user->username }}</td>
                <td>{{ $cart->products->product_name }}</td>
                <td>{{ $cart->qty }}</td>
                <td>{{ prettyDate($cart->created_at) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif
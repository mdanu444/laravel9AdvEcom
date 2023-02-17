@php
    use App\Models\Cart;
@endphp

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Product</th>
            <th>Description</th>
            <th>Quantity/Update</th>
            <th>Price <br>Per Unit</th>
            <th>Discount <br> Per Unit</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totalAmount = 0;
            $total_quantity = 0;
            $productDiscount = 0;
            $grandTotal = 0;
        @endphp
        @foreach ($cartitems as $cartitem)
            @php
                // product attribute discount
                $total_quantity += $cartitem->quantity;
                $CartProduct = Cart::getCartProducts($cartitem->products_id, $cartitem->attributes_id);
            @endphp
            <tr>
                <td> <img width="60"
                        src="{{ url('images/product_image/small/' . $CartProduct['product']->image) }}"
                        alt="" /></td>
                <td>{{ $CartProduct['product']->title }}({{ $CartProduct['attribute']->sku }})<br />Color
                    :
                    {{ $CartProduct['product']->color }}
                    <br>Size : {{ $CartProduct['attribute']->size }}
                </td>
                <td>
                    {{ $cartitem->quantity }}
                </td>
                @php
                    $totalAmount += $cartitem->quantity * ($cartitem->price - $cartitem->price * ($CartProduct['discount'] / 100));
                    $productDiscount = $cartitem->price * ($CartProduct['discount'] / 100);
                    $grandTotal = ($totalAmount - $productDiscount)+Session::get('shipping_charge');
                @endphp

                <td>Rs.{{ number_format($cartitem->price, 2) }}</td>
                <td>Rs.{{ number_format($cartitem->price * ($CartProduct['discount'] / 100), 2) }}</td>
                <td>Rs.{{ number_format($cartitem->quantity * ($cartitem->price - $cartitem->price * ($CartProduct['discount'] / 100)), 2) }}
                </td>
            </tr>
        @endforeach

        <tr>
            <td colspan="5" style="text-align:right">Total Price: </td>
            <td> Rs. {{ number_format($totalAmount, 2) }}</td>
        </tr>
        <tr>
            <td colspan="5" style="text-align:right">Coupon Discount: </td>
            <td> Rs.
                @if (Session::has('coupon_amount'))
                    {{ number_format(Session::get('coupon_amount'), 2) }}
                @else
                    {{ number_format(0, 2) }}
                @endif
            </td>
        </tr>
        <tr>
            <td colspan="5" style="text-align:right">Shipping Charge: </td>
            <td> Rs.
                @if (Session::has('shipping_charge'))
                    {{ number_format(Session::get('shipping_charge'), 2) }}
                @else
                    {{ number_format(0, 2) }}
                @endif
            </td>
        </tr>
        <tr>
            <td colspan="5" style="text-align:right"><strong>GRAND TOTAL (Total Price - Coupon Discount)
                    =</strong>
            </td>
            <td class="label label-important" style="display:block"> <strong> Rs.
                    @if (Session::has('grandTotal'))
                        {{ number_format((Session::get('grandTotal') + Session::get('shipping_charge')), 2) }}
                    @else
                        {{ number_format(0, 2) }}
                    @endif

                </strong></td>
        </tr>
    </tbody>
</table>

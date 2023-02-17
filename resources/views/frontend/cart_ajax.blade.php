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
                <td> <img width="60" src="{{ url('images/product_image/small/' . $CartProduct['product']->image) }}"
                        alt="" /></td>
                <td>{{ $CartProduct['product']->title }}({{ $CartProduct['attribute']->sku }})<br />Color :
                    {{ $CartProduct['product']->color }}
                    <br>Size : {{ $CartProduct['attribute']->size }}
                </td>
                <td>
                    <div class="input-append">
                        <input onblur="quantitycanger(this)" data="{{ Crypt::encryptString($cartitem->id) }}"
                            title="Minimum Value is 1 !" id="quantityInput" class="span1" style="max-width:34px"
                            placeholder="1" value="{{ $cartitem->quantity }}" id="appendedInputButtons" name="quantity"
                            size="16" type="text">

                        <button onclick="minus(this)" id="minus" class="btn" type="button"><i
                                class="icon-minus"></i></button>

                        <button onclick="plus(this)" id="plus" class="btn" type="button"><i
                                class="icon-plus"></i></button>

                        <button onclick="closer(this)" id="close" class="btn btn-danger" type="button"><i
                                class="icon-remove icon-white"></i></button>
                    </div>
                </td>
                @php
                    $totalAmount += $cartitem->quantity * ($cartitem->price - $cartitem->price * ($CartProduct['discount'] / 100));
                    $productDiscount = $cartitem->price * ($CartProduct['discount'] / 100);
                    $grandTotal = $totalAmount - $productDiscount;
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
                @if ($coupon > 0)
                    @if ($coupon_amount_type == 'persantage')
                        {{ number_format($totalAmount * ($coupon / 100), 2) }}
                        @php
                            Session::put('coupon_amount', $totalAmount * ($coupon / 100));
                        @endphp
                    @else
                        {{ number_format($coupon, 2) }}
                        @php
                            Session::put('coupon_amount', $coupon);
                        @endphp
                     @endif
                @else
                    @if(Session::has('coupon_amount'))
                      {{ number_format(Session::get('coupon_amount'),2) }}
                      @php
                        $coupon = Session::get('coupon_amount');
                      @endphp
                    @else
                     {{ 0.00 }}
                    @endif
                @endif
            </td>
        </tr>
        <tr>
            <td colspan="5" style="text-align:right"><strong>GRAND TOTAL (Total Price - Coupon Discount) =</strong>
            </td>
            <td class="label label-important" style="display:block"> <strong> Rs.
                    @if ($coupon > 0)
                        @if ($coupon_amount_type == 'persantage')
                            {{ number_format($totalAmount - $totalAmount * ($coupon / 100), 2) }}
                            @php
                                Session::put('grandTotal', $totalAmount - $totalAmount * ($coupon / 100));
                            @endphp
                        @else
                            {{ number_format($totalAmount - $coupon, 2) }}
                            @php
                                Session::put('grandTotal', ($totalAmount - $coupon));
                            @endphp
                        @endif
                    @else
                    {{ number_format($totalAmount - $coupon, 2) }}
                    @php
                        Session::put('grandTotal', ($totalAmount - $coupon));
                    @endphp
                    @endif
                </strong></td>
        </tr>
    </tbody>

</table>


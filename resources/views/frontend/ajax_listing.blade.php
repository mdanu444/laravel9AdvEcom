@php
    use App\Models\Cart;
@endphp


<div class="tab-pane  active" id="blockView">
    <ul class="thumbnails">
        @foreach ($products as $product)
            <li class="span3">
                <div class="thumbnail">
                    <a href="{{ route('frontend.product_details', ['id' => $product->id]) }}"><img
                            src={{ url('images/product_image/small/' . $product->image) }} alt="" />
                    </a>
                    <div class="caption">
                        <h5>{{ Str::words($product->title, 4) }}</h5>
                        <p>
                            {{ Str::words($product->description, 11) }}
                        </p>
                        <h4 style="text-align:center">

                            <a class="btn" href="{{ route('frontend.product_details', ['id', $product->id]) }}"> <i
                                    class="icon-zoom-in"></i></a>


                            @if (Cart::getdiscount($product->id) > 0)
                                <a class="btn btn-primary" href="#">
                                    <del>Rs.{{ $product->price }}</del>
                                    <span style="color: yellow">
                                        Rs.
                                        {{ $product->price - $product->price * (Cart::getdiscount($product->id) / 100) }}
                                    </span>

                                </a>
                            @else
                                <a class="btn btn-primary" href="#">Rs.{{ $product->price }}</a>
                            @endif

                        </h4>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    <hr class="soft" />
</div>
<a href="compair.html" class="btn btn-large pull-right">Compair Product</a>
<div class="pagination">
    <ul>
        @if (isset($_GET['sort']) && $_GET['sort'] != '')
            {{ $products->appends(['sort' => $_GET['sort']])->links() }}
        @else
            {{ $products->links() }}
        @endif
    </ul>
</div>

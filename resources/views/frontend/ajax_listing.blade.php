<div class="tab-pane  active" id="blockView">
    <ul class="thumbnails">
        @foreach ($products as $product)
        <li class="span3">
            <div class="thumbnail">
                <a href="{{ route('frontend.product_details', ['id' => $product->id]) }}"><img
                    src={{url("images/product_image/small/".$product->image) }} alt=""/>
                </a>
                <div class="caption">
                    <h5>{{ Str::words($product->title, 4)}}</h5>
                    <p>
                        {{  Str::words($product->description, 11)}}
                    </p>
                    <h4 style="text-align:center"><a class="btn" href="product_details.html"> <i class="icon-zoom-in"></i></a> <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="#">Rs.{{ $product->price}}</a></h4>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
    <hr class="soft"/>
</div>

@php
    use App\Models\Cart;
@endphp

@extends('frontend.master')
@section('mainbody')
    <div class="span9">
        <ul class="breadcrumb">
            <li><a href="{{ route('frontend.index') }}">Home</a> <span class="divider">/</span></li>
            <li><a
                    href="{{ url($url) }}">{{ $url_status == 'category_url' ? $product->product_categories->title : $product->product_sub_categories->title }}</a>
                <span class="divider">/</span></li>
            <li class="active">{{ $product->title }}</li>
        </ul>
        <div class="row">
            <div id="gallery" class="span3">
                <a href="{{ url('images/product_image/larg/' . $product->image) }}" title="{{ $product->title }}">
                    <img src="{{ url('images/product_image/larg/' . $product->image) }}" style="width:100%"
                        alt="{{ $product->title }}" />
                </a>
                <div id="differentview" class="moreOptopm carousel slide">
                    <div class="carousel-inner">
                        <div class="item active">
                            @foreach ($images as $image)
                                <a href="{{ url('images/product_image/alternative/' . $image->title) }}"> <img
                                        style="width:29%" src="{{ url('images/product_image/alternative/' . $image->title) }}"
                                        alt="" /></a>
                            @endforeach
                        </div>

                    </div>
                    <!--
                    <a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>
                    <a class="right carousel-control" href="#myCarousel" data-slide="next">›</a>
                    -->
                </div>

                <div class="btn-toolbar">
                    <div class="btn-group">
                        <span class="btn"><i class="icon-envelope"></i></span>
                        <span class="btn"><i class="icon-print"></i></span>
                        <span class="btn"><i class="icon-zoom-in"></i></span>
                        <span class="btn"><i class="icon-star"></i></span>
                        <span class="btn"><i class=" icon-thumbs-up"></i></span>
                        <span class="btn"><i class="icon-thumbs-down"></i></span>
                    </div>
                </div>
            </div>
            <div class="span6">
                @if (Session::has('error_msg'))
                    <div class="alert alert-danger">{{ Session::get('error_msg') }}</div>
                @endif
                @if (Session::has('success_msg'))
                    <div class="alert alert-success">{{ Session::get('success_msg') }}</div>
                @endif
                <h3>{{ $product->title }} </h3>
                <small>- {{ $product->brands_id != 0 ? $product->brands->title : 'No Brand' }}</small>
                <hr class="soft" />
                <small>
                    @php
                        $stock = 0;
                        foreach ($product->products_attributes as $attribute) {
                            $stock += $attribute->stock;
                        }
                    @endphp
                    {{ $stock }}
                    items in stock</small>
                <form class="form-horizontal qtyFrm" action="{{ route('frontend.cart.store', ['id' => $product->id]) }}"
                    method="post">
                    @csrf
                    <div class="control-group">
                        @if (Cart::getdiscount($product->id) == 0)
                            <h4 id="price">Rs. {{ $product->price }}</h4>
                        @else
                            <h4 id="price"><del>Rs. {{ $product->price }}</del> Rs.
                                {{ $product->price - $product->price * (Cart::getdiscount($product->id) / 100) }}</h4>
                        @endif

                        <select title="Have to select a size!" name="size" id="size" class="span2 pull-left">
                            <option value="">Select Size</option>
                            @foreach ($product->products_attributes as $attribute)
                                <option value="{{ Crypt::encryptString($attribute->id) }}">{{ $attribute->size }}</option>
                            @endforeach
                        </select>
                        <input id="quantity" value="1" name="quantity" type="number" min="1" class="span1"
                            placeholder="Qty." />
                        <button type="submit" class="btn btn-large btn-primary pull-right"> Add to cart <i
                                class=" icon-shopping-cart"></i></button>
                    </div>
            </div>
            </form>
            <script>
                let sizeElem = document.getElementById('size');
                let quantity = document.getElementById('quantity');
                sizeElem.addEventListener('change', () => {
                    let size = sizeElem.value;
                    let id = {{ $product->id }};
                    let formdata = new FormData();
                    formdata.append('size', size);
                    formdata.append('id', id);
                    fetch("{{ route('frontend.getpricebysize') }}", {
                            method: 'post',
                            body: formdata,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        }).then(res => res.json())
                        .then((data) => {
                            // console.log(data);
                            if ((data.price > 0) && (data.discount == 0)) {
                                document.getElementById('price').innerHTML = "Rs. " + data.price;
                                sizeElem.style.borderColor = 'red';
                            }
                            if ((data.price > 0) && (data.discount > 0)) {
                                document.getElementById('price').innerHTML = '<del>Rs. ' + data.price + '</del> Rs. ' +
                                    (data.price - (data.price * (data.discount / 100)));
                                if (sizeElem.style.borderColor == 'red') {
                                    sizeElem.style.borderColor = 'lightgray';
                                }
                            }
                            if ((data.price > 0) && (data.discount == 0)) {
                                document.getElementById('price').innerHTML = 'Rs. ' + data.price;
                                if (sizeElem.style.borderColor == 'red') {
                                    sizeElem.style.borderColor = 'lightgray';
                                }
                            }
                        });
                })




                quantity.addEventListener('change', () => {
                    let quantityValue = quantity.value;
                    if (quantityValue < 1) {
                        quantity.style.borderColor = 'red';
                    } else {
                        quantity.style.borderColor = 'lightgray';
                    }
                });
            </script>


            <hr class="soft clr" />
            <p class="span6">
                {{ $product->description }}

            </p>
            <a class="btn btn-small pull-right" href="#detail">More Details</a>
            <br class="clr" />
            <a href="#" name="detail"></a>
            <hr class="soft" />
        </div>

        <div class="span9">
            <ul id="productDetail" class="nav nav-tabs">
                <li class="active"><a href="#home" data-toggle="tab">Product Details</a></li>
                <li><a href="#profile" data-toggle="tab">Related Products</a></li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active in" id="home">
                    <h4>Product Information</h4>
                    <table class="table table-bordered">
                        <tbody>
                            <tr class="techSpecRow">
                                <th colspan="2">Product Details</th>
                            </tr>
                            <tr class="techSpecRow">
                                <td class="techSpecTD1">Brand: </td>
                                <td class="techSpecTD2">{{ $product->brands_id != 0 ? $product->brands->title : 'No Brand' }}
                                </td>
                            </tr>
                            <tr class="techSpecRow">
                                <td class="techSpecTD1">Code:</td>
                                <td class="techSpecTD2">{{ $product->code }}</td>
                            </tr>
                            <tr class="techSpecRow">
                                <td class="techSpecTD1">Color:</td>
                                <td class="techSpecTD2">{{ $product->color }}</td>
                            </tr>
                            <tr class="techSpecRow">
                                <td class="techSpecTD1">Fabric:</td>
                                <td class="techSpecTD2">{{ $product->fabric }}</td>
                            </tr>
                            <tr class="techSpecRow">
                                <td class="techSpecTD1">Pattern:</td>
                                <td class="techSpecTD2">{{ $product->pattern }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <h5>Washcare</h5>
                    <p>{{ $product->wash_care }}</p>
                    <h5>Disclaimer</h5>
                    <p>
                        There may be a slight color variation between the image shown and original product.
                    </p>
                </div>
                <div class="tab-pane fade" id="profile">
                    @if (count($related_product) > 0)
                        <div id="myTab" class="pull-right">
                            <a href="#listView" data-toggle="tab"><span class="btn btn-large"><i
                                        class="icon-list"></i></span></a>
                            <a href="#blockView" data-toggle="tab"><span class="btn btn-large btn-primary"><i
                                        class="icon-th-large"></i></span></a>
                        </div>
                    @endif
                    <br class="clr" />
                    <hr class="soft" />
                    <div class="tab-content">
                        <div class="tab-pane" id="listView">
                            @foreach ($related_product as $rlprod)
                                <div class="row">
                                    <div class="span2">
                                        <img src="{{ url('images/product_image/small/' . $rlprod->image) }}"
                                            alt="" />
                                    </div>
                                    <div class="span4">
                                        <h3>New | Available</h3>
                                        <hr class="soft" />
                                        <h5>{{ $rlprod->title }} </h5>
                                        <p>
                                            {{ $rlprod->description }}
                                        </p>
                                        <a class="btn btn-small pull-right"
                                            href="{{ route('frontend.product_details', ['id' => $rlprod->id]) }}">View
                                            Details</a>
                                        <br class="clr" />
                                    </div>
                                    <div class="span3 alignR">
                                        <form class="form-horizontal qtyFrm">
                                            <h3> Rs.{{ $rlprod->price }}</h3>
                                            <label class="checkbox">
                                                <input type="checkbox"> Adds product to compair
                                            </label><br />
                                            <div class="btn-group">
                                                <a href="product_details.html" class="btn btn-large btn-primary"> Add to
                                                    <i class=" icon-shopping-cart"></i></a>
                                                <a href="product_details.html" class="btn btn-large"><i
                                                        class="icon-zoom-in"></i></a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <hr class="soft" />
                            @endforeach
                        </div>
                        <div class="tab-pane active" id="blockView">
                            <ul class="thumbnails">
                                @foreach ($related_product as $rlprod)
                                    <li class="span3">
                                        <div class="thumbnail">
                                            <a href="{{ route('frontend.product_details', ['id' => $rlprod]) }}"><img
                                                    src="{{ url('images/product_image/small/' . $rlprod->image) }}"
                                                    alt="" /></a>
                                            <div class="caption">
                                                <h5>Casual T-Shirt</h5>
                                                <p>
                                                    Lorem Ipsum is simply dummy text.
                                                </p>
                                                <h4 style="text-align:center"><a class="btn"
                                                        href="product_details.html"> <i class="icon-zoom-in"></i></a> <a
                                                        class="btn" href="#">Add to <i
                                                            class="icon-shopping-cart"></i></a> <a class="btn btn-primary"
                                                        href="#">Rs.1000</a></h4>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <hr class="soft" />
                        </div>
                    </div>
                    <br class="clr">
                </div>
            </div>
        </div>
    </div>
    <script src={{ asset('frontend/themes/js/jquery.js') }}></script>
    <script src={{ asset('frontend/themes/js/jquery.lightbox-0.5.js') }}></script>
@endsection

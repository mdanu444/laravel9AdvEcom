@php
    use App\Models\Cart;
@endphp

@extends('frontend.master')
@section('mainbody')
    <div class="span9">
        <div class="well well-small">
            <h4>Featured Products <small class="pull-right">{{ $numberofproduct }} featured products</small></h4>
            <div class="row-fluid">
                <div id="featured" class="carousel slide">
                    <div class="carousel-inner">
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($featured_products as $featured_product)
                            <div class="item {{ $i == 0 ? 'active' : '' }}">
                                <ul class="thumbnails">
                                    @foreach ($featured_product as $featured)
                                        <li class="span3">
                                            <div class="thumbnail">
                                                <i class="tag"></i>
                                                <a
                                                    href="{{ route('frontend.product_details', ['id' => $featured['id']]) }}"><img
                                                        src={{ asset('images/product_image/small/' . $featured['image']) }}
                                                        alt=""></a>
                                                <div class="caption">
                                                    <h5>{{ Str::words($featured['title'], 5) }}</h5>
                                                    <h4><a class="btn"
                                                            href="{{ route('frontend.product_details', ['id' => $featured['id']]) }}">VIEW</a>
                                                        @if (Cart::getdiscount($featured['id']) > 0)
                                                            <span style="line-height: 1" class="pull-right"><del>
                                                                    Rs.{{ $featured['price'] }}</del> <br>
                                                                Rs.{{ $featured['price'] - $featured['price'] * (Cart::getdiscount($featured['id']) / 100) }}
                                                            </span>
                                                        @else
                                                            <span class="pull-right">Rs.{{ $featured['price'] }}</span>
                                                        @endif
                                                    </h4>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            @php
                                $i++;
                            @endphp
                        @endforeach
                    </div>
                    <a class="left carousel-control" href="#featured" data-slide="prev">‹</a>
                    <a class="right carousel-control" href="#featured" data-slide="next">›</a>
                </div>
            </div>
        </div>
        <h4>Latest Products </h4>
        <ul class="thumbnails">
            @foreach ($collection as $item)
                <li class="span3">
                    <div class="thumbnail">
                        <a href="{{ route('frontend.product_details', ['id' => $item['id']]) }}"><img
                                src={{ asset('images/product_image/small/' . $item->image) }} alt="" /></a>
                        <div class="caption">
                            <h5>{{ Str::words($item->title, 5) }}</h5>
                            <p>
                                {{ Str::words($item->description, 8) }}
                            </p>

                            <h4 style="text-align:center">

                                <a class="btn" href="{{ route('frontend.product_details', ['id' => $item['id']]) }}"> <i
                                        class="icon-zoom-in"></i></a>


                                @if (Cart::getdiscount($item->id) > 0)
                                    <a class="btn btn-primary" href="#">
                                        <del>Rs.{{ $item->price }}</del>
                                        <span style="color: yellow">
                                            Rs. {{ $item->price - $item->price * (Cart::getdiscount($item->id) / 100) }}
                                        </span>

                                    </a>
                                @else
                                    <a class="btn btn-primary" href="#">Rs.{{ $item->price }}</a>
                                @endif
                            </h4>
                            </h4>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>

    </div>
@endsection
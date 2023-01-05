@php
    use App\Models\Admin\Banner;
    $banners = Banner::where('status', 1)->get();
@endphp

<div id="carouselBlk">
    <div id="myCarousel" class="carousel slide">
        <div class="carousel-inner">
            @foreach ($banners as $key => $item)
                <div class="item {{ $key == 0 ? 'active' : '' }}">
                    <div class="container">
                        <a href="{{ $item->url }}"><img style="width:100%" src={{ url('images/banner/' . $item->image) }}
                                alt="special offers" /></a>
                        <div class="carousel-caption">
                            <h4>{{ $item->title }}</h4>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
    </div>
</div>

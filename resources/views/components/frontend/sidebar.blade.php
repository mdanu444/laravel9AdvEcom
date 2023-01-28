@php
    use App\Models\Admin\ProductSection;
    use App\Models\Admin\Product;
    $navsections = ProductSection::orderBy('id', 'desc')->get();

    // filters
    $filter = [];
    $filter['pattern'] = Product::select('pattern')
        ->distinct()
        ->get();
    $filter['fabric'] = Product::select('fabric')
        ->distinct()
        ->get();
    $filter['sleeve'] = Product::select('sleeve')
        ->distinct()
        ->get();
    $filter['occassion'] = Product::select('occassion')
        ->distinct()
        ->get();

@endphp
<!-- Sidebar ================================================== -->
<div id="sidebar" class="span3">
    <div class="well well-small"><a id="myCart" href="{{ route('frontend.cart.index') }}"><img
                src={{ asset('frontend/themes/images/ico-cart.png') }} alt="cart">
            <span class="cartitem">
                @if (Session::has('numberOfCartItem'))
                    {{ Session::get('numberOfCartItem') }}
                @else
                    0
                @endif
            </span>
            Items in your cart</a></div>
    <ul id="sideManu" class="nav nav-tabs nav-stacked">
        @foreach ($navsections as $section)
            @if (count($section->product_categories) > 0)
                <li class="subMenu"><a>{{ $section->title }}</a>
                    <ul>
                        @foreach ($section->product_categories as $category)
                            <li><a href="{{ url('c/' . $category->url) }}"><strong>{{ $category->title }}</strong></a>
                            </li>
                            @foreach ($category->product_sub_categories as $sub)
                                @if (count($sub->products) > 0)
                                    <li><a href="{{ url('s/' . $sub->url) }}"><i
                                                class="icon-chevron-right"></i>{{ $sub->title }}</></a></li>
                                @endif
                            @endforeach
                    </ul>
            @endforeach
            </li>
        @endif
        @endforeach
    </ul>

    @if (Session::has('pagetitle') && Session::get('pagetitle') == 'Listing')
        <br><br>
        <h5>Filters</h5>
        <ul id="sideManu" class="nav nav-tabs nav-stacked">
            @foreach ($filter as $key => $flt)
                <li class="subMenu"><a>{{ $key }}</a>
                    <ul>
                        @foreach ($flt as $f)
                            <li>
                                <label>
                                    <input type="checkbox" style="padding-bottom: 10px; margin-bottom: 5px !important"
                                        class="{{ $key }}" value="{{ $f[$key] }}"> {{ $f[$key] }}
                                </label>
                            </li>
                        @endforeach
                    </ul>
                    <br>
                </li>
            @endforeach
        </ul>
    @endif

    <br />
    <div class="thumbnail">
        <img src={{ asset('frontend/themes/images/payment_methods.png') }} title="Payment Methods"
            alt="Payments Methods">
        <div class="caption">
            <h5>Payment Methods</h5>
        </div>
    </div>
</div>
<!-- Sidebar end=============================================== -->
<script>
    let filter = [];
    @foreach ($filter as $key => $flt)
        let {{ $key }} = document.querySelectorAll(".{{ $key }}");
        for (let li of {{ $key }}) {
            li.addEventListener('click', () => {
                sendfilterclasses();
            });
        }
    @endforeach

    function sendfilterclasses() {
        @foreach ($filter as $key => $flt)
            getCheckedFilters("{{ $key }}")
        @endforeach
        loadData()
    }

    function getCheckedFilters(classname) {
        if (classname != "") {
            let selectedFilter = [];
            let allCheckedInput = document.querySelectorAll('.' + classname + ':checked');
            for (let input of allCheckedInput) {
                selectedFilter.push(input.value);
            }
            filter[classname] = selectedFilter;
        }
    }
</script>

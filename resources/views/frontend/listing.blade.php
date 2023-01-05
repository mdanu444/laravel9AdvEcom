@php
    use App\Models\Cart;
@endphp


@extends('frontend.master')
@section('mainbody')
    <div class="span9">
        <ul class="breadcrumb">
            <li><a href="{{ route('frontend.index') }}">Home</a> </li>
            @if (isset($category))
                <span class="divider">/</span>
                <li class=@if (!isset($subcategory)) {{ 'active' }} @endif><a
                        href="{{ url('c/' . $category->url) }}">{{ $category->title }}</a></li>
            @endif
            @if (isset($subcategory))
                <span class="divider">/</span>
                <li class="active"><a href="{{ url('s/' . $subcategory->url) }}">{{ $subcategory->title }}</a></li>
            @endif
        </ul>
        <h3>
            @if (isset($category) && !isset($subcategory))
                {{ $category->title }}
            @elseif(isset($subcategory))
                {{ $subcategory->title }}
            @endif
            <small class="pull-right"> {{ $numberofproducts }} products are available </small>
        </h3>
        <hr class="soft" />
        <p>
            @if (isset($category) && !isset($subcategory))
                {{ $category->description }}
            @elseif(isset($subcategory))
                {{ $subcategory->description }}
            @endif
        </p>
        <hr class="soft" />
        <form id="productsortform" class="form-horizontal span6">
            <div class="control-group">
                <input type="hidden" id="url" value="{{ $url }}">
                <input type="hidden" id="csrf-token" value="{{ csrf_token() }}">
                <label class="control-label alignL">Sort By </label>
                <select onchange="productsort()" name="sort" id="sort">
                    <option>Select</option>
                    <option @if (isset($_GET['sort']) && $_GET['sort'] == 'latest') {{ 'selected' }} @endif value="latest">Latest</option>
                    <option @if (isset($_GET['sort']) && $_GET['sort'] == 'by-lowest-price') {{ 'selected' }} @endif value="by-lowest-price">Sort By
                        Lowest Price</option>
                    <option @if (isset($_GET['sort']) && $_GET['sort'] == 'by-heighest-price') {{ 'selected' }} @endif value="by-heighest-price">Sort By
                        Heighest Price</option>
                </select>
            </div>
        </form>

        <br class="clr" />
        <div class="tab-content" id="ajaxListingContainer">
            @include('frontend.ajax_listing')
        </div>

        <br class="clr" />
    </div>

    <script>
        function productsort() {
            sendfilterclasses()
        }

        function loadData() {
            loading();
            let url = document.getElementById('url').value;
            let sort = document.getElementById('sort').value;
            let formdata = new FormData();
            formdata.append('sort', sort);
            let filterObj = Object.assign({}, filter);

            let finalObject = {};

            for (let objname in filterObj) {
                finalObject[objname] = filter[objname]
            }

            formdata.append('filter', JSON.stringify(finalObject));
            fetch(url, {
                    method: 'POST',
                    body: formdata,
                    headers: {
                        'X-CSRF-TOKEN': document.getElementById('csrf-token').value,
                    }
                }).then((res) => res.json())
                .then((data) => {
                    // console.log(data)
                    document.getElementById('ajaxListingContainer').innerHTML = data.html;
                    loading();
                });
        }
    </script>
@endsection

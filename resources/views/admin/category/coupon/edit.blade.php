@php
    use App\Models\Admin\Coupon;
@endphp

@extends('templates.admin.master')


@section('main_content')
    <div class="card col-md-6">
        <div class="card-header bg-primary">Edit Coupon</div>
        <div class="card-body">
            <form action="{{ route('admin.coupons.update', Crypt::encryptString($item->id)) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="form-group">
                    <h3 class="h4">Coupon Option</h3>
                    <label for="automatic"> Automatic&nbsp;
                        <input {{ $item->option == "automatic"?"checked":"" }} onclick="optionchanger('automatic')" type="radio" value="automatic" name="option"
                            id="automatic" class="option">
                    </label>&nbsp;&nbsp;
                    <label for="manual"> Manual&nbsp;
                        <input {{ $item->option == "manual"?"checked":"" }} onclick="optionchanger('manual')" type="radio" value="manual" name="option" id="manual"
                            class="option">
                    </label>
                    <br>
                    <hr style="border-color: lightgray">
                </div>
                <div class="form-group code" style='display: {{ $item->option == "automatic"?"none":"" }}'>
                    <h3 class="h4">Coupon Code</h3>
                    <input class="form-control w-100" value='{{ $item->option == "manual"?$item->code:"" }} ' type="text" value="" name="code" id="code" placeholder="Coupon Code">
                    <br>
                    <hr style="border-color: lightgray">
                </div>
                <div class="form-group">
                    <h3 class="h4">Coupon Type</h3>
                    <label for="multiple"> Multiple Times&nbsp;
                        <input type="radio" value="multiple" {{ $item->coupon_type == "multiple"?"checked":"" }} name="coupon_type" id="multiple" class="coupon_type">
                    </label>&nbsp;&nbsp;
                    <label for="single"> Single Time&nbsp;
                        <input {{ $item->coupon_type == "single"?"checked":"" }} type="radio" value="single" name="coupon_type" id="single" class="coupon_type">
                    </label>
                    <br>
                    <hr style="border-color: lightgray">
                </div>
                <div class="form-group">
                    <h3 class="h4" for="selectionloader">Select Category</h3>
                    <select multiple class=" col-md-11  selecttion form-control js-example-basic-single"
                        name="categories[]">
                        @foreach ($sections as $section)
                            <option disabled style="font-weight: bold !important"> &nbsp; &nbsp;{{ $section->title }}
                            </option>
                            @foreach ($section->product_categories as $category)
                                <option
                                @if (in_array($category->id, Coupon::getStrToArr($item->categories)))
                                    {{ 'selected' }}
                                @endif
                                value="{{ 'c-' . $category->id }}"> &nbsp; &nbsp; &#8594; {{ $category->title }}
                                </option>
                                @foreach ($category->product_sub_categories as $sub)
                                    <option
                                    @if (in_array($sub->id, Coupon::getStrToArr($item->subcategories)))
                                        {{ 'selected' }}
                                    @endif
                                    value="{{ 's-' . $sub->id }}"> &nbsp; &nbsp; &#8594; &#8594; {{ $sub->title }}
                                    </option>
                                @endforeach
                            @endforeach
                        @endforeach
                    </select>
                    @error('product_categories_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <br>
                    <hr style="border-color: lightgray">
                </div>
                <div class="form-group">
                    <h3 class="h4" for="selectionloader">Select User</h3>
                    <select multiple class=" col-md-11  selecttion form-control js-example-basic-single" name="users[]">
                        @foreach ($users as $user)
                            <option
                            @if (in_array($user->id, Coupon::getStrToArr($item->users)))
                                        {{ 'selected' }}
                                    @endif
                            value="{{ $user->id }}"> &nbsp; &nbsp;&nbsp;{{ $user->email }}</option>
                        @endforeach
                    </select>
                    @error('product_categories_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <br>
                    <hr style="border-color: lightgray">
                </div>
                <div class="form-group">
                    <h3 class="h4">Coupon Amount Type</h3>
                    <label for="persantage"> Persantage&nbsp;
                        <input type="radio" {{ $item->amount_type == "persantage"?"checked":"" }} value="persantage" name="amount_type" id="persantage" class="amount_type">
                    </label>&nbsp;&nbsp;
                    <label for="fixed"> Fixed Amount in BDT &nbsp;
                        <input type="radio" {{ $item->amount_type == "fixed"?"checked":"" }} value="fixed" name="amount_type" id="fixed" class="amount_type">
                    </label>
                    <br>
                    <hr style="border-color: lightgray">
                </div>
                <div class="form-group">
                    <h3 class="h4">Coupon Amount [% or BDT]</h3>
                    <input name="amount" type="number" value="{{ $item->amount }}" placeholder="Coupon Amount" class="form-control">
                    <br>
                    <hr style="border-color: lightgray">
                </div>




                <div class="form-group">
                    <label>Expiry Date:</label>
                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                        <input value="{{ date_format(date_create($item->expiry_date), 'm/d/Y') }}" type="text" class="form-control datetimepicker-input" data-target="#reservationdate"
                            name="expiry_date" placeholder="MM/DD/YYYY" />
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
                <input type="submit" value="Update" class="btn btn-primary">
            </form>
        </div>
    </div>
    <script>
        function optionchanger(option) {
            let code = document.querySelector('.code');
            if (option == "automatic") {
                code.style.display = 'none';
            } else {
                code.style.display = 'block';
            }
        }
        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'L'
        });
    </script>
@endsection

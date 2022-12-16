@extends('templates.admin.master')


@section('main_content')
<div class="card col-md-12">
    <div class="card-header bg-primary">Update Product</div>
    <div class="card-body">
        <form action="{{ route('admin.product.update', Crypt::encryptString($data->id)) }}" method="POST" enctype="multipart/form-data">
            @csrf

            @method('put')

            <div style="display: grid; grid-template-columns: 50% 50%; width: 100%;  grid-gap: 30px 10px; box-sizing: border-box;">


            <div class="form-group">


                <label for="section">Select Section</label>
                <select location="admin/getcategorybysection" loadableClass="categoryoptionviewer"  class="selectionloader col-md-11 form-control js-example-basic-single selecttion" name="product_sections_id"  id="section">
                    <option  value="">Select Section</option>
                    @foreach ($sections as $section)
                        <option
                            @if ($data->product_sections_id == $section->id)
                                selected
                            @endif
                        value="{{
                            Crypt::encryptString($section->id) }}">{{ $section->title }}</option>
                    @endforeach
                </select>
                @error('section')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="selectionloader">Select Category</label>
                <select location="admin/getsubcategorybysection" loadableClass="subcategoryoptionviewer" class=" col-md-11 categoryoptionviewer selecttion form-control js-example-basic-single" name="product_categories_id" id="selectionloader">
                    <option value="">Select Category</option>

                    @foreach ($category as $cat)
                        <option
                        @if ($data->product_categories_id == $cat->id)
                        selected
                        @endif
                        value="{{ Crypt::encryptString($cat->id) }}">{{ $cat->title }}</option>
                    @endforeach
                </select>
                @error('product_categories_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="subcategory">Select Sub Category</label>
                <select  class="col-md-11 subcategoryoptionviewer selecttion form-control js-example-basic-single" name="product_sub_categories_id" id="subcategory">
                    <option  value="">Select Sub Category</option>
                    @if ($data->product_sub_categories_id == 0)
                        <option selected value="{{ Crypt::encryptString(0) }}">None</option>
                    @endif
                    @foreach ($subcategory as $subcat)
                        <option
                        @if ($data->product_sub_categories_id == $subcat->id)
                        selected
                        @endif
                        value="{{ Crypt::encryptString($subcat->id) }}">{{ $subcat->title }}</option>
                    @endforeach
                </select>
                @error('product_categories_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="brand">Select Brand</label><br>
                <select  class="col-md-11 form-control selecttion" name="brands_id" id="brand">
                    <option selected value="">Select Brand</option>
                    <option value="{{ Crypt::encryptString(0) }}" {{ $data->brands_id == 0? 'selected':'' }}>None</option>
                    @foreach ($brands as $brand)
                        <option
                        @if ($data->brands_id == $brand->id)
                            selected
                        @endif
                        value="{{ Crypt::encryptString($brand->id) }}">{{ $brand->title }}</option>
                    @endforeach
                </select>
                @error('product_categories_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="form-group">
                <label for="title">Enter Title</label>
                <input value="{{ $data->title }}" class="form-control col-md-11" type="text" name="title" id="title">
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="">
                <label for="code">Enter Product Code</label>
                <input value="{{ $data->code }}" class="form-control col-md-11" type="text" name="code" id="code">
                @error('code')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="">
                <label for="color">Enter Product Color</label>
                <input value="{{ $data->color }}" class="form-control col-md-11" type="text" name="color" id="color">
                @error('color')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="">
                <label for="unit">Enter Unit title [Piece/Kg./Liter/etc.]</label>
                <input value="{{ $data->unit }}" class="form-control col-md-11" type="text" name="unit" id="unit">
                @error('unit')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="">
                <label for="weight">Weight [in Gram]</label>
                <input value="{{ $data->weight }}" class="form-control col-md-11" type="text" name="weight" id="weight">
                @error('weight')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="">
                <label for="price">Unit Price</label>
                <input value="{{ $data->price }}" class="form-control col-md-11" type="number" min="5" name="price" id="price">
                @error('price')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="">
                <label for="discount">Discount (%)</label>
                <input value="{{ $data->discount }}" class="form-control col-md-11" type="number" min="0" name="discount" id="discount">
                @error('discount')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="form-group">
                <label for="featured">Select Featured or not ?</label><br>
                <select  class="col-md-11 form-control selecttion" name="featured" id="featured">
                    @if ($data->featured == 0)
                    <option selected value="0">No</option>
                    <option value="1">Yes</option>
                    @else
                    <option  value="0">No</option>
                    <option selected value="1">Yes</option>
                    @endif
                </select>
                @error('product_categories_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <a href="{{ url('video/product_video/'.$data->video) }}" download >Download Video</a>
            </div>
            <div>
                <img height="100" width="100" src="{{ url('images/product_image/small/'.$data->image) }}" alt="">
            </div>
            <div class="">
                <label for="video">Upload Video</label>
                <input  class="form-control col-md-11" type="file" accept="video/*" name="video" id="video">
                @error('video')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="">
                <label for="image">Upload Featured Image</label>
                <input  class="form-control col-md-11" accept="image/*" type="file" name="image" id="image">
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="">
                <label for="description">Product Description</label>
                <textarea class="form-control col-md-11" name="description" id="description">{{ $data->description }}</textarea>
                @error('discount')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="">
                <label for="wash_care">Wash Care [if any]</label>
                <input value="{{ $data->wash_care }}" class="form-control col-md-11" type="text" name="wash_care" id="wash_care">
                @error('wash_care')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="">
                <label for="fabric">Fabric [Cotton/Polister/etc.]</label>
                <input value="{{ $data->fabric }}" class="form-control col-md-11" type="text" name="fabric" id="fabric">
                @error('fabric')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>



            <div class="form-group">
                <label for="pattern">Select Pattern</label><br>
                <select  class="col-md-11 form-control selecttion" name="pattern" id="pattern">
                    <option {{ $data->pattern == 'Checked'? 'selected':'' }} value="Checked">Checked</option>
                    <option {{ $data->pattern == 'Plain'? 'selected':'' }} value="Plain">Plain</option>
                    <option {{ $data->pattern == "Printed"? 'selected':'' }} value="Printed">Printed</option>
                    <option {{ $data->pattern == "Self"? 'selected':'' }} value="Self">Self</option>
                    <option {{ $data->pattern == "Solid"? 'selected':'' }} value="Solid">Solid</option>
                    <option {{ $data->pattern == 0? 'selected':'' }} value="0">None</option>
                </select>
                @error('pattern')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="sleeve">Select Sleeve Type [if any]</label><br>
                <select  class="col-md-11 form-control selecttion" name="sleeve" id="sleeve">
                    <option {{ $data->sleeve == "Full Sleeve" ?'selected':''}} selected value="Full Sleeve">Full Sleeve</option>
                    <option  {{ $data->sleeve == "Half Sleeve"?'selected':'' }} value="Half Sleeve">Half Sleeve</option>
                    <option  {{ $data->sleeve == "Short Sleeve"?'selected':'' }} value="Short Sleeve">Short Sleeve</option>
                    <option  {{ $data->sleeve == "Sleeveless"?'selected':'' }} value="Sleeveless">Sleeveless</option>
                    <option  {{ $data->sleeve == 0?'selected':'' }} value="0">None</option>
                </select>
                @error('sleeve')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="fit">Select Fit</label><br>
                <select  class="col-md-11 form-control selecttion" name="fit" id="fit">
                    <option {{ $data->fit == "Regular" ? "selected":'' }}  value="Regular">Regular</option>
                    <option {{ $data->fit == "Slim" ? "selected":'' }} value="Slim">Slim</option>
                </select>
                @error('fit')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="">
                <label for="occassion">Occassion [Regular/Casual/Party/Etc.]</label>
                <input value="{{ $data->occassion }}" class="form-control col-md-11" type="text" name="occassion" id="occassion">
                @error('occassion')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="">
                <label for="meta_title">Meta Title</label>
                <input value="{{ $data->meta_title }}" class="form-control col-md-11" type="text" name="meta_title" id="meta_title">
                @error('meta_title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>



            <div class="">
                <label for="meta_keywords">Meta Keywords</label>
                <input value="{{ $data->meta_keywords }}" class="form-control col-md-11" type="text" name="meta_keywords" id="meta_keywords">
                @error('meta_keywords')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="">
                <label for="meta_description">Meta Description</label>
                <textarea value="" class="form-control col-md-11" type="textarea" name="meta_description" id="meta_description">{{ $data->meta_description }}</textarea>
                @error('meta_description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
<div></div>
            <input style="grid-" type="submit" value="Update" class="btn btn-primary  col-md-11">
        </div>
        </form>
    </div>
</div>

@endsection


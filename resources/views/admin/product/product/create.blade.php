@extends('templates.admin.master')


@section('main_content')
<div class="card col-md-12">
    <div class="card-header bg-primary">Add Product </div>
    <div class="card-body">
        <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="display: grid; grid-template-columns: 50% 50%; width: 100%;  grid-gap: 30px 10px; box-sizing: border-box;">


            <div class="form-group">


                <label for="section">Select Section</label>
                <select location="admin/getcategorybysection" loadableClass="categoryoptionviewer"  class="selectionloader col-md-11 form-control js-example-basic-single selecttion" name="product_sections_id"  id="section">
                    <option selected value="">Select Section</option>
                    @foreach ($sections as $section)
                        <option value="{{ Crypt::encryptString($section->id) }}">{{ $section->title }}</option>
                    @endforeach
                </select>
                @error('section')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="selectionloader">Select Category</label>
                <select location="admin/getsubcategorybysection" loadableClass="subcategoryoptionviewer" class=" col-md-11 categoryoptionviewer selecttion form-control js-example-basic-single" name="product_categories_id" id="selectionloader">
                    <option selected value="">Select Category</option>

                </select>
                @error('product_categories_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="subcategory">Select Sub Category</label>
                <select  class="col-md-11 subcategoryoptionviewer selecttion form-control js-example-basic-single" name="product_sub_categories_id" id="subcategory">
                    <option selected value="">Select Sub Category</option>
                    <option selected value="{{ Crypt::encryptString(0) }}">None</option>
                </select>
                @error('product_sub_categories_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="brand">Select Brand</label><br>
                <select  class="col-md-11 form-control selecttion" name="brands_id" id="brand">
                    <option selected value="">Select Brand</option>
                    <option value="{{ Crypt::encryptString(0) }}">None</option>
                    @foreach ($brands as $brand)
                        <option value="{{ Crypt::encryptString($brand->id) }}">{{ $brand->title }}</option>
                    @endforeach
                </select>
                @error('brand')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="form-group">
                <label for="title">Enter Title</label>
                <input value="{{ old('title') }}" class="form-control col-md-11" type="text" name="title" id="title">
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="">
                <label for="code">Enter Product Code</label>
                <input value="{{ old('code') }}" class="form-control col-md-11" type="text" name="code" id="code">
                @error('code')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="">
                <label for="color">Enter Product Color</label>
                <input value="{{ old('color') }}" class="form-control col-md-11" type="text" name="color" id="color">
                @error('color')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="">
                <label for="unit">Enter Unit title [Piece/Kg./Liter/etc.]</label>
                <input value="{{ old('unit') }}" class="form-control col-md-11" type="text" name="unit" id="unit">
                @error('unit')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="">
                <label for="weight">Weight [in Gram]</label>
                <input value="{{ old('weight') }}" class="form-control col-md-11" type="text" name="weight" id="weight">
                @error('weight')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="">
                <label for="price">Unit Price</label>
                <input value="{{ old('price') }}" class="form-control col-md-11" type="number" min="5" name="price" id="price">
                @error('price')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="">
                <label for="discount">Discount (%)</label>
                <input value="{{ old('discount') }}" class="form-control col-md-11" type="number" min="0" name="discount" id="discount">
                @error('discount')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="form-group">
                <label for="featured">Select Featured or not ?</label><br>
                <select  class="col-md-11 form-control selecttion" name="featured" id="featured">
                    <option selected value="0">No</option>
                    <option value="1">Yes</option>
                </select>
                @error('featured')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
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
                <textarea class="form-control col-md-11" name="description" id="description">{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="">
                <label for="wash_care">Wash Care [if any]</label>
                <input value="{{ old('wash_care') }}" class="form-control col-md-11" type="text" name="wash_care" id="wash_care">
                @error('wash_care')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="">
                <label for="fabric">Fabric [Cotton/Polister/etc.]</label>

                <select  class="col-md-11 form-control selecttion" name="fabric" id="fabric">
                    <option selected value="Cotton">Cotton</option>
                    <option value="Polyster">Polyster</option>
                    <option value="Linen">Linen</option>
                    <option value="Wool">Wool</option>
                    <option value="Silk">Silk</option>
                    <option value="Leather">Leather</option>
                    <option value="Mixed fabrics">Mixed fabrics</option>
                    <option value="None">None</option>
                </select>
                @error('fabric')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>



            <div class="form-group">
                <label for="pattern">Select Pattern</label><br>
                <select  class="col-md-11 form-control selecttion" name="pattern" id="pattern">
                    <option  value="Checked">Checked</option>
                    <option value="Plain">Plain</option>
                    <option value="Printed">Printed</option>
                    <option value="Self">Self</option>
                    <option value="Solid">Solid</option>
                    <option selected value="None">None</option>
                </select>
                @error('pattern')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="sleeve">Select Sleeve Type [if any]</label><br>
                <select  class="col-md-11 form-control selecttion" name="sleeve" id="sleeve">
                    <option selected value="Full Sleeve">Full Sleeve</option>
                    <option value="Half Sleeve">Half Sleeve</option>
                    <option value="Short Sleeve">Short Sleeve</option>
                    <option value="Sleeveless">Sleeveless</option>
                    <option value="None">None</option>
                </select>
                @error('pattern')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="fit">Select Fit</label><br>
                <select  class="col-md-11 form-control selecttion" name="fit" id="fit">
                    <option selected value="Regular">Regular</option>
                    <option value="Slim">Slim</option>
                </select>
                @error('fit')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="">
                <label for="occassion">Occassion [Regular/Casual/Party/Etc.]</label>
                <input value="{{ old('occassion') }}" class="form-control col-md-11" type="text" name="occassion" id="occassion">
                @error('occassion')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="">
                <label for="meta_title">Meta Title</label>
                <input value="{{ old('meta_title') }}" class="form-control col-md-11" type="text" name="meta_title" id="meta_title">
                @error('meta_title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>



            <div class="">
                <label for="meta_keywords">Meta Keywords</label>
                <input value="{{ old('meta_keywords') }}" class="form-control col-md-11" type="text" name="meta_keywords" id="meta_keywords">
                @error('meta_keywords')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="">
                <label for="meta_description">Meta Description</label>
                <textarea value="" class="form-control col-md-11" type="textarea" name="meta_description" id="meta_description">{{ old('meta_description') }}</textarea>
                @error('meta_description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
<div></div>
            <input style="grid-" type="submit" value="Add" class="btn btn-primary  col-md-11">
        </div>
        </form>
    </div>
</div>

@endsection


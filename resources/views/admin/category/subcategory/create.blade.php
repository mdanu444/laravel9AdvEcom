@extends('templates.admin.master')


@section('main_content')
<div class="card col-md-12">
    <div class="card-header bg-primary">Add Product Sub Category </div>
    <div class="card-body">
        <form action="{{ route('admin.productsubcategory.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="display: grid; grid-template-columns: 50% 50%; width: 100%;  grid-gap: 30px 10px; box-sizing: border-box;">


            <div class="form-group">
                <label for="selectionloader">Section</label>
                <select location="admin/getcategorybysection" loadableClass="categoryoptionviewer"  class="col-md-11 form-control js-example-basic-single selecttion" name="product_sections_id"  id="selectionloader">
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
                <label for="category">Category</label>
                <select  class="col-md-11 categoryoptionviewer selecttion form-control js-example-basic-single" name="product_categories_id" id="category">
                    <option selected value="">Select Category</option>
                </select>
                @error('product_categories_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="form-group">
                <label for="title">Title</label>
                <input value="{{ old('title') }}" class="form-control col-md-11" type="text" name="title" id="title">
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="">
                <label for="url">URL</label>
                <input value="{{ old('url') }}" class="form-control col-md-11" type="text" name="url" id="url">
                @error('url')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="">
                <label for="image">Image</label>
                <input  class="form-control col-md-11" type="file" name="image" id="image">
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="">
                <label for="discount">Discount</label>
                <input value="{{ old('discount') }}" class="form-control col-md-11" type="number" name="discount" id="discount">
                @error('discount')
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
                <label for="meta_keywords">Meta Key Words</label>
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



            <div class="">
                <label for="description">Description</label>
                <textarea value="" class="form-control col-md-11" type="textarea" name="description" id="description">{{ old('description') }}</textarea>
                @error('description')
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


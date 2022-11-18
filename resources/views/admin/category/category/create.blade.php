@extends('templates.admin.master')


@section('main_content')
<div class="card col-md-12">
    <div class="card-header bg-primary">Add Product Category</div>
    <div class="card-body">
        <form action="{{ route('admin.productcategory.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="display: grid; grid-template-columns: 50% 50%; width: 100%;  grid-gap: 30px 10px; box-sizing: border-box;">


            <div class="">
                <label for="section">Section</label>
                <select  class=" selecttion form-control col-md-11 js-example-basic-single" name="product_sections_id" id="section">
                    <option selected value="">Select Section</option>
                    @foreach ($sections as $section)
                        <option value="{{ $section->id }}">{{ $section->title }}</option>
                    @endforeach
                </select>
                @error('section')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="">
                <label for="title">Title</label>
                <input value="{{ old('title') }}" class="form-control col-md-11" type="text" name="title" id="title">
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="">
                <label for="url">URL</label>
                <input   value="{{ old('url') }}" class="form-control col-md-11" type="text" name="url" id="url">
                @error('url')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="">
                <label for="image">Image</label>
                <input class="form-control col-md-11" type="file" name="image" id="image">
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="">
                <label for="discount">Discount</label>
                <input  value="{{ old('discount') }}" class="form-control col-md-11" type="number" name="discount" id="discount">
                @error('discount')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="">
                <label for="meta_title">Meta Title</label>
                <input  value="{{ old('meta_title') }}" class="form-control col-md-11" type="text" name="meta_title" id="meta_title">
                @error('meta_title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="">
                <label for="meta_description">Meta Description</label>
                <textarea class="form-control col-md-11"  name="meta_description" id="meta_description">{{ old('meta_description') }}</textarea>
                @error('meta_description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>



            <div class="">
                <label for="description">Description</label>
                <textarea  class="form-control col-md-11" type="textarea" name="description" id="description">{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="">
                <label for="meta_keywords">Meta Keywords</label>
                <input  value="{{ old('meta_keywords') }}" class="form-control col-md-11" type="text" name="meta_keywords" id="meta_keywords">
                @error('meta_keywords')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <input type="submit" value="Add" class="btn btn-primary btn-sm col-md-11">
        </div>
        </form>
    </div>
</div>
<script>

</script>
@endsection


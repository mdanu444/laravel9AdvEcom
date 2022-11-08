{{--  @foreach ($categories as $category)  --}}
    {{--  <option value="{{ $category->id }}">{{ $category->title }}</option>  --}}
{{--  @endforeach  --}}


<option value="">Select Category</option>
@foreach ($categories as $category)
    <option value="{{ $category->id }}">{{ $category->title }}</option>
 @endforeach


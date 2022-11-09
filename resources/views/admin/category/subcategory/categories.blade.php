@foreach ($section->product_categories as $category)
    <option value="{{ $category->id }}">{{ $category->title }}</option>
@endforeach

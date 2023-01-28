<option value="">Select District</option>
@foreach ($data as $item)
    <option value="{{ Crypt::encryptString($item->id) }}">Near {{ $item->name }}</option>
@endforeach

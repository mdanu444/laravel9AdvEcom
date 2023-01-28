<option value="">Select District</option>
@foreach ($data as $item)
    <option value="{{ Crypt::encryptString($item->id) }}">{{ $item->name }}</option>
@endforeach

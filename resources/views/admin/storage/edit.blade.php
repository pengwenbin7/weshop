@extends("layouts.admin")

@section("content")
  <form action="{{ route("admin.storage.update", $storage->id) }}" method="POST">
    {{ csrf_field() }}
    <input name="_method" type="hidden" value="PUT">
    name: <input name="name" type="text" value="{{ $storage->name }}" required/><br>
    brand_id: <input name="brand_id" type="number" value="{{ $storage->brand_id }}" required><br>
    func: <textarea name="func">{{ $storage->func }}</textarea>
    description: <input name="description" type="text" value="{{ $storage->description }}"><br>
    contact_name: <input name="contact_name" type="text" value="{{ $storage->address->contact_name or "" }}"><br>
    contact_tel: <input name="contact_tel" type="text" value="{{ $storage->address->contact_tel or "" }}"><br>
    province: <input name="province" type="text" value="{{ $storage->address->province }}" required><br>
    city: <input name="city" type="text" value="{{ $storage->address->city }}" required><br>
    district: <input name="district" type="text" value="{{ $storage->address->district }}"><br>
    code: <input name="code" type="number" value="{{ $storage->address->code }}" required><br>
    address-detail: <input name="detail" type="text" value="{{ $storage->address->detail }}"><br>
    <input type="submit" value="go">
  </form>
@endsection

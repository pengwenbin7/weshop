@extends("layouts.wechat")

@section("content")
  <div id="app">
    
    <form action="{{ route("wechat.address.store") }}" method="POST">
      @csrf
      contact_name: <input name="contact_name" type="text" value="sb"><br>
      contact_tel: <input name="contact_tel" type="text" value="12111111111"><br>
      province: <input name="province" type="text" value="北京市" required><br>
      city: <input name="city" type="text" value="东城区" required><br>
      district: <input name="district" type="text" value=""><br>
      code: <input name="code" type="number" value="110101" required><br>
      detail: <input name="detail" type="text" value="详细信息"><br>
      @submit
    </form>
    
  </div>
@endsection

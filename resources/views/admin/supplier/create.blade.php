<form action="{{ url("/admin/supplier") }}" method="POST">
  @csrf
  <input name="name" type="text" value="测试供应"/>
  <input name="phone" type="text" value="18113054377"/>
  @submit
</form>

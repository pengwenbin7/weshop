@extends( "layouts.wechat2")
@section( "content")
  <div class="container">
     <div class="company" id = "app" >
      <div class="grid">
        <div class="item">
          <div class="lable">
            头像
          </div>
          <div class="content">
            <img src="{{ asset("assets/img/company.png") }}" />
          </div>
        </div>
        <div class="item">
          <div class="label">
            企业名称
          </div>
          <div class="content">
             {{ $company->name }}
          </div>
        </div>
        <div class="item">
          <div class="label">
            企业法人
          </div>
          <div class="content">
             {{ $company->oper_name }}
          </div>
        </div>
        <div class="item">
          <div class="label">
            信用代码
          </div>
          <div class="content">
             {{ $company->code }}
          </div>
        </div>
      </div>

  </div>

  </div>
  <div class="delete-company" onclick="deleteCompany()">
    <span>删除公司信息</span>
  </div>
@endsection
@section("script")
<script type="text/javascript">
  function deleteCompany(){
    axios.delete("{{route("wechat.company.destroy" ,$company->id)}}")
    .then(function(res){
      if(res.data.destroy){
        alert("公司删除成功");
        location.assign("{{ route("wechat.home.index")}}");
      }
    })
  }
</script>
@endsection

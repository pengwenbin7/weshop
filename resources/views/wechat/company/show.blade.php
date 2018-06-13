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
            <img src="http://m.taihaomai.com/images/logo2.png"/>
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
            法人
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
@endsection
@section("script")

@endsection

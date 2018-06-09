@extends( "layouts.wechat2")

@section( "content")
  <div class="container">
    <div class="company" id = "app">
        <input type="text" name="keyword" value="" placeholder="请输入你的公司名，企业码">
      <input type="button" name="" value="搜索" @click="getCompany('aaa')">
      <div class="">
        -------------------------------
      </div>
      <div class="row" v-for="item in company">
        <div class="title">
         名字 @{{ item.Name }}
        </div>
        <div class="title">
         信用代码 @{{ item.CreditCode }}
        </div>
        <div class="title">
         法人 @{{ item.OperName }}
        </div>
        <div class="title">
         地址 @{{ item.Address }}
        </div>
        <br><br>
      </div>
    </div>
  </div>
@endsection
@section("script")
  <script type="text/javascript">
    var app = new Vue({
      el:"#app",
      data:{
        company:[],
      },
      methods:{
        getCompany:function(key){
          var _this = this;
          axios.get('{{ route("wechat.home.company_list") }}')
            .then(function(res){
              console.log(res);
              _this.company = res.data.Result;
              console.log(_this.company);
            })
        }
      }
    })
  </script>
@endsection

@extends( "layouts.wechat2")
<style media="screen">
  .company .search{
    background-color: #FFF;
    display: flex;
    display: -webkit-flex;
    margin-top: .4rem;
    margin-bottom: .4rem;
    padding: .2rem .4rem;
  }
  .company .search .txt{
    flex: 1;
    -webkit-flex:1;
  }
  .company .search .btn-search{
    float:right;
    height: .6rem;
    width: 2rem;
    background: none;
    text-align: right;
  }
  .company .row{
    background-color: #fff;
    margin-bottom: .2rem;
    padding: .4rem;
  }
  .company-name{
    margin-bottom: .4rem;
  }
  .company .q .btn{
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    text-align: center;
    line-height: 1.2rem;
    background-color: #009b45;
    color: #fff;
    letter-spacing: 3px;
}
</style>
@section( "content")
  <div class="container">
     <div class="company" id = "app" >
    @if ($company)
      <div class="company-name">
        <div class="search">
         {{ $company->name }}
        </div>
      </div>
      <div class="row">
        <div class="title">
         电话: {{ $company->company_tel }}
        </div>
        <div class="title">
         地址:{{ $company->address->province }}{{ $company->address->city }}
        </div>
      </div>
    @else
      <div class="s" v-show="s">
        <div class="search">
          <input type="text" class="txt" id="keyword" name="keyword" value="" placeholder="请输入你的公司名，企业码">
        <input type="button" class="btn-search" name="" value="搜索" @click="getCompany('aaa')">
        </div>
        <div class="row"  v-for="(item,index) in companys" @click="choseCompany(index)">
          <div class="title">
           名字: @{{ item.Name }}
          </div>
          <div class="title">
           法人: @{{ item.OperName }}
          </div>
          <div class="title">
           信用代码: @{{ item.CreditCode }}
          </div>
        </div>
        </div>
        <div class="q" v-show="q"  v-lock>
          <div class="row"  >
            <div class="title">
             名字: @{{ company.Name }}
            </div>
            <div class="title">
             法人: @{{ company.OperName }}
            </div>
            <div class="title">
             信用代码: @{{ company.CreditCode }}
            </div>
          </div>
          <div class="btn" @click = "saveCompany">
            保存
          </div>
        </div>

    @endif
  </div>

  </div>
@endsection
@section("script")
  <script type="text/javascript">
    var app = new Vue({
      el:"#app",
      data:{
        companys:[],
        company:[],
         s:true,
         q:false,

      },
      methods:{
        getCompany:function(key){
          var _this = this;
          var keyword = document.querySelector("#keyword").value;
          if(keyword){
            axios.get('http://i.yjapi.com/ECIV4/Search?key=988eef9debf242ff97c69515a262327d&dtype=json&keyword='+keyword)
              .then(function(res){
                _this.companys = res.data.Result;
              })
          }

        },
        choseCompany:function(index){
          this.company = this.companys[index];
          this.q = true;
          this.s = false;
        },
        saveCompany:function(){
          console.log(1);
          if(this.company.Name){
            axios.post("{{ route("wechat.home.company_store")}}",this.company)
            .then(function(res){
              console.log(res);
            })
          }
        }
      }
    })
  </script>
@endsection

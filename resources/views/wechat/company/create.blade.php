@extends( "layouts.wechat2")
@section( "content")
  <div class="container">
    <div class="company" id = "app" v-cloak>

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
        <div class="q" v-show="q">
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
          axios.get("{{ route("wechat.company.fetch") }}?keyword="+keyword)
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
        if(this.company.Name){
          axios.post("{{ route("wechat.company.store")}}",this.company)
            .then(function(res){
              alert("公司添加成功");
              location.assign("{{ route("wechat.home.index") }}");
            });
        }
      }
    }
  })
  </script>
@endsection

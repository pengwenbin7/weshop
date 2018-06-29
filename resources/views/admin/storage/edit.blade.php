@extends("layouts.admin")

@section("content")
  <div class="col-md-12" v-cloak>
    <div class="box box-info">
      <div class="box-header with-border">
	<h3 class="box-title"><a href="{{ route("admin.storage.index") }}">仓库列表</a></h3>
	<h3 class="box-title">添加</h3>
      </div>
      <form class="form-horizontal" action="{{ route("admin.storage.update", $storage->id) }}" method="POST">
	<div class="box-body">
	  {{ csrf_field() }}
	  {{ method_field("PUT") }}
          <div class="form-group">
            <label for="name" class="col-sm-2 control-label">名字</label>
            <div class="col-sm-10">
              <input class="form-control" id="name" name="name" type="text" required value="{{ $storage->name }}">
            </div>
          </div>

	  <div class="form-group">
            <label for="brand" class="col-sm-2 control-label">品牌</label>
            <div class="col-sm-10">
              <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="brand_id">
		@foreach ($brands as $brand)
		  @if ($brand->id == $storage->brand_id)
		    <option value="{{ $brand->id }}" selected>{{ $brand->name }}</option>
		  @else
		    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
		  @endif
		@endforeach
              </select>
            </div>
          </div>

          <div class="form-group">
            <label for="func" class="col-sm-2 control-label">运费公式</label>
            <div class="col-sm-9">
              <div class="clo-sm-10" v-for="(item,index) in fee.area">
                <div class="row">
                  <label for="" class="col-sm-1 control-label">起(KG)</label> <input type="text" class="col-sm-1" name="" :id="'low_'+index" v-model="item.low" :value="item.low" placeholder="" readonly>
                  <label for="" class="col-sm-1 control-label">止(KG)</label><input type="text" class="col-sm-1"  name="" :id="'up_'+index" v-model="item.up" :value="item.up" placeholder="">
                  <label for="" class="col-sm-1 control-label">系数</label> <input type="text" class="col-sm-1"  name="" :id="'factor_'+index" v-model="item.factor" :value="item.factor" placeholder="">
                  <label for="" class="col-sm-1 control-label">常数</label> <input type="text" class="col-sm-1"  name="" :id="'const_'+index" v-model="item.const" :value="item.const" placeholder="">
                </div>
                <br>
              </div>

              <textarea class="form-control hide" id="func" name="func" readonly>
                @{{  JSON.stringify(fee) }}
              </textarea>

            </div>
            <div class="clo-sm-1">
              <button type="button" class="btn btn-info " name="button" @click="feeAdd">+</button>
              <button type="button" class="btn btn-info " name="button" @click="feeReset">重置</button>
            </div>
          </div>

	  <div class="form-group">
            <label for="description" class="col-sm-2 control-label">仓库描述</label>
            <div class="col-sm-10">
              <input name="description" id="description" class="form-control" value="{{ $storage->description }}">
	    </div>
          </div>
          <div id="address-selector">
            <div class="form-group">
              <label for="contact_name" class="col-sm-2 control-label">联系人</label>
              <div class="col-sm-10">
                <input class="form-control" id="contact_name" name="contact_name" type="text" value="{{ $address->contact_name }}" required>
              </div>
            </div>
            <div class="form-group">
              <label for="contact_name" class="col-sm-2 control-label">联系电话</label>
              <div class="col-sm-10">
                <input class="form-control" id="contact_tel" name="contact_tel" type="text" value="{{ $address->contact_tel }}">
              </div>
            </div>
            <div class="form-group">
              <input v-model="code" type="hidden" name="code" value="{{ $address->code }}" required>
              <label class="col-sm-2 control-label">地区</label>
              <div class="col-sm-10">
                <div class="col-sm-4">
                  <select class="form-control" name="province" v-model="province"  required @change="changeProvince">
                    <option v-for="option in provinces"  v-bind:value="option.id">
                      @{{ option.fullname }}
                    </option>
		  </select>
                </div>
                <div class="col-sm-4">
                  <select class="form-control" name="city" v-if="cities.length" v-model="city" required @change="changeCity">
                    <option v-for="option in cities" v-bind:value="option.id">
                      @{{ option.fullname }}
                    </option>
		  </select>
                </div>
                <div class="col-sm-4">
                  <select class="form-control" name="district" v-if="districts.length" v-model="district" required @change="changeDistrict">
                    <option v-for="option in districts" v-bind:value="option.id">
                      @{{ option.fullname }}
                    </option>
		  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="detail" class="col-sm-2 control-label">详细地址</label>
              <div class="col-sm-10">
                <input class="form-control" id="detail" name="detail" type="text" value="{{ $address->detail }}" required>
              </div>
            </div>
          </div>
	</div>

	<div class="box-footer">
          <button type="submit" class="btn btn-info btn-block">确定</button>
	</div>
      </form>
    </div>
  </div>

@endsection

@section("script")
  <script>
  const app = new Vue({
    el: '#app',
    data: {
      province: "{{ $province?$province->id:'' }}",
      provinces: [],
      city: "{{ $city?$city->id:'' }}",
      cities: [],
      district: "{{ $district?$district->id:'' }}",
      districts: [],
      code: {{ $address->code }},
      fee:{!! $storage->func !!},
    },
    beforeMount: function () {
      this.$nextTick(function () {
        var $this = this;
        axios.get("/region/children")
          .then(function(res) {
            $this.provinces = res.data;
          });

        axios.get("/region/children/" + this.province)
          .then(function(res) {
            $this.cities = res.data;
          });

        axios.get("/region/children/" + this.city)
          .then(function(res) {
            $this.districts = res.data;
            // 判断是否还有第三级
            if (!res.data.length) {
              console.log($this);
            } else {

            }
          });
      })
    },
    methods: {
      check:function(){
        var arr = this.fee.area;
        var length = arr.length-1;
        var result = false;
        console.log(arr[length].up,arr[length].low);
        if(arr[length].up<=arr[length].low){
          alert("公式输入不正确");
          return false;
        }else{
          console.log(2);
          result =true;
        }
        return result;
      },
      feeAdd:function(){
        var index = this.fee.area.length-1;
        var low = Number(document.getElementById('low_'+index).value);
        var up =Number(document.getElementById('up_'+index).value);
        var factor =Number(document.getElementById('factor_'+index).value);
        var _const =Number(document.getElementById('const_'+index).value);
        var arr = {
          "low":up,
          "up":0,
          "factor":0,
          "const":0
        };
        console.log(low,up,factor,_const);
        if (up <= low) {
          alert("第二个数字必须大于第一个数字")
            return
        }
        this.fee.area.push(arr)
          console.log(this.fee);
      },
      feeReset:function(){
        this.fee={"area":[{"low":0,"up":0,"factor":0,"const":0}],"other":{"const":0,"factor":0}}
      },
      changeProvince: function() {
        var $this = this;
        axios.get("/region/children/" + this.province)
          .then(function(res) {
            $this.cities = res.data;
            $this.districts = [];
            $this.city = null;
            $this.district = null;
            $this.code = null;
          });
      },
      changeCity: function() {
        if (!this.city) {
          return;
        }
        var $this = this;
        axios.get("/region/children/" + this.city)
          .then(function(res) {
            $this.districts = res.data;
            // 判断是否还有第三级
            if (!res.data.length) {

              console.log($this);
            } else {

            }
            $this.district = null;
          });
      },
      changeDistrict: function() {
        this.code = this.district;
      },
    }

  });
  </script>
@endsection

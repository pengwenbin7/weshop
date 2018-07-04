@extends("layouts.admin")

@section("content")
  <div class="col-md-6">
    <div class="box box-info">
      <div class="box-header with-border">
	<h3 class="box-title"><a href="{{ route("admin.product.index") }}">产品列表</a></h3>
	<h3 class="box-title">添加</h3>
      </div>
      <form class="form-horizontal" action="{{ route("admin.product.store") }}" method="POST">
	<div class="box-body">
	  {{ csrf_field() }}
          <div class="form-group">
	    <label for="name" class="col-sm-2 control-label">名字</label>
	    <div class="col-sm-10">
	      <input class="form-control" id="name" name="name" type="text" required>
            </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">分类</label>
	    <div class="col-sm-10">
	      <select class="form-control select2" name="category_id" required>
		@foreach ($categories as $category)
		  <option value="{{ $category->id }}">{{ $category->name }}</option>
		@endforeach
	      </select>
            </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">品牌</label>
	    <div class="col-sm-10">
	      <select class="form-control select" name="brand_id" v-model="brand" @change="brandChange" required>
		@foreach ($brands as $brand)
		  <option value="{{ $brand->id }}">{{ $brand->name }}</option>
		@endforeach
	      </select>
            </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">型号</label>
	    <div class="col-sm-10">
	      <input class="form-control" name="model" type="text" required
		      placeholder="不可重复">
            </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">仓库</label>
	    <div class="col-sm-10">
	      <select class="form-control select2" name="storage_id" required>
		<option v-for="option in storages" v-bind:value="option.id">
		  @{{ option.name }}
		</option>
	      </select>
            </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">包装</label>
	    <div class="col-sm-10">
	      <div class="form-group col-sm-4">
		<input class="form-control" name="content" type="number"
			v-model="content" required value="25" placeholder="25">
	      </div>
	      <div class="form-group col-sm-4">
		<input class="form-control" name="measure_unit" type="text"
			required value="kg" v-model="measure_unit"
			placeholder="kg">
	      </div>
	      <div class="form-group col-sm-4">
		<input class="form-control" name="packing_unit" type="text"
			placeholder="包" required value="包">
	      </div>
            </div>
	  </div>

	  <div class="form-group" v-if="is_ton">
	    <label class="col-sm-2 control-label">吨价</label>
	    <div class="col-sm-4">
	      <div class="input-group">
		<div class="input-group-addon">￥</div>
		<input type="number" class="form-control"
			min="0" step="0.01" v-model="ton_price">
	      </div>
	    </div>
	  </div>
	  
	  <div class="form-group">
	    <label class="col-sm-2 control-label">单价</label>
	    <div class="col-sm-4">
	      <div class="input-group">
		<div class="input-group-addon">￥</div>
		<input type="number" class="form-control" name="unit_price"
			v-model="unit_price" min="0" step="0.01" required>
	      </div>
	    </div>
	  </div>
	  
	  <div class="form-group">
	    <label class="col-sm-2 control-label">库存</label>
	    <div class="col-sm-4">
	      <input class="form-control" name="stock" type="number"
		      min="0" step="1" required>
            </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">上架</label>
	    <div class="col-sm-4">
	      <label>是<input name="active" type="radio" value="1" checked></label>
	      &nbsp;&nbsp;&nbsp;&nbsp;
	      <label>否<input name="active" type="radio" value="0"></label>
            </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">排序</label>
	    <div class="col-sm-4">
	      <input class="form-control" name="sort_order" type="number"
		      value="1000" min="0" step="1" required>
            </div>
	  </div>

	  <div class="form-group">
            <label class="col-sm-2 control-label">详细</label>
            <div class="col-sm-10">
	      <textarea cols="" name="detail" rows="">
	      </textarea>
            </div>
	  </div>
	</div>
		  <input type="hidden" value="{{ $limit }}" name="limit">
		  <input type="hidden" value="{{ $name }}" name="sname">
	<div class="box-footer">
	  <button type="submit" class="btn btn-info btn-block">确定</button>
	</div>
      </form>
    </div>
  </div>

@endsection

@section("script")
  <script>
  var vue = new Vue({
    el: "#app",
    data: {
      brand: null,
      storages: [],
      measure_unit: "kg",
      ton_price: null,
      content: 25
    },
    computed: {
      is_ton: function () {
	return this.is_ton = (1000 % this.content == 0) && (this.measure_unit == "kg");
      },
      factor: function () {
	return this.is_ton? (1000 / this.content): 0;
      },
      unit_price: function () {
	return this.ton_price / this.factor;
      }
    },
    methods: {
      brandChange: function () {
	var $this = this;
	var url = "{{ route("admin.storage.index") }}" + "?api=1&limit=100000&common=1&brand_id=" + this.brand;
	axios.get(url)
	  .then(function (res) {
	    $this.storages = res.data;
	  });
      }
    }
  });
  </script>
@endsection

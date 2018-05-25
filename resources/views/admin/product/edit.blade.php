@extends("layouts.admin")

@section("style")
  
@endsection

@section("content")
  <div class="col-md-6">
    <div class="box box-info">
      <div class="box-header with-border">
	<h3 class="box-title"><a href="{{ route("admin.product.index") }}">产品列表</a></h3>
	<h3 class="box-title">编辑</h3>
      </div>
      <form class="form-horizontal" action="{{ route("admin.product.update", $product) }}" method="POST">
	<div class="box-body">
	  {{ csrf_field() }}
	  {{ method_field("PUT") }}
          <div class="form-group">
	    <label for="name" class="col-sm-2 control-label">名字</label>
	    <div class="col-sm-10">
	      <input class="form-control" id="name" name="name" type="text"
		      required value="{{ $product->name }}">
            </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">分类</label>
	    <div class="col-sm-10">
	      <select class="form-control select2" name="category_id" required>
		@foreach ($categories as $category)
		  @if ($category->id == $product->category()->id)
		    <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
		  @else
		    <option value="{{ $category->id }}">{{ $category->name }}</option>
		  @endif
		@endforeach
	      </select>
            </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">品牌</label>
	    <div class="col-sm-10">
	      <select class="form-control select" name="brand_id" v-model="brand" @change="brandChange" required>
		@foreach ($brands as $brand)
		  @if ($brand->id == $product->brand_id)
		    <option value="{{ $brand->id }}" selected>{{ $brand->name }}</option>
		  @else
		    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
		  @endif
		@endforeach
	      </select>
            </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">型号</label>
	    <div class="col-sm-10">
	      <input class="form-control" name="model" type="text" required
		      value="{{ $product->model }}" placeholder="不可重复">
            </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">仓库</label>
	    <div class="col-sm-10">
	      <select v-if="storages.length" class="form-control select2" name="storage_id" required>
		<option v-for="option in storages" v-bind:value="option.id">
		  @{{ option.name }}
		</option>
	      </select>
	      <select v-else class="form-control select2" name="storage_id" required>
		@foreach ($product->brand->storages as $storage)
		  @if ($storage->id == $product->storage_id)
		    <option value="{{ $storage->id }}" selected>
		      {{ $storage->name }}
		    </option>
		  @else
		    <option value="{{ $storage->id }}">
		      {{ $storage->name }}
		    </option>
		  @endif
		@endforeach
	      </select>
            </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">包装</label>
	    <div class="col-sm-10">
	      <div class="form-group col-sm-4">
		<input class="form-control" name="content" type="number"
			required value="{{ $product->content }}" placeholder="25">
	      </div>
	      <div class="form-group col-sm-4">
		<input class="form-control" name="measure_unit" type="text"
			required value="{{ $product->measure_unit }}"
			placeholder="kg">
	      </div>
	      <div class="form-group col-sm-4">
		<input class="form-control" name="packing_unit" type="text"
			placeholder="包" required value="{{ $product->packing_unit }}">
	      </div>
            </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">单价</label>
	    <div class="col-sm-4">
	      <div class="input-group">
		<div class="input-group-addon">￥</div>
		<input type="number" class="form-control" name="unit_price"
			min="0" step="0.01" required value="{{ $product->variable->unit_price }}">
	      </div>
	    </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">库存</label>
	    <div class="col-sm-4">
	      <input class="form-control" name="stock" type="number"
		      min="0" step="1" required
		      value="{{ $product->variable->stock }}">
            </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">上架</label>
	    <div class="col-sm-4">
	      @if ($product->active)
		<label>是<input name="active" type="radio" value="1" checked></label>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<label>否<input name="active" type="radio" value="0"></label>
	      @else
		<label>是<input name="active" type="radio" value="1"></label>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<label>否<input name="active" type="radio" value="0" checked></label>
	      @endif
            </div>
	  </div>
	  
	  <div class="form-group">
	    <label class="col-sm-2 control-label">排序</label>
	    <div class="col-sm-4">
	      <input class="form-control" name="sort_order" type="number"
		      min="0" step="1" required
		      value="{{ $product->sort_order }}">
            </div>
	  </div>

	  <div class="form-group">
            <label class="col-sm-2 control-label">详细</label>
            <div class="col-sm-10">
	      <textarea cols="" name="detail" rows="">
		{!! $product->detail->content ?? "" !!}
	      </textarea>
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
  var vue = new Vue({
    el: "#app",
    data: {
      brand: "{{ $product->brand_id }}",
      storages: []
    },
    methods: {
      brandChange: function () {
	var $this = this;
	var url = "{{ route("admin.storage.index", ["api" => 1]) }}" + "&brand_id=" + this.brand;
	axios.get(url)
	  .then(function (res) {
	    $this.storages = res.data;
	  });
      }
    }
  });
  </script>
@endsection

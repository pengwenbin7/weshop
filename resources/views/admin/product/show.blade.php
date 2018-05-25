@extends("layouts.admin")

@section("style")

@endsection

@section("content")
  <div class="col-md-6">
    <div class="box box-info">
      <div class="box-header with-border">
	<h3 class="box-title">
	  <a href="{{ route("admin.product.edit", $product) }}">编辑</a>
	</h3>
	<h3 class="box-title">查看</h3>
      </div>
      <div class="form-horizontal">
	<div class="box-body">
          <div class="form-group">
	    <label for="name" class="col-sm-2 control-label">名字</label>
	    <div class="col-sm-10">
	      {{ $product->name }}
            </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">分类</label>
	    <div class="col-sm-10">
	      {{ $product->category()->name }}
            </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">品牌</label>
	    <div class="col-sm-10">
	      {{ $product->brand->name }}
            </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">型号</label>
	    <div class="col-sm-10">
	      {{ $product->model }}
            </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">仓库</label>
	    <div class="col-sm-10">
	      {{ $product->storage->name }}
            </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">包装</label>
	    <div class="col-sm-10">
	      {{ $product->content }}
	      {{ $product->measure_unit }}
	      /
	      {{ $product->packing_unit }}
	    </div>
          </div>
	</div>

	<div class="form-group">
	  <label class="col-sm-2 control-label">单价</label>
	  <div class="col-sm-4">
	    <div class="input-group">
	      ￥{{ $product->variable->unit_price }}
	    </div>
	  </div>
	</div>

	<div class="form-group">
	  <label class="col-sm-2 control-label">库存</label>
	  <div class="col-sm-4">
	    {{ $product->variable->stock }}
          </div>
	</div>

	<div class="form-group">
	  <label class="col-sm-2 control-label">上架</label>
	  <div class="col-sm-4">
	    @if ($product->active)
	      是
	    @else
	      否
	    @endif
          </div>
	</div>

	<div class="form-group">
	  <label class="col-sm-2 control-label">排序</label>
	  <div class="col-sm-4">
	    {{ $product->sort_order }}
          </div>
	</div>

	<div class="form-group">
          <label class="col-sm-2 control-label">详细</label>
          <div class="col-sm-10">
	    {{ $product->detail->content ?? "" }}
          </div>
	</div>
      </div>
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

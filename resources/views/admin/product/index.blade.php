@extends("layouts.admin")

@section("content")

  <div class="box">
    <div class="box-header">
      <h3 class="box-title">产品列表</h3>
      <h3 class="box-title">
	<a href="{{ route("admin.product.create", ["limit" => $limit, "name" => $name]) }}">添加</a>
      </h3>
    </div>
    <div class="box-body">
      <div class="dataTables_wrapper form-inline dt-bootstrap">
	<div class="row">
	  <div class="col-sm-6">
	    <div class="dataTables_length">
	      <form action="{{ url()->current() }}">
		<label>
		  每页
		  <select name="limit" class="form-control input-sm">
		    <option value="10" {{ $limit == 10 ? 'selected':'' }}>10</option>
                    <option value="25" {{ $limit == 25 ? 'selected':'' }}>25</option>
                    <option value="50" {{ $limit == 50 ? 'selected':'' }}>50</option>
                    <option value="100" {{ $limit == 100 ? 'selected':'' }}>100</option>
		  </select>
		  条
		</label>
		<label>
		  <input class="form-control input-sm" name="name" value="{{ $name }}" placeholder="" type="search">
		  <button>搜索</button>
		</label>
	      </form>
	    </div>
	  </div>
	</div>
	<div class="row">
	  <div class="col-sm-12 table-responsive">
	    <table class="table table-bordered table-striped dataTable table-hover table-condensed" role="grid">
	      <thead>
		<tr>
		  <th>序号1</th>
		  <th>名字</th>
		  <th>品牌</th>
		  <th>型号</th>
		  <th>分类</th>
		  <th>仓库</th>
		  <th>重量</th>
		  <th>规格</th>
		  <th style="width:80px">库存</th>
		  <th>价格</th>
		  <th style="width:80px">吨价</th>
		  <th>上架</th>
		  <th>操作</th>
		</tr>
	      </thead>
	      <tbody>
		@foreach ($products as $item)
		  <tr role="row">
		    <td>{{ $item->id }}</td>
		    <td>{{ $item->name }}</td>
		    <td>{{ $item->brand->name }}</td>
		    <td>{{ $item->model }}</td>
		    <td>{{ $item->category()->name }}</td>
		    <td>{{ $item->storage->name }}</td>
		    <td>{{ $item->content }}-{{ $item->measure_unit }}</td>
		    <td>{{ $item->packing_unit }}</td>
		    <td ondblclick="stock({{ $item->variable->id }})">
                      <input type="number" disabled="true" onblur="onclnum({{ $item->variable->id }},{{ $item->variable }})" style="width:100%;height:100%;border:none" value="{{ $item->variable->stock }}" id="number{{ $item->variable->id }}">
		    </td>
		    <td id="un{{ $item->id }}">
                      {{ $item->variable->unit_price }}
		    </td>
		    <td ondblclick="myprice({{ $item->id }})">
		      @if ($item->is_ton)

			<input type="number" disabled="true" onblur="onprice({{ $item->id }},{{ $item->variable->unit_price }})" style="width:100%;height:100%;border:none" value="{{ round($item->variable->unit_price * 1000 / $item->content,2) }}" id="price{{ $item->id }}">

		      @else
			--
		      @endif
		    </td>
		    <td>
		      @if ($item->active)
			是
		      @else
			否
		      @endif
		    </td>
		    <td>
		      <a href="{{ route("admin.product.edit", $item) }}">编辑</a>
		      &nbsp;|&nbsp;
		      <a href="{{ route("admin.product.show", $item) }}">详细</a>
		    </td>
		  </tr>
		@endforeach
	      </tbody>
	    </table>
	  </div>
	</div>

      </div>
    </div>
    <div class="box-footer">
      <div class="row">
	{{ $products->appends(["limit" => $limit, "name" => $name])->links() }}
      </div>
    </div>
  </div>
  <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdn.bootcss.com/layer/3.1.0/layer.js"></script>
  <script>
  var number=0;
  function stock(obj){
    $("#number"+obj).attr("disabled", false);
    number = $("#number"+obj).val();
  }
  var fprice=0;
  function myprice(obj){
    $("#price"+obj).attr("disabled", false);
    fprice = $("#price"+obj).val();
  }
  //修改库存
  function onclnum(obj,item)
  {
    var number = $('#number'+obj).val();
    var onurl = "{{ route('admin.product.modifying') }}";
    var data = {id:obj,number:number,item:JSON.stringify(item)};
    axios.post(onurl,data)
      .then(function (res) {
	if(res.status == 200){
          var p = res.data;
          if(p.status == 'ok'){
          }else{
            $('#number'+obj).val(number);
          }
	}else{
          $('#number'+obj).val(number);
	}
        $("#number"+obj).attr("disabled", true);
      })
  }
  //修改价格
  function onprice(obj,un_price)
  {
    var price = $('#price'+obj).val();//吨价
    var onurl = "{{ route('admin.product.modifying') }}";
    var data = {id:obj,price:price,un_price:un_price};
    axios.post(onurl,data)
      .then(function (res) {
        if(res.status == 200){
          var p = res.data;
          if(p.status == 'ok'){
            $('#un'+obj).text(p.un_price);
          }else{
            $('#price'+obj).val(fprice);
          }
        }else{
          $('#price'+obj).val(fprice);
        }
        $("#price"+obj).attr("disabled", true);
      })
  }
  </script>
@endsection

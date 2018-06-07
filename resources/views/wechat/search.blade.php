@extends("layouts.wechat2")

@section("style")
@endsection
@section("content")
  <div class="container">
    <div class="searchs" id="app">
      <div class="header">
        <div class="search">
          <div class="search-box">
            <form action="{{ route("wechat.search") }}" method="get">
              <input type="text" class="search-inp" name="keyword" id="search_inp" value="" placeholder="快速搜索" />
              <i class="iconfont icon-sousuo"></i>
              <input class="btn-submit" type="hidden" />
            </form>
          </div>
        </div>
      </div>
      <div class="apply-goods">
	<!-- <p>如未找到合适商品，点此可申请所需产品
        <a href="apply_product.html">申请采购</a>
	</p> -->
      </div>
      <div class="products" id="product" >
	@foreach($products as $product)
	  <div class="product">
	    <a href="{{ route("wechat.product.show", $product->id) }}">
	      <div class="prop">
		<p class="black">
		  <span class="p-name">{{ $product->product->name }}</span>
		  <span class="p-model">{{ $product->product->model }}</span>
		</p>
		<p class="gray">
		  <span class="p-bname">{{ $product->product->brand->name }}</span>
		</p>
		<p class="pirce">
		  @if($product->product->is_ton)
		    <span class="y"><i>￥</i>{{ $product->product->variable->unit_price*1000/$product->product->content }}/吨</span>
		  @else
		    <span class="y"><i>￥</i>{{ $product->product->variable->unit_price }}/{{ $product->product->packing_unit }}</span>
		  @endif
		</p>
	      </div>
	    </a>
	  </div>
	@endforeach
      </div>
    </div>

  </div>
@endsection
@section("script")
  <script type="text/javascript">
  onload = function(){
    var input = document.getElementById("search_inp");
    input.focus();
  }
  </script>

@endsection

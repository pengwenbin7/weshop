@extends( "layouts.wechat")
@section( "content")
  <div class="container">
    <div class="index" id="app">
      <div class="search">
    	<div class="i-search">
    	  <a  href="{{ route("wechat.search") }}">
    	    <input type="text" name="keyword" id="keyword" value="" placeholder="输入关键词快速查找商品" />
    	    <input class="btn-submit" type="submit" value="找货" />
    	  </a>
    	</div>
    	<div class="hot-search">
    	  <div class="title">
    	    <span>热搜</span>
    	  </div>
    	  <div class="h-list">
    	    @foreach ($hot_search as $item)
    	      <a href="{{ route("wechat.search") }}?keyword={{ $item->keyword }}">{{ $item->keyword }}</a>
    	    @endforeach
    	  </div>
    	</div>
      </div>
      <div class="products" id="product">
	<div class="title">
          <span>热卖</span>
	</div>
	@foreach($products as $product)
	  @if ($product->active)
	    <div class="product">
              <a href="{{ route("wechat.product.show", $product->product->id) }}">
		<div class="prop">
		  <p class="p-name">
		    <span>{{ $product->product->name }}</span>
		    <span>{{ $product->product->model }}</span>
		  </p>
		  <p class="p-bname">
		    <span>{{ $product->product->brand->name }}</span>
		    <span class="p-stock">库存:{{ $product->stock }}</span>
		  </p>
		  <p class="pirce">
                    <span class="y"><i>￥</i>{{ $product->product->price }}</span>
                    <span class="right">{{ $product->product->address  }}</span>
		  </p>
		</div>
              </a>
	    </div>
	  @endif
	@endforeach
      </div>
    </div>
  </div>
@endsection

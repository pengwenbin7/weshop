@extends( "layouts.wechat2")
@section( "content")
  <div class="search-box">
    <form action="{{ route("wechat.search") }}" method="get">
      <input type="text" class="search-inp" name="keyword" id="search_inp" value="" placeholder="快速搜索" />
      <i class="iconfont icon-sousuo" onclick="document.forms[0].submit()"></i>
      <input class="btn-submit" type="hidden" />
    </form>
  </div>

<div class="container searchs">
    <div class="list-view">
      <div class="products" id="product">
        @foreach($products as $product)
        <div class="product">
          <a href="{{ route("wechat.product.show", $product->id) }}">
            <div class="prop">
              <p class="p-name">
                <span>{{ $product->name }}</span>
                <span>{{ $product->model }}</span>
              </p>
              <p class="p-bname">
                <span>{{ $product->brand->name }}</span>
                <span class="p-stock">库存:{{ $product->stock }}</span>
              </p>
              <p class="pirce">
                  <span class="y"><i>￥</i>{{ $product->price }}</span>
                  <span class="right">{{ $product->address }}</span>
              </p>
            </div>
          </a>
        </div>
        @endforeach
      </div>
    </div>

  </div>
@endsection
@section( "script")
<script type="text/javascript">
  onload = function() {
    var input = document.getElementById("search_inp");
    input.focus();
  }
</script>

@endsection

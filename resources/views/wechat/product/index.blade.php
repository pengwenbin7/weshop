@extends("layouts.app")

@section("content")

  @foreach ($products as $product)
    name: {{ $product->name }}
    <br>
    brand_id: {{ $product->brand_id }}
    <br>
    brand_name: {{ $product->brand->name }}
    <br>
    model: {{ $product->model }}
    <br>    
    包装: {{ $product->pack() }}
    <br>    
    是否可以按吨购买: {{ $product->ton_sell }}
    <br>    
    唯一码: {{ $product->unique_code }}
    <br>    
    @foreach ($product->categories as $category)
      分类： {{ $category->name }}
      <br>
    @endforeach
    仓库: {{ $product->storage->name }}
    <br>    
    单价: {{ $product->price()->unit_price }}
    <br>
    吨价: {{ $product->price()->ton_price }}
    <br>
    detail: {{ $product->detail->content }}
    <br>    
    @php
    $variable = $product->variable;
    @endphp
    库存: {{ $variable->stock }}
    <br>    
    点击: {{ $variable->click }}
    <br>    
    收藏: {{ $variable->star }}
    <br>    
    购买: {{ $variable->buy }}
    <br>    
    退货: {{ $variable->back }}
    <br>==================================<br>
  @endforeach
  {{ $products->links() }}
  
@endsection

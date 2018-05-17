@extends("layouts.admin")

@section("content")
  <div class="col-md-6" id="app">
    <div class="box box-info">
      <div class="box-header with-border">
	<h3 class="box-title"><a href="{{ route("admin.storage.index") }}">仓库列表</a></h3>
        <h3 class="box-title">添加</h3>
      </div>
      <form class="form-horizontal" action="{{ route("admin.storage.store") }}" method="POST">
	{{ csrf_field() }}
        <div class="box-body">
          <div class="form-group">
            <label for="name" class="col-sm-2 control-label">名字</label>
            <div class="col-sm-10">
              <input class="form-control" id="name" name="name" placeholder="不可重复" type="text" required>
            </div>
          </div>

	  <div class="form-group">
            <label for="brand" class="col-sm-2 control-label">品牌</label>
            <div class="col-sm-10">
              <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="brand_id">
		@foreach ($brands as $brand)
		  <option value="{{ $brand->id }}">{{ $brand->name }}</option>
		@endforeach
              </select>
            </div>
          </div>

	  <div class="form-group">
            <label for="func" class="col-sm-2 control-label">运费公式</label>
            <div class="col-sm-10">
              <textarea class="form-control" id="func" name="func">
	      </textarea>
            </div>
          </div>

	  <div class="form-group">
            <label for="description" class="col-sm-2 control-label">仓库描述</label>
            <div class="col-sm-10">
              <input name="description" id="description" class="form-control">
	    </div>
          </div>

	  <div class="form-group">
            <label for="description" class="col-sm-2 control-label">地址选择</label>
            <div class="col-sm-10">
	      <select name="province">
		@foreach ($region->where("level", 1)->get() as $p)
		  <option value="{{ $p->id }}">{{ $p->fullname }}</option>
		@endforeach
	      </select>
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
  </script>
@endsection

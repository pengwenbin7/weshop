@extends("layouts.admin")

@section("content")

  <div class="box">
    <div class="box-header">
      <h3 class="box-title">订单</h3>
    </div>
    <div class="box-body">
      <div class="dataTables_wrapper form-inline dt-bootstrap">
	<div class="row">
	  <div class="col-sm-6">
	    <div class="dataTables_length">
	      <label>
		每页
		<select name="" class="form-control input-sm">
		  <option value="10">10</option>
		  <option value="25">25</option>
		  <option value="50">50</option>
		  <option value="100">100</option>
		</select>
		条
	      </label>
	      <label>搜索
		<input class="form-control input-sm" type="search">
	      </label>
	    </div>
	  </div>
	</div>
	<div class="row">
	  <div class="col-sm-12">
	    <table class="table table-bordered table-striped dataTable" role="grid">
	      <thead>
	      </thead>
	      <tbody>
		<tr role="row" class="odd">
		  <td class="sorting_1">Gecko</td>
		  <td>Firefox 1.0</td>
		  <td>Win 98+ / OSX.2+</td>
		  <td>1.7</td>
		  <td>A</td>
		</tr>
	      </tbody>
	    </table>
	  </div>
	</div>
	<div class="row">
	</div>
      </div>
    </div>
  </div>

@endsection

@extends("layouts.admin")

@section("content")
  <div class="col-md-6">
    <div class="box box-info">
      <div class="box-header with-border">
	<h3 class="box-title"><a href="{{ route("admin.invoice.index") }}">发票列表</a></h3>
        <h3 class="box-title">编辑</h3>
      </div>
      <form class="form-horizontal" action="{{ route("admin.invoice.update", $invoice) }}" method="POST">
	{{ csrf_field() }}
	<input name="_method" type="hidden" value="PUT"/>
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-2 control-label">状态</label>
            <div class="col-sm-10">
              <select class="form-control" name="status">
		<option value="0"
			@if ($invoice->status == "0")
			selected
			@endif
			>
		  未申请
		</option>
		<option value="1"
			@if ($invoice->status == "1")
			selected
			@endif
			>
		  已申请
		</option>
		<option value="2"
			@if ($invoice->status == "2")
			selected
			@endif
			>
		  已开票
		</option>
		<option value="3"
			@if ($invoice->status == "3")
			selected
			@endif
			>
		  已发出
		</option>
	      </select>
            </div>
          </div>

	  <div class="form-group">
            <label class="col-sm-2 control-label">快递单号</label>
            <div class="col-sm-10">
	      <span class="btn btn-default" v-on:click="scan()">扫一扫</span>
              <input class="form-control" name="ship_no" v-model="ship_no">
            </div>
          </div>

	  <div class="form-group">
            <label class="col-sm-2 control-label">收票人</label>
            <div class="col-sm-10">
              <input class="form-control" value="{{ $invoice->address->contact_name }}"
		      readonly>
            </div>
          </div>

	  <div class="form-group">
            <label class="col-sm-2 control-label">收票地址</label>
            <div class="col-sm-10">
              <input class="form-control" value="{{ $invoice->address->getText() }}"
		      readonly>
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
wx.config({!! app("wechat.work")->jssdk->buildConfig(["scanQRCode"], false) !!});
var app = new Vue({
  el: "#app",
  data: {
    ship_no: "{{ $invoice->ship_no }}"
  },
  methods: {
    scan: function () {
      var _this = this;
      wx.scanQRCode({
	needResult: 1,
	scanType: ["qrCode","barCode"],
	success: function (res) {
	  _this.ship_no = res.resultStr;
	}
      });
    }
  }
});
</script>
@endsection

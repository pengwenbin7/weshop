@extends("layouts.admin")

@section("style")

@endsection

@section("content")
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">系统设置----降价推送</h3>
            </div>
            <form class="form-horizontal" style="height:100%">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">用户分类：</label>
                        <div class="col-sm-4">
                            <select class="form-control select" name="brand_id" id="field">
                                <option value="10086"  {{ $system->setup_id == 10086 ? 'selected':''}}>请选择分组</option>
                                <option value="2" {{ $system->setup_id == 2 ? 'selected':''}}>星标用户</option>
                                <option value="102" {{ $system->setup_id == 102 ? 'selected':''}}>下游客户</option>
                                <option value="107" {{ $system->setup_id == 107 ? 'selected':''}}>供应商</option>
                                <option value="105" {{ $system->setup_id == 105 ? 'selected':''}}>同行及其他</option>
                                <option value="108" {{ $system->setup_id == 108 ? 'selected':''}}>未知可发</option>
                                <option value="109" {{ $system->setup_id == 109 ? 'selected':''}}>调价消息推送</option>
                                <option value="100" {{ $system->setup_id == 100 ? 'selected':''}}>马峰</option>
                            </select>
                        </div>
                        <label class="col-sm-2 control-label">发送状态：</label>
                        <div class="col-sm-4" style="line-height:35px">
                                <label>正常<input name="active" type="radio" onclick="field_cli(1)" value="1" {{ $system->status == 1 ? 'checked':''}}></label>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <label>禁用<input name="active" type="radio" onclick="field_cli(2)" value="2" {{ $system->status == 2 ? 'checked':''}}></label>
                        </div>
                    </div>
            </form>
          </div>
        </div>
    </div>
@endsection
<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/layer/3.1.0/layer.js"></script>
@section("script")
    <script>
        $("#field").change(function(){
            var system_id = $(this).val();//分组id
            var onurl = "{{ route('admin.system.create') }}";
            var data = {system_id:system_id};
            axios.post(onurl,data)
                .then(function (res) {
                    if (res.status == 200) {
                        var p = res.data;
                        if(p.status == 'ok') {
                            return layer.msg("操作成功！");
                        } else {
                            return layer.msg("操作失败，请重试！");
                        }
                    } else {
                       return layer.msg("操作失败，请重试！");
                    }
                })
        });
        function field_cli(obj){
            var onurl = "{{ route('admin.system.create') }}";
            var data = {status:obj};
            axios.post(onurl,data)
                .then(function (res) {
                    if (res.status == 200) {
                        var p = res.data;
                        if (p.status == 'ok') {
                            return layer.msg("操作成功！");
                        } else {
                            return layer.msg("操作失败，请重试！");
                        }
                    } else {
                        return layer.msg("操作失败，请重试！");
                    }
                })
        }
    </script>
@endsection

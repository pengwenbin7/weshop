@extends("layouts.admin")

@section("style")

@endsection

@section("content")
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">系统设置</h3>
            </div>
            <form class="form-horizontal" style="height:100%">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">用户分类：</label>
                        <div class="col-sm-4">
                            <select class="form-control select" name="brand_id">
                                <option value="" selected>请选择分组</option>
                                <option value="" {{ $system->setup_id ? 'selected':''}}>星标用户</option>
                                <option value="" {{ $system->setup_id ? 'selected':''}}>下游客户</option>
                                <option value="" {{ $system->setup_id ? 'selected':''}}>供应商</option>
                                <option value="" {{ $system->setup_id ? 'selected':''}}>同行及其他</option>
                                <option value="" {{ $system->setup_id ? 'selected':''}}>未知可发</option>
                                <option value="" {{ $system->setup_id ? 'selected':''}}>调价消息推送</option>
                                <option value="" {{ $system->setup_id ? 'selected':''}}>马峰</option>
                            </select>
                        </div>
                        <label class="col-sm-2 control-label">发送状态：</label>
                        <div class="col-sm-4" style="line-height:35px">
                                <label>正常<input name="active" type="radio" value="1" {{ $system->checked == 1 ? 'checked':''}}></label>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <label>禁用<input name="active" type="radio" value="2" {{ $system->checked == 2 ? 'checked':''}}></label>
                        </div>
                    </div>


            </form>
                </div>

        </div>
    </div>
@endsection

@section("script")
    <script>

    </script>
@endsection

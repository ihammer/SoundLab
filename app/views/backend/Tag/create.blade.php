@extends('backend.base')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">标签管理</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                新建标签
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form role="form" method="post">
                            <div class="form-group {{{ $errors->has('name') ? 'has-error' : '' }}}">
                                <label>标签：</label>
                                <input class="form-control" name="name" id="name" value=" {{Input::old('name')}}" />
                            </div>
                            <div class="form-group">
                                <label>是否推荐：</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="recommand" id="recommand_on" value="1" {{{ (Input::old('recommand', '0') == '1' ? 'checked' : '') }}}>是
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="recommand" id="recommand_off" value="0" {{{ (Input::old('recommand', '0') == '0' ? 'checked' : '') }}}>否
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-default">提交</button>
                            <button type="reset" class="btn btn-default">重置</button>
                        </form>
                    </div>
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
@stop
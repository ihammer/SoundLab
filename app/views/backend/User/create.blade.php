@extends('backend.base')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">用户管理</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                新建用户
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form role="form" method="post">
                            <div class="form-group {{{ $errors->has('username') ? 'has-error' : '' }}}">
                                <label>用户名：</label>
                                <input class="form-control" name="username" id="username" value="{{Input::old('username')}}" />
                            </div>

                            <div class="form-group {{{ $errors->has('email') ? 'has-error' : '' }}}">
                                <label>邮箱：</label>
                                <input class="form-control" name="email" id="email" value="{{Input::old('email')}}"  />
                                {{ $errors->first('email', '<span class="help-inline">:message</span>') }}
                            </div>

                            <div class="form-group {{{ $errors->has('password') ? 'has-error' : '' }}}">
                                <label>密码</label>
                                <input class="form-control" type="password" name="password" id="password" />
                                {{ $errors->first('password', '<span class="help-inline">:message</span>') }}
                            </div>

                            <div class="form-group">
                                <label>重复密码：</label>
                                <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" />
                            </div>
                            
                            <div class="form-group">
                                <label>是否激活：</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="activated" id="activated_on" value="1" {{{ (Input::old('activated', '1') == '1' ? 'checked' : '') }}}>是
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="activated" id="activated_off" value="0" {{{ (Input::old('activated', '1') == '0' ? 'checked' : '') }}}>否
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
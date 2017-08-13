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
              	用户
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>用户名</th>
                                <th>用户组</th>
                                <th>性别</th>
                                <th>邮箱</th>
                                <th>是否激活</th>
                                <th>最后登陆时间</th>
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($users as $user)
                           <tr>
                               <td> {{ $user->id }} </td>
                               <td> {{{ $user->username }}} </td>
                               <td> Admin </td>
                               <td> unknow </td>
                               <td> {{{ $user->email }}} </td>
                               <td> {{ array_get(['否', '是'], $user->activated)}} </td>
                               <td> {{ $user->last_login }} </td>
                               <td> {{ $user->created_at }} </td>
                               <td>
                                <a href="{{ route('backend.user.edit', $user->id, false)}}">编辑</a> | 
                                <a href="{{ route('backend.user.delete', $user->id, false)}}">删除</a>
                               </td>
                           </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
@stop
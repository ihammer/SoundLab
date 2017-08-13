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
              	用户
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>标签</th>
                                <th>使用次数</th>
                                <th>是否推荐</th>
                                <th>创建者</th>
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($tags as $tag)
                            <tr>
                                <td> {{ $tag->id }} </td>
                                <td> {{{ $tag->name }}} </td>
                                <td> {{ $tag->count }} </td>
                                <td> {{ array_get(['否', '是'], $tag->is_recommand)}} </td>
                                <td> 
                                    @if ($tag->author)
                                        {{{ $tag->author->username }}}
                                    @else
                                        X
                                    @endif
                                </td>
                                <td> {{ $tag->created_at }} </td>
                                <td> <a href="{{ route('backend.tag.edit', $tag->id) }}">编辑</a> |
                                     <a href="{{ route('backend.tag.delete', $tag->id) }}">删除</a>
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
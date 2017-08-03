@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i>  &raquo; <a href="{{url('admin/navs')}}">自定义导航栏管理</a> &raquo; 修改自定义导航栏
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>修改自定义导航栏</h3>
            @if(count($errors)>0)
            @if(is_object($errors))
                @foreach($errors -> all() as $error)
                <div class="mark">
                    <p>{{ $error }}</p>
                </div>
                @endforeach
            @else
                <div class="mark">
                    <p>{{ $errors }}</p>
                </div>
            @endif
        @endif
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{ url('admin/navs/create') }}"><i class="fa fa-plus"></i>修改自定义导航栏</a>
                <a href="{{ url('admin/navs') }}"><i class="fa fa-recycle"></i>全部自定义导航栏</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/navs/'.$field->nav_id)}}" method="post">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>自定义导航栏名称：</th>
                        <td>
                            <input type="text" name="nav_name" value="{{$field->nav_name}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>自定义导航栏名称必须填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>自定义导航栏地址：</th>
                        <td>
                            <input type="text" class="lg" name="nav_url" value="{{$field->nav_url}}">
                        </td>
                    </tr>
                    <tr>
                        <th>自定义导航栏介绍：</th>
                        <td>
                            <input type="text" name="nav_alias" class="sm" value="{{$field->nav_alias}}">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>排序：</th>
                        <td>
                            <input type="text" class="sm" name="nav_order" value="{{$field->nav_order}}">
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>

</body>
@endsection
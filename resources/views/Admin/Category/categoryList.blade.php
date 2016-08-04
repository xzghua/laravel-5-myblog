@extends('Admin.master')

@section('title','分类')

@section('menu','分类')
@section('page','分类列表')

@section('pageName','分类列表')

@section('content')
    <a href="#clear" style="margin-left:10px;" class="pull-left btn btn-info clear-filter" title="clear filter">新增分类</a>

    <table id="responsive-example-table" class="table large-only table-hover " >
        <thead>
        <tr class="text-right">
            <th style="width:14%;">#</th>
            <th style="width:32%;">分类名称</th>
            <th style="width:22%;">创建时间</th>
            <th style="width:10%;">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($category['data'] as $item)
            <tr class="">
                <td>{{$item['id']}}</td>
                <td>{{$item['cate_name']}}</td>
                <td>{{$item['created_at']}}</td>
                <td>
                    <a href="#clear" style="margin-left:10px;" class=" btn btn-info " title="分类修改"><span class="entypo-pencil"></span>&nbsp;&nbsp;修改</a>
                    <a href="#clear" style="margin-left:10px;" class=" btn btn-danger " title="分类删除"> <span class="entypo-trash"></span>&nbsp;&nbsp;删除</a>
                </td>
            </tr>
        @endforeach


        </tbody>
    </table>
    {!! $paginate->render() !!}
@endsection

@section('js')
@endsection
@extends('Admin.master')

@section('title','文章列表')

@section('menu','文章')
@section('page','文章列表')

@section('pageName','文章列表')

@section('content')
    <a href="/article/create" style="margin-left:10px;" class="pull-left btn btn-info clear-filter" title="clear filter">写文章</a>

    <table id="responsive-example-table" class="table large-only table-hover " >
        <thead>
        <tr class="text-right">
            <th style="width:14%;">#</th>
            <th style="width:12%;">title</th>
            <th style="width:12%;">所属分类</th>
            <th style="width:12%;">浏览次数</th>
            <th style="width:12%;">创建时间</th>
            <th style="width:18%;">作者</th>
            <th style="width:20%;">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($article['data'] as $item)
            <tr class="">
                <td>{{$item['id']}}</td>
                <td>{{$item['title']}}</td>
                <td>{{$item['categories']}}</td>
                <td>{{$item['views']}}</td>
                <td>{{$item['created_at']}}</td>
                <td>{{$item['author']}}</td>
                <td>
                    <a href="#clear" style="margin-left:10px;" class=" btn btn-info " title="文章修改"><span class="entypo-pencil"></span>&nbsp;&nbsp;修改</a>
                    <a href="#clear" style="margin-left:10px;" class=" btn btn-danger " title="文章删除"> <span class="entypo-trash"></span>&nbsp;&nbsp;删除</a>
                </td>
            </tr>
        @endforeach


        </tbody>
    </table>
    {!! $paginate->render() !!}
@endsection

@section('js')
    {!! reminder()->message() !!}
@endsection
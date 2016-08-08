@extends('Admin.master')

@section('title','标签列表')

@section('menu','标签')
@section('page','标签列表')

@section('pageName','标签列表')

@section('content')
    <a href="/tag/create" style="margin-left:10px;" class="pull-left btn btn-info" title="新增标签">新增标签</a>

    <table id="responsive-example-table" class="table large-only table-hover " >
        <thead>
        <tr class="text-right">
            <th style="width:14%;">#</th>
            <th style="width:32%;">title</th>
            <th style="width:19%;">引用次数</th>
            <th style="width:16%;">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tag as $item)
            <tr class="">
            <td>{{$item->id}}</td>
            <td>{{$item->tag_name}}</td>
            <td>{{$item->tag_number}}</td>
            <td>
                <form action="/tag/{{$item['id']}}" method="post">
                    <a href="/tag/{{$item['id']}}" style="margin-left:10px;"  class=" btn btn-info " title="标签修改"><span class="entypo-pencil"></span>&nbsp;&nbsp;修改</a>

                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="delete">
                    <button  style="margin-left:10px;" class=" btn btn-danger " title="标签删除"> <span class="entypo-trash"></span>&nbsp;&nbsp;删除</button>
                </form>
            </td>
            </tr>
        @endforeach


        </tbody>
    </table>
        {!! $tag->render() !!}
@endsection

@section('js')
    {!! reminder()->message() !!}
@endsection
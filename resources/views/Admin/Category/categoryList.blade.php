@extends('Admin.master')

@section('title','分类')

@section('menu','分类')
@section('page','分类列表')

@section('pageName','分类列表')

@section('content')
    <a href="{{route('category.create')}}" style="margin-left:10px;" class="pull-left btn btn-info " title="新增分类">新增分类</a>

    <table id="responsive-example-table" class="table large-only table-hover " >
        <thead>
            <tr class="text-right">
                <th style="width:7%;">#</th>
                <th style="width:25%;">分类名称</th>
                <th style="width:22%;">创建时间</th>
                <th style="width:15%;">操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($category as $item)
                <tr class="">
                <td>{{$item['id']}}</td>
                <td>{{$item['newHtml']}}</td>
                <td>{{$item['created_at']}}</td>
                <td>
                    <form action="/category/{{$item['id']}}" method="post">
                        <a href="/category/{{$item['id']}}" style="margin-left:10px;"  class=" btn btn-info " title="分类修改"><span class="entypo-pencil"></span>&nbsp;&nbsp;修改</a>

                        {!! csrf_field() !!}
                        <input type="hidden" name="_method" value="delete">
                        <button  style="margin-left:10px;" class=" btn btn-danger " title="分类删除"> <span class="entypo-trash"></span>&nbsp;&nbsp;删除</button>
                    </form>
                </td>
                </tr>
            @endforeach


        </tbody>
    </table>

@endsection



@section('js')
    {!! reminder()->message() !!}
@endsection

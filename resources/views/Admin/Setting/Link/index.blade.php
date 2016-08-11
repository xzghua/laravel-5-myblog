@extends('Admin.master')

@section('title','友链设置')

@section('menu','系统设置')
@section('page','友链设置')

@section('pageName','友链设置')

@section('content')
    <a href="{{route('link.create')}}" style="margin-left:10px;" class="pull-left btn btn-info " title="新增友链">新增友链</a>

    <table id="responsive-example-table" class="table large-only table-hover " >
        <thead>
        <tr class="text-right">
            <th style="width:7%;">#</th>
            <th style="width:25%;">链接名</th>
            <th style="width:22%;">链接地址</th>
            <th style="width:22%;">排序</th>
            <th style="width:15%;">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($link as $item)
            <tr class="">
                <td>{{$item['id']}}</td>
                <td>{{$item['name']}}</td>
                <td>{{$item['link']}}</td>
                <td>{{$item['ordering']}}</td>
                <td>
                    <form action="/link/{{$item['id']}}" method="post">
                        <a href="/link/{{$item['id']}}" style="margin-left:10px;"  class=" btn btn-info " title="友链修改"><span class="entypo-pencil"></span>&nbsp;&nbsp;修改</a>

                        {!! csrf_field() !!}
                        <input type="hidden" name="_method" value="delete">
                        <button  style="margin-left:10px;" class=" btn btn-danger " title="友链删除"> <span class="entypo-trash"></span>&nbsp;&nbsp;删除</button>
                    </form>
                </td>
            </tr>
        @endforeach


        </tbody>
    </table>
    {!! $link->render() !!}
@endsection



@section('js')
    {!! reminder()->message() !!}
@endsection

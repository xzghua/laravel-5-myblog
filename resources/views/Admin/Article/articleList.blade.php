@extends('Admin.master')

@section('title','文章列表')

@section('menu','文章')
@section('page','文章列表')

@section('pageName','文章列表')

@section('content')
    <a href="#clear" style="margin-left:10px;" class="pull-left btn btn-info clear-filter" title="clear filter">写文章</a>

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

        <tr class="">
            <td>1</td>
            <td>3.375%</td>
            <td>$123.12</td>
            <td>1.125</td>
            <td>4,000</td>
            <td>Potato</td>
            <td>
                <a href="#clear" style="margin-left:10px;" class=" btn btn-info clear-filter" title="clear filter">修改</a>
                <a href="#clear" style="margin-left:10px;" class=" btn btn-danger clear-filter" title="clear filter">删除</a>
            </td>
        </tr>
        <tr>
            <td>2</td>
            <td>2.750%</td>
            <td>$345.23</td>
            <td>5</td>
            <td>180</td>
            <td>Spaceship</td>
            <td>Skippy</td>
        </tr>

        </tbody>
    </table>

@endsection

@section('js')
@endsection
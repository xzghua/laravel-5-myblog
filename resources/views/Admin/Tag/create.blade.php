@extends('Admin.master')

@section('title','新建标签')

@section('css')
    <link href="/Admin/assets/js/validate/validate.css" rel="stylesheet">

@endsection

@section('menu','标签')
@section('page','新建标签')

@section('pageName','新建标签')

@section('content')
    <div class="body-nest" id="element">
        <div class="panel-body">
            <form action="/tag" method="post" class="form-horizontal bucket-form tagForm">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="tagName">新建标签</label>
                    <div class="col-sm-6">
                        <input type="text" id="tagName" name="tagName"  class="form-control tagName">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"></label>
                    <div class="col-sm-6">
                        <button class="btn" type="submit">
                            <span class="fontawesome-save"></span>&nbsp;&nbsp;保存</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="/Admin/assets/js/validate/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/Admin/admin.create.js"></script>
    {!! reminder()->message() !!}
@endsection
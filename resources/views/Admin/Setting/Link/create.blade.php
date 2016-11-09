@extends('Admin.master')

@section('title','新增友链')

@section('css')
    <link href="/Admin/assets/js/validate/validate.css" rel="stylesheet">
@endsection

@section('menu','系统设置')
@section('page','新增友链')

@section('pageName','新增友链')

@section('content')
    <div class="body-nest" id="element">

        <div class="panel-body">
            <form method="post" action="/link" class="form-horizontal bucket-form linkForm">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="linkName">友链名称</label>
                    <div class="col-sm-6">
                        <input type="text" id="linkName" name="name"  class="form-control linkName">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">友链链接</label>
                    <div class="col-sm-6">
                        <input type="text" id="link" name="link" class="form-control round-input link">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">顺序</label>
                    <div class="col-sm-6">
                        <input type="text" id="ordering" name="ordering" class="form-control ordering">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"></label>
                    <div class="col-sm-6">
                        <button class="btn" type="submit">
                            <span class="fontawesome-save"></span>&nbsp;&nbsp;创建</button>
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

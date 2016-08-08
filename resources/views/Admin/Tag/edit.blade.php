@extends('Admin.master')

@section('title','修改标签')

@section('css')
    <link href="/Admin/assets/js/validate/validate.css" rel="stylesheet">

@endsection

@section('menu','标签')
@section('page','修改标签')

@section('pageName','修改标签')

@section('content')
    <div class="body-nest" id="element">
        <div class="panel-body">
            <form action="/tag/{{$tag->id}}" method="post" class="form-horizontal bucket-form tagForm">
                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="put">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="tagName">修改标签</label>
                    <div class="col-sm-6">
                        <input type="text" id="tagName" name="tagName" value="{{$tag->tag_name}}"  class="form-control tagName">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"></label>
                    <div class="col-sm-6">
                        <button class="btn" type="submit">
                            <span class="fontawesome-save"></span>&nbsp;&nbsp;修改</button>
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
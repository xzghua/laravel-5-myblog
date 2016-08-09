@extends('Admin.master')

@section('title','写文章')

@section('css')
    <link href="/Admin/assets/js/validate/validate.css" rel="stylesheet">
    <link href="/Admin/editor/css/bootstrap-markdown.min.css" rel="stylesheet">
@endsection

@section('menu','文章管理')
@section('page','写文章')

@section('pageName','写文章')

@section('content')
    <div class="body-nest" id="element">

        <div class="panel-body">
            <form method="post" action="/category" class="form-horizontal bucket-form createForm">
                {!! csrf_field() !!}

                <div class="form-group">
                    <label class="col-sm-3 control-label">标题</label>
                    <div class="col-sm-6">
                        <input type="text" name="cateName"  class="form-control cateName">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">分类</label>
                    <div class="col-sm-6">
                        <select id="category" name="parentId" class="form-control parentId">
                            @foreach($category as $item)
                                <option value="{{$item['id']}}"> {{$item['newHtml']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">标签</label>
                    <div class="col-sm-6">
                        <input type="text" name="asName" class="form-control round-input asName">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">文章内容</label>
                    <div class="col-sm-6">
                        {{--<textarea id="text" name="seoDesc" style="height:200px!important;margin:20px 0;resize:none" class="form-control seoDesc" rows="8"></textarea>--}}
                        <textarea name="content" data-provide="markdown" class="form-control seoDesc" rows="10"></textarea>

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
    <script type="text/javascript" src="/Admin/editor/js/bootstrap-markdown.js"></script>
    <script type="text/javascript" src="/Admin/admin.create.js"></script>

@endsection

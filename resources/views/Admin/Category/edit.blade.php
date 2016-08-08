@extends('Admin.master')

@section('title','修改分类')

@section('css')
    <link href="/Admin/assets/js/validate/validate.css" rel="stylesheet">
@endsection

@section('menu','分类管理')
@section('page','修改分类')

@section('pageName','修改分类')

@section('content')
    <div class="body-nest" id="element">

        <div class="panel-body">
            <form method="POST" action="/category/{{$cate['id']}}" class="form-horizontal bucket-form createForm">
                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="put">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="category">上级分类</label>
                    <div class="col-sm-6">
                        <select id="category" name="parentId" class="form-control parentId">
                            @foreach($category as $item)
                                <option value="{{$item['id']}}" @if ($cate['parent_id'] == $item['id']) selected @endif> {{$item['newHtml']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="cateName">分类名称</label>
                    <div class="col-sm-6">
                        <input type="text" id="cateName" name="cateName" value="{{$cate['cate_name']}}" class="form-control cateName">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="asName">分类别名</label>
                    <div class="col-sm-6">
                        <input type="text" id="asName" name="asName" value="{{$cate['as_name']}}" class="form-control round-input asName">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="seoTitle">seo标题</label>
                    <div class="col-sm-6">
                        <input type="text" id="seoTitle" name="seoTitle" value="{{$cate['seo_title']}}" class="form-control seoTitle">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="seoName">seo关键字</label>
                    <div class="col-sm-6">
                        <input type="text" id="seoName" name="seoName" value="{{$cate['seo_name']}}" class="form-control seoName">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="text">seo描述</label>
                    <div class="col-sm-6">
                        <textarea id="text" name="seoDesc"  style="height:200px!important;margin:20px 0;resize:none" class="form-control seoDesc" rows="8">{{$cate['seo_desc']}}</textarea>

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

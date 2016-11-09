@extends('Admin.master')

@section('title','首页设置')

@section('menu','系统设置')
@section('page','首页设置')

@section('pageName','首页设置')

@section('content')
    <div class="body-nest" id="element">

        <div class="panel-body">
            <form method="post" action="/seo" class="form-horizontal bucket-form createForm">
                {!! csrf_field() !!}

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="title1">首页标题</label>
                    <div class="col-sm-6">
                        <input type="text" id="title1" name="title" @if (!empty($seo)) value="{{$seo['title']}}" @endif  class="form-control title1">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="theme">主题文件名</label>
                    <div class="col-sm-6">
                        <input type="text" id="theme"  name="theme" @if (!empty($seo)) value="{{$seo['theme']}}" @endif class="form-control round-input s_title">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="s_title">副标题</label>
                    <div class="col-sm-6">
                        <input type="text" id="s_title"  name="s_title" @if (!empty($seo)) value="{{$seo['s_title']}}" @endif class="form-control round-input s_title">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="description">描述</label>
                    <div class="col-sm-6">
                        <input type="text" id="description" name="description" @if (!empty($seo)) value="{{$seo['description']}}" @endif class="form-control description">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="seo_key">seo关键词</label>
                    <div class="col-sm-6">
                        <input type="text" id="seo_key" name="seo_key" @if (!empty($seo)) value="{{$seo['seo_key']}}" @endif class="form-control seo_key">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="seo_des">seo描述</label>
                    <div class="col-sm-6">
                        <input type="text" id="seo_des" name="seo_des" @if (!empty($seo)) value="{{$seo['seo_des']}}" @endif class="form-control seo_des">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="record_number">备案号</label>
                    <div class="col-sm-6">
                        <input type="text" id="record_number" name="record_number" @if (!empty($seo)) value="{{$seo['record_number']}}" @endif class="form-control record_number">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label"></label>
                    <div class="col-sm-6">
                        <button class="btn" type="submit">
                            <span class="fontawesome-save"></span>&nbsp;&nbsp; 保存</button>
                    </div>
                </div>

            </form>
        </div>

    </div>

@endsection



@section('js')
    {!! reminder()->message() !!}
@endsection

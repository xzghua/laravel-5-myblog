@extends('Admin.master')

@section('title','后台首页')

@section('menu','后台首页')
@section('page','后台首页')

@section('pageName','首页')

@section('content')
<div class="row">


        <div class="col-sm-4">
            <ul class="list-group">
                <li class="list-group-item text-left">
                    <span class="entypo-user"></span>&nbsp;&nbsp;{{\Illuminate\Support\Facades\Auth::user()->name}}</li>
                <li class="list-group-item text-center">
                    <img src="Admin/assets/img/logo.png" alt="" style="width: 20%;height: 20%" class="img-circle img-responsive img-profile">

                </li>
                <li class="list-group-item text-right">
                    <span class="pull-left">
                        <strong>邮箱</strong>
                    </span>
                    {{\Illuminate\Support\Facades\Auth::user()->email}}
                </li>

                <li class="list-group-item text-right">
                    <span class="pull-left">
                        <strong>域名</strong>
                    </span>
                    {{$_SERVER['SERVER_NAME']}}
                </li>
                <li class="list-group-item text-right">
                    <span class="pull-left">
                        <strong>服务器的IP地址</strong>
                    </span>{{$_SERVER['SERVER_ADDR']}}</li>
                <li class="list-group-item text-right">
                    <span class="pull-left">
                        <strong>当前IP地址</strong>
                    </span>{{$_SERVER['REMOTE_ADDR']}}</li>
                <li class="list-group-item text-right">
                    <span class="pull-left">
                    <strong>浏览器</strong>
                    </span>{{$_SERVER['HTTP_USER_AGENT'] }}</li>
                <li class="list-group-item text-right">
                    <span class="pull-left">
                    <strong>服务器语言</strong>
                    </span>{{getenv("HTTP_ACCEPT_LANGUAGE") }}
                </li><li class="list-group-item text-right">
                    <span class="pull-left">
                    <strong>服务器端口</strong>
                    </span>{{ $_SERVER['SERVER_PORT'] }}</li>
                <li class="list-group-item text-right">
                    <span class="pull-left">
                    <strong>服务器操作系统</strong>
                    </span><?php $os = explode(" ", php_uname()); echo $os[0];?></li>
                <li class="list-group-item text-right">
                    <span class="pull-left">
                    <strong>内核版本</strong>
                    </span><?php if('/'==DIRECTORY_SEPARATOR){echo $os[2];}else{echo $os[1];} ?>
                </li>

            </ul>

        </div>
        <div class="col-sm-6">

            <div class="nest" id="headerClose">
                <div class="title-alt">
                    最近访客
                </div>
                <div class="body-nest" id="header">
                    <ul class="ds-recent-visitors" data-num-items="10000" ></ul>
                    <!--多说js加载开始，一个页面只需要加载一次 -->
                    <script type="text/javascript">
                        var duoshuoQuery = {short_name:
                            <?php
                            if ($_SERVER['SERVER_NAME'] == 'www.iphpt.com') {
                                echo "'iphptBlog'";
                            } else {
                                echo '"iphpt"';
                            }

                            ?>

                        };
                        (function() {
                            var ds = document.createElement('script');
                            ds.type = 'text/javascript';ds.async = true;
                            ds.src = 'https://static.duoshuo.com/embed.js';
                            ds.charset = 'UTF-8';
                            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(ds);
                        })();
                    </script>
                    <!--多说js加载结束，一个页面只需要加载一次 -->
                </div>

            </div>

        </div>
</div>
    @endsection

@section('js')
    @endsection
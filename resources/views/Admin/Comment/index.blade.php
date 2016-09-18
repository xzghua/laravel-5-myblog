@extends('Admin.master')

@section('title','评论')

@section('menu','评论')
@section('page','评论列表')

@section('pageName','评论列表')

@section('content')


    <ul class="ds-recent-comments" data-num-items="200" data-show-avatars="1" data-show-time="1" data-show-admin="1" data-excerpt-length="70"></ul>
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
            ds.src = 'http://static.duoshuo.com/embed.js';
            ds.charset = 'UTF-8';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(ds);
        })();
    </script>
    <!--多说js加载结束，一个页面只需要加载一次 -->
@endsection



@section('js')

@endsection

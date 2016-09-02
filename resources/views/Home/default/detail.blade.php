@extends('Home.default.master')
@section('title',$article['title'])
@section('css')
    <link rel="stylesheet" href="/Home/default/js/highlight/styles/atom-one-dark.css">
    <link rel="stylesheet" href="/Home/default/css/share.min.css">
@endsection

@section('content')
    <section id="intro">
        <div class="container">
            <div class="row col-md-offset-2">
                <div class="col-md-8">
    			<span class="post-meta">
      <time datetime="{{$article['created_at']}}" itemprop="datePublished">
          {{$article['created_at']}}
      </time>
    |<i class="icon-tag"> </i>
    @foreach( $article['get_tags'] as $item)
        <a href='/tags/{{$item['tag_name']}}/' > {{$item['tag_name']}}</a>,
    @endforeach

</span>
                    <h1>{{$article['title']}}</h1>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-2">
                {!! $article['content'] !!}


                <div class="clearfix"></div>
                <hr class="nogutter">
                <span style="color: #19A1F9">欢迎转载,但请附上原文地址哦,尊重原创,谢谢大家 本文地址: <a style="color: #19A1F9" href="/detail/{{$article['id']}}/">http://www.iphpt.com/detail/{{$article['id']}}/</a></span>
                <hr class="nogutter">
            </div>
            <nav class="pagination" role="pagination">
                @if (!empty($last))
                    <a class="pull-left" href="/detail/{{$last->id}}/" style="float: left;">
                        ← {{$last->title}}
                    </a>
                @endif
                @if (!empty($next))
                    <a class="pull-right" href="/detail/{{$next->id}}/">
                        {{$next->title}} →
                    </a>
                @endif

            </nav>


        </div>
    </section>

    <div class="duoshuo " style="text-align: center">

        <div class="share-component" data-disabled="twitter,facebook" data-mobile-sites="weibo,qq,qzone,tencent"></div>


        <!-- 多说评论框 start -->
        <div class="ds-thread" data-thread-key="{{$article['id']}}" data-title="{{$article['title']}}" data-url="{{$_SERVER['SERVER_NAME']}}/detail/{{$article['id']}}"></div>
    </div>
        <!-- 多说评论框 end -->
        <!-- 多说公共JS代码 start (一个网页只需插入一次) -->
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
                ds.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//static.duoshuo.com/embed.js';
                ds.charset = 'UTF-8';
                (document.getElementsByTagName('head')[0]
                || document.getElementsByTagName('body')[0]).appendChild(ds);
            })();
        </script>
        <!-- 多说公共JS代码 end -->

    </div>
@endsection

@section('js')
    <script src="/Home/default/js/highlight/highlight.pack.js"></script>
    <script src="/Home/default/js/jquery.share.min.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>

@endsection
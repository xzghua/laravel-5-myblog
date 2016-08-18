@extends('Home.default.master')

@section('css')

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
    <div class="duoshuo">

            <div class="ds-share flat" data-thread-key="{{$article['id']}}" data-title="{{$article['title']}}" data-images="{{$_SERVER['SERVER_NAME']}}/detail/{{$article['id']}}" data-content="{{$article['content']}}" data-url="{{$_SERVER['SERVER_NAME']}}/detail/{{$article['id']}}">

            <div class="ds-share-inline">
                <ul  class="ds-share-icons-16">

                    <li data-toggle="ds-share-icons-more"><a class="ds-more" href="javascript:void(0);">分享到：</a></li>
                    <li><a class="ds-weibo" href="javascript:void(0);" data-service="weibo">微博</a></li>
                    <li><a class="ds-qzone" href="javascript:void(0);" data-service="qzone">QQ空间</a></li>
                    <li><a class="ds-qqt" href="javascript:void(0);" data-service="qqt">腾讯微博</a></li>
                    <li><a class="ds-wechat" href="javascript:void(0);" data-service="wechat">微信</a></li>

                </ul>
                <div class="ds-share-icons-more">
                </div>
            </div>
        </div>

        <!-- 多说评论框 start -->
        <div class="ds-thread" data-thread-key="{{$article['id']}}" data-title="{{$article['title']}}" data-url="{{$_SERVER['SERVER_NAME']}}/detail/{{$article['id']}}"></div>

        <!-- 多说评论框 end -->
        <!-- 多说公共JS代码 start (一个网页只需插入一次) -->
        <script type="text/javascript">
            var duoshuoQuery = {short_name:"iphptblog"};
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

@endsection
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
    |
    @foreach( $article['get_tags'] as $item)
        <a href='/tags/{{$item['tag_name']}}/'>{{$item['tag_name']}}</a>,
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
        <!-- 多说评论框 start -->
        <div class="ds-thread" data-thread-key="{{$article['id']}}" data-title="{{$article['title']}}" data-url="/detail/{{$article['id']}}"></div>
        <!-- 多说评论框 end -->
        <!-- 多说公共JS代码 start (一个网页只需插入一次) -->
        <script type="text/javascript">
            var duoshuoQuery = {short_name:"iphpt"};
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
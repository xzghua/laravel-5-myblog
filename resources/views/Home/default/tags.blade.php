@extends('Home.default.master')
@section('title',$artList->tag_name.' --  tags '."&nbsp;&nbsp;-&nbsp;&nbsp;")
@section('content')
    <!-- ============================ Hero Image =========================== -->
    {{--顶部大图--}}
    <section id="hero" class="scrollme">
        <div class="container-fluid element-img" style="background: url(http://static.iphpt.com/tags.jpg) no-repeat center center fixed;background-size: cover">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2 vertical-align cover boost text-center">
                    <div class="center-me animateme" data-when="exit" data-from="0" data-to="0.6" data-opacity="0" data-translatey="100">
                        <div>

                            <h2>
                                <a href="#services" class="more scrolly">
                                    命定的局限尽可永在，不屈的挑战却不可须臾或缺！
                                </a>
                            </h2>
                            <p></p>

                            <h2></h2>
                            <p></p>


                        </div>
                    </div>
                </div>
                <!-- // .col-md-12 -->
            </div>
            <div class="herofade beige-dk"></div>
        </div>
    </section>

    <!-- Height spacing helper -->
    <div class="heightblock"></div>
    <!-- // End height spacing helper -->
    <section id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
{{--                    {{dd($artList->toArray()['get_article'])}}--}}
                    <div class="row boxes">
                        @if (!empty($artList->toArray()['get_tags']))

                            @foreach( $artList->toArray()['get_tags'] as $key => $item)

                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 wow fadeInUp" data-wow-delay="0.3s">

                                    <h4 class="title"><a href="/detail/{{$item['id']}}/">{{$item['title']}}</a></h4>

                                    <p><time datetime="{{$item['created_at']}}"><a href="/detail/{{$item['id']}}/">{{$item['created_at']}}</a></time></p>
                                </div>
                                @if (($key + 1)%4 == 0)
                                    </div><div class="row boxes">

                                @endif
                            @endforeach
                        @endif

                    </div>


                </div>
            </div>
        </div>
    </section>

@endsection
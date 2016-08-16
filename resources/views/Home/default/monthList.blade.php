@extends('Home.default.master')

@section('content')


    <section id="intro">
        <div class="container">
            <div class="row col-md-offset-2">
                <div class="col-md-8" style="text-align: center">


                </div>
            </div>
            <div class="col-md-8 col-md-offset-2" style="text-align: center;min-height: 600px">
                <h1>归档</h1>
                <hr class="nogutter" style="margin: 1px">

                @foreach($article as $k => $item)

                    <h2> {{$k}} </h2>
                    <hr class="nogutter" style="margin-top: 5px;margin-bottom: 5px">

                    @foreach($item as $value)
                       <span > <a href="/detail/{{$value['id']}}" >{{$value['title']}}</a></span>
                        <hr  style="margin-top: 5px;margin-bottom: 5px">

                    @endforeach
                    <hr class="nogutter" style="margin: 1px">
                @endforeach
                <div class="clearfix"></div>
                <hr class="nogutter" >

            </div>



        </div>
    </section>

    {{--<form action="" class="form-control">--}}
    {{--<table class="hover table-center">--}}
        {{--<thead>--}}
        {{--<th></th>--}}
        {{--</thead>--}}
        {{--<tbody>--}}
        {{--@foreach($article as $item)--}}

            {{--@foreach($item as $value)--}}
                {{--<tr>--}}
                    {{--<td><a href="/detail/{{$value['id']}}">{{$value['title']}}</a></td>--}}
                {{--</tr>--}}
            {{--@endforeach--}}
        {{--@endforeach--}}
        {{--</tbody>--}}
    {{--</table>--}}
    {{--</form>--}}
@endsection
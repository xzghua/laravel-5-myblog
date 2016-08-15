<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>叶落山城秋</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <script type="text/javascript" src="Admin/assets/js/jquery.min.js"></script>

    <!--  <link rel="stylesheet" href="assets/css/style.css"> -->
    <link rel="stylesheet" href="Admin/assets/css/loader-style.css">
    <link rel="stylesheet" href="Admin/assets/css/bootstrap.css">
    <link rel="stylesheet" href="Admin/assets/css/signin.css">






    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="Admin/assets/ico/minus.png">
</head>

<body>
<!-- Preloader -->
<div id="preloader">
    <div id="status">&nbsp;</div>
</div>

<div class="container">



    <div class="" id="login-wrapper">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div id="logo-login">
                    <h1>叶落山城秋
                        <span>v1.3</span>
                    </h1>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="account-box">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">用户名</label>

                            <div class="col-md-9">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">邮箱</label>

                            <div class="col-md-9">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">密码</label>

                            <div class="col-md-9">
                                <input type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">确认密码</label>

                            <div class="col-md-9">
                                <input type="password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i>Register
                                </button>
                            </div>
                        </div>
                    </form>
                    <a class="forgotLnk" href=""></a>
                    <div class="or-box">
                        <center><span class="text-center login-with"><a href="/auth/login"><b> Login</b></a> or Sign Up</span></center>
                    </div>
                        {{--<div class="or-box">--}}

                        {{--<center><span class="text-center login-with"><a href="/auth/login"><b> Login</b></a> or Sign Up</span></center>--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-md-6 row-block">--}}
                                {{--<a href="#" class="btn btn-facebook btn-block">--}}
                                    {{--<span class="entypo-facebook space-icon"></span>Facebook</a>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-6 row-block">--}}
                                {{--<a href="#" class="btn btn-twitter btn-block">--}}
                                    {{--<span class="entypo-twitter space-icon"></span>Twitter</a>--}}

                            {{--</div>--}}

                        {{--</div>--}}
                        {{--<div style="margin-top:25px" class="row">--}}
                            {{--<div class="col-md-6 row-block">--}}
                                {{--<a href="#" class="btn btn-google btn-block"><span class="entypo-gplus space-icon"></span>Google +</a>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-6 row-block">--}}
                                {{--<a href="#" class="btn btn-instagram btn-block"><span class="entypo-instagrem space-icon"></span>Instagram</a>--}}
                            {{--</div>--}}

                        {{--</div>--}}
                    {{--</div>--}}
                    <hr>

                    <div class="row-block">
                        <div class="row">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <p>&nbsp;</p>
    <div style="text-align:center;margin:0 auto;">
        <h6 style="color:#fff;">Copyright(C)2014 ylsc633.com All Rights Reserved<br />
            叶落山城秋</h6>
    </div>

</div>
<div id="test1" class="gmap3"></div>



<!--  END OF PAPER WRAP -->




<!-- MAIN EFFECT -->
<script type="text/javascript" src="Admin/assets/js/preloader.js"></script>
<script type="text/javascript" src="Admin/assets/js/bootstrap.js"></script>
<script type="text/javascript" src="Admin/assets/js/app.js"></script>
<script type="text/javascript" src="Admin/assets/js/load.js"></script>
<script type="text/javascript" src="Admin/assets/js/main.js"></script>


<script type="text/javascript">

</script>




</body>

</html>

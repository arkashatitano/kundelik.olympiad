<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon.png?v=1">
    <title>Kundelik</title>

    <link href="/admin/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/admin/css/style.css" rel="stylesheet">
    <link href="/admin/css/colors/blue.css" id="theme" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<section id="wrapper">
    <div class="login-register" style="background-image:url(/admin/img/bg.jpg);">
        <div class="login-box card">
            <div class="card-body" style="padding: 20px">
                <form class="form-horizontal form-material" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <h3 class="box-title m-b-20">Вход</h3>
                    <p style="color:red">@if(isset($error)){{$error}}@endif</p>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="" placeholder="Логин" name="login" value="@if(isset($login)){{$login}}@endif">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" required="" placeholder="Пароль" name="password">
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Войти</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script src="/admin/assets/plugins/jquery/jquery.min.js"></script>
<script src="/admin/assets/plugins/popper/popper.min.js"></script>
<script src="/admin/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="/admin/js/jquery.slimscroll.js"></script>
<script src="/admin/js/waves.js"></script>
<script src="/admin/js/sidebarmenu.js"></script>
<script src="/admin/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
<script src="/admin/assets/plugins/sparkline/jquery.sparkline.min.js"></script>
<script src="/admin/js/custom.min.js"></script>
<script src="/admin/assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>

</body>

</html>

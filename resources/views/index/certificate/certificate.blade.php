<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        *{ font-family: DejaVu Sans !important;
        }
        html { margin: 0px}
        body {
            margin: 0px;
            padding: 0px;
            background: url("{{'img/certificate.png'}}") no-repeat center/contain;
            background-size: 100% 100%;
            margin-left: -3px;
        }
        /*.sertificate {
            width: 100%;
            height: 100%;
            margin-left: 8px;
        }*/
        .sertificate h1 {
            font-size: 65px;
            /*margin-left: 350px;*/
            text-align: center;
            color: #11355a;
            text-transform: uppercase;
            margin: 0px auto !important;
        }
        .sertificate .second-label {
            font-size: 23px;
            color: #11355a;
            text-align: center;
            text-transform: inherit;
            margin-top: 0px;
        }
        .sertificate .user-name {
            font-size: 35px;
            color: #11355a;
            text-align: center;
            text-transform: inherit;
            margin-top: 0px;
        }
        .sertificate h4 {
            font-size: 20px;
            color: #11355a;
            text-align: center;
            margin-top: 100px;
        }
        .sertificate p{
            font-size: 25px;
            line-height: 25px;
            color: black;
            text-align: center;
            padding: 0 10px;
        }
        .main-label {
            position: absolute;
            top: 130px;
            height: 800px;
        }
    </style>
</head>
<body>

<div class="content-docs">
    <div class="clearfix row">
        <div class="col-md-12">
            <div class="sertificate">
                <div class="main-label">
                    <h1>Сертификат</h1>
                </div>
                <div style="position: absolute; top: 215px">
                    <h2 class="second-label">Тіркеу № <span>{{$row->certificate_name}}</span></h2>
                </div>
                <div style="position: absolute; top: 280px">
                    <h2 class="user-name">@if($certificate->user_name != ''){{$certificate->user_name}}@else{{$row->name}}@endif</h2>
                </div>
                <div style="position: absolute; top: 400px">
                    <div style="width: 70%; margin: auto;">
                        {!! $row->certificate_text !!}
                    </div>
                </div>
                <div>
                    <img src="{{url('img/certificate.png')}}">
                    <img src="/img/certificate.png">
                    <img src="img/certificate.png">
                    <img src="{{ public_path("/img/certificate.png") }}">
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

</body>
</html>

<style>
    .content-docs {
        margin: 0px;
        background-color: #fff;
        position: relative; }

    .clearfix {
        clear: both; }

    .text-top {
        float: right;
        text-align: right; }
    .text-top span {
        display: block; }

    .text-center {
        text-align: center; }

    .text-right {
        text-align: right; }

    .min-50 {
        width: 50%; }

    .line-box {
        font-weight: 600;
        border-bottom: 1px solid #000;
        height: 20px;
    }
    .col-md-6 {
        width: 50%;
        float: left; }

    .row {
        margin: 0 -15px; }

    p {
        margin-top: 0; }


</style>

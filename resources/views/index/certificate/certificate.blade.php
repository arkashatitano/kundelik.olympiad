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
            background: url("{{'img/gold.png'}}") no-repeat center/contain;
            background-size: 100% 100%;
            margin-left: -3px;
        }
        .main-label {
            position: absolute;
            top: 130px;
            height: 800px;
        }
        .sertificate-olympiad-name {
            width: 410px;
            margin: auto;
            text-align: center;
            top: 318px;
            position: absolute;
            left: 200px;
        }
        .sertificate-olympiad-name h4 {
            font-size: 25px;
            color: #CCA352;
            line-height: 25px;
            font-weight: normal;
            text-transform: uppercase;
        }
        .sertificate-user-name {
            width: 410px;
            margin: auto;
            text-align: center;
            top: 380px;
            position: absolute;
            left: 200px;
        }
        .sertificate-user-name h3 {
            font-size: 25px;
            color: white;
            line-height: 25px;
        }
        .sertificate-text {
            width: 400px;
            margin: auto;
            text-align: center;
            top: 510px;
            position: absolute;
            left: 205px;
        }
        .sertificate-text p {
            font-size: 14px;
            color: white;
        }
        .sertificate-date {
            width: 400px;
            margin: auto;
            text-align: center;
            top: 970px;
            position: absolute;
            left: 205px;
        }
        .sertificate-date b {
            font-size: 14px;
            margin-bottom: 0px;
        }
        .sertificate-date p {
            font-size: 14px;
            margin-top: 0px;
        }
    </style>
</head>
<body>

<div class="content-docs">
    <div class="clearfix row">
        <div class="col-md-12">
            <div class="sertificate">
                <div class="sertificate-olympiad-name">
                    <h4>{{$row->info->olympiad_test_name_ru}}</h4>
                </div>
                <div class="sertificate-user-name">
                    <h3>{{$row->user_name}}</h3>
                </div>
                <div class="sertificate-text">
                    <p>{!! $row->info->certificate_text_1 !!}</p>
                </div>
                <div class="sertificate-date" style="top: 870px; left: 165px; text-align: left; width: 200px">
                    <p style="line-height: 15px">
                        Директор "Күнделік"
                        Болатбек Болатбеков
                    </p>
                </div>
                <div class="sertificate-date" style="top: 870px; left: 433px; text-align: right; width: 200px">
                    <p style="line-height: 15px">
                        Директор <br/>
                        Абай Абаевич
                    </p>
                </div>
                <div class="sertificate-date">
                    <p>Дата выдачи</p>
                </div>
                <div class="sertificate-date" style="top: 990px">
                    <b>{{\App\Http\Helpers::getDateFormat2($row->info->date)}}</b>
                </div>
                <div class="sertificate-date" style="top: 1060px">
                    <p style="font-size: 17px">{{date('Y')}}</p>
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

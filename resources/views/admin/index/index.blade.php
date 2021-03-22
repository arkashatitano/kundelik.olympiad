@extends('admin.layout.layout')

@section('content')


    <div class="container-fluid">

        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Статистика</h3>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-block">
                        <h4 class="card-title">Cегодня</h4>
                        <div class="text-right">
                            <h2 class="font-light m-b-0"><i class="ti-arrow-up text-success"></i> {{$statistic['user_count_today']}}</h2>
                            <span class="text-muted">Пользователи</span>
                        </div>
                        <span class="text-success">100%</span>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-block">
                        <h4 class="card-title">Пользователи</h4>
                        <div class="text-right">
                            <h2 class="font-light m-b-0"><i class="ti-arrow-up text-info"></i> {{$statistic['user_count_all']}}</h2>
                            <span class="text-muted">Пользователи</span>
                        </div>
                        <span class="text-info">100%</span>
                        <div class="progress">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-block">
                        <h4 class="card-title">Подписки на сегодня</h4>
                        <div class="text-right">
                            <h2 class="font-light m-b-0"><i class="ti-arrow-up text-purple"></i> {{$statistic['subscription_count_today']}}</h2>
                            <span class="text-muted">Подписки</span>
                        </div>
                        <span class="text-purple">100%</span>
                        <div class="progress">
                            <div class="progress-bar bg-purple" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-block">
                        <h4 class="card-title">Подписки</h4>
                        <div class="text-right">
                            <h2 class="font-light m-b-0"><i class="ti-arrow-up text-danger"></i> {{$statistic['subscription_count_all']}}</h2>
                            <span class="text-muted">Подписки</span>
                        </div>
                        <span class="text-danger">100%</span>
                        <div class="progress">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">График</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <form id="date_form">
                    <ul class="nav nav-tabs" style="margin-bottom: 35px">
                        <li>
                            <div class="input-group input-group-statistics">

                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="hidden-xs">Период</span> <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu statistic-type" style="padding: 10px">
                                        <li class="@if(isset($_GET['type']) && $_GET['type'] == 'week') active @endif">
                                            <a href="/admin/index?day=7{{''}}@if(isset($_GET['is_author']) && $_GET['is_author']){{'&is_author='.$_GET['is_author']}}@endif">За последние 7 дней</a>
                                        </li>
                                        <li class="@if(isset($_GET['type']) && $_GET['type'] == 'month') active @endif">
                                            <a href="/admin/index?day=14{{''}}@if(isset($_GET['is_author']) && $_GET['is_author']){{'&is_author='.$_GET['is_author']}}@endif">За последние 14 дней</a>
                                        </li>
                                    </ul>
                                </div>

                                <input type="hidden" name="type" value="@if(isset($_GET['type'])){{$_GET['type']}}@endif"/>

                                <input type="text" class="form-control mydatepicker" id="input_start_time" name="date_from" value="{{$request->date_from}}">
                                <span class="input-group-addon" id="basic-addon1">-</span>
                                <input type="text" class="form-control mydatepicker" id="input_end_time" name="date_to" value="{{$request->date_to}}">
                                                    <span class="input-group-btn">
                                                        <button type="button" id="button_statistics" class="btn btn-default"  onclick="$('#date_form').submit()">Поиск</button>
                                                    </span>
                            </div>
                        </li>
                    </ul>
                </form>
            </div>

            <div class="col-12">
                <ul class="list-inline pull-right">
                    <li>
                        <h6 class="text-muted"><i class="fa fa-circle m-r-5 text-success" style="color: #1897EA !important;"></i>Новый пользователи</h6>
                    </li>
                </ul>
                <h3>Пользователи</h3>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 align-self-center">
                            <div class="card-block">
                                <div class="user-analytics chartist-chart" style="height: 250px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row" style="margin-top: 50px">
            <div class="col-12">
                <ul class="list-inline pull-right">
                    <li>
                        <h6 class="text-muted"><i class="fa fa-circle m-r-5 text-success" style="color: #F05B4F !important;"></i>Подписки</h6>
                    </li>
                </ul>
                <h3>Подписки</h3>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 align-self-center">
                            <div class="card-block">
                                <div class="user-analytics2 chartist-chart" style="height: 250px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @endsection


    @section('js')

            <!-- Chart JS -->
    <script src="/admin/js/dashboard1.js"></script>
    <script src="/admin/js/toastr.js"></script>
    <script src="/admin/assets/plugins/chartist-js/dist/chartist.min.js"></script>
    <script src="/admin/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>

    <script src="/admin/assets/plugins/moment/moment.js"></script>
    <script src="/admin/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>

    <script>

        $('.mydatepicker').datepicker({
            format: 'dd-mm-yyyy'
        });

        var dates = [];
        var user_count = [];
        var subscription_count = [];

        @foreach($results as $key => $item)

                dates['{{$key}}'] = '{{$item['date']}}';
        user_count['{{$key}}'] = parseInt('{{$item['user_count']}}');
        subscription_count['{{$key}}'] = parseInt('{{$item['subscription_count']}}');

        @endforeach

                new Chartist.Line('.user-analytics', {
            labels: dates
            , series: [
                user_count
            ]
        }, {
            high: '{{$max_count}}'
            , low: 0
            , showArea: true
            , lineSmooth: Chartist.Interpolation.simple({
                divisor: 10
            })
            , fullWidth: true
            , chartPadding: 0
            , plugins: [
                Chartist.plugins.tooltip()
            ], // As this is axis specific we need to tell Chartist to use whole numbers only on the concerned axis
            axisY: {
                onlyInteger: true
                , offset: 20
                , labelInterpolationFnc: function (value) {
                    return (value / 1) + 'k';
                }
            }
        });

        new Chartist.Line('.user-analytics2', {
            labels: dates
            , series: [
                subscription_count
            ]
        }, {
            high: '{{$max_count_subscription}}'
            , low: 0
            , showArea: true
            , lineSmooth: Chartist.Interpolation.simple({
                divisor: 10
            })
            , fullWidth: true
            , chartPadding: 0
            , plugins: [
                Chartist.plugins.tooltip()
            ], // As this is axis specific we need to tell Chartist to use whole numbers only on the concerned axis
            axisY: {
                onlyInteger: true
                , offset: 20
                , labelInterpolationFnc: function (value) {
                    return (value / 1) + 'k';
                }
            }
        });


    </script>



@endsection
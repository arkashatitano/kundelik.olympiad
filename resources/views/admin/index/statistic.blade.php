@extends('admin.layout.layout')

@section('content')


    <div class="container-fluid">

        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Статистика посещаемости за сегодня</h3>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-block">
                        <h4 class="card-title">Все пользователи</h4>
                        <div class="text-right">
                            <h2 class="font-light m-b-0"><i class="ti-arrow-up text-success"></i> {{$statistic['user_count_today']}}</h2>
                            <span class="text-muted">Количество посещений</span>
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
                        <h4 class="card-title">Партнеры</h4>
                        <div class="text-right">
                            <h2 class="font-light m-b-0"><i class="ti-arrow-up text-info"></i> {{$statistic['partner_count_today']}}</h2>
                            <span class="text-muted">Количество посещений</span>
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
                        <h4 class="card-title">Member</h4>
                        <div class="text-right">
                            <h2 class="font-light m-b-0"><i class="ti-arrow-up text-purple"></i> {{$statistic['member_count_today']}}</h2>
                            <span class="text-muted">Количество посещений</span>
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
                        <h4 class="card-title">Остальные пользователи</h4>
                        <div class="text-right">
                            <h2 class="font-light m-b-0"><i class="ti-arrow-up text-danger"></i> {{$statistic['other_count_today']}}</h2>
                            <span class="text-muted">Количество посещений</span>
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
                <h3 class="text-themecolor m-b-0 m-t-0">Активность по ученикам</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-6">

                            </div>
                            <div class="col-md-6">
                                <div>
                                    <form id="date_form">
                                        <div>
                                            <div style="float:left; padding-bottom: 3px; width: 40%; ">
                                                <input style="font-size: 14px; width: 90%" value="{{$request->date_from}}" type="text" class="form-control date-format datetimepicker-input" name="date_from" placeholder="с">
                                            </div>
                                            <div style="float:left; width: 40%; margin-left: 5px;">
                                                <input style="font-size: 14px; width: 90%" value="{{$request->date_to}}" type="text" class="form-control date-format datetimepicker-input" name="date_to" placeholder="до">
                                            </div>
                                            <div style="float:left; width: 3%; margin-left: 5px">
                                                <a style="font-size: 12px; padding: 9px 10px" href="javascript:void(0)" onclick="$('#date_form').submit()" class="btn waves-effect waves-light btn-danger pull-right"><i class="fa fa-search"></i> </a>
                                            </div>
                                            <div class="clear-float"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="statistics_day" style="height: 427px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Активность по педагогам</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-6">

                            </div>
                            <div class="col-md-6">
                                <div>
                                    <form id="date_form">
                                        <div>
                                            <div style="float:left; padding-bottom: 3px; width: 40%; ">
                                                <input style="font-size: 14px; width: 90%" value="{{$request->date_from}}" type="text" class="form-control date-format datetimepicker-input" name="date_from" placeholder="с">
                                            </div>
                                            <div style="float:left; width: 40%; margin-left: 5px;">
                                                <input style="font-size: 14px; width: 90%" value="{{$request->date_to}}" type="text" class="form-control date-format datetimepicker-input" name="date_to" placeholder="до">
                                            </div>
                                            <div style="float:left; width: 3%; margin-left: 5px">
                                                <a style="font-size: 12px; padding: 9px 10px" href="javascript:void(0)" onclick="$('#date_form').submit()" class="btn waves-effect waves-light btn-danger pull-right"><i class="fa fa-search"></i> </a>
                                            </div>
                                            <div class="clear-float"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="statistics_day2" style="height: 427px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Лучшие школы по активности учеников</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-6">

                            </div>
                            <div class="col-md-6">
                                <div>
                                    <form id="date_form">
                                        <div>
                                            <div style="float:left; padding-bottom: 3px; width: 40%; ">
                                                <input style="font-size: 14px; width: 90%" value="{{$request->date_from}}" type="text" class="form-control date-format datetimepicker-input" name="date_from" placeholder="с">
                                            </div>
                                            <div style="float:left; width: 40%; margin-left: 5px;">
                                                <input style="font-size: 14px; width: 90%" value="{{$request->date_to}}" type="text" class="form-control date-format datetimepicker-input" name="date_to" placeholder="до">
                                            </div>
                                            <div style="float:left; width: 3%; margin-left: 5px">
                                                <a style="font-size: 12px; padding: 9px 10px" href="javascript:void(0)" onclick="$('#date_form').submit()" class="btn waves-effect waves-light btn-danger pull-right"><i class="fa fa-search"></i> </a>
                                            </div>
                                            <div class="clear-float"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="statistics_day3" style="height: 427px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Лучшие школы по активности педагогов</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-6">

                            </div>
                            <div class="col-md-6">
                                <div>
                                    <form id="date_form">
                                        <div>
                                            <div style="float:left; padding-bottom: 3px; width: 40%; ">
                                                <input style="font-size: 14px; width: 90%" value="{{$request->date_from}}" type="text" class="form-control date-format datetimepicker-input" name="date_from" placeholder="с">
                                            </div>
                                            <div style="float:left; width: 40%; margin-left: 5px;">
                                                <input style="font-size: 14px; width: 90%" value="{{$request->date_to}}" type="text" class="form-control date-format datetimepicker-input" name="date_to" placeholder="до">
                                            </div>
                                            <div style="float:left; width: 3%; margin-left: 5px">
                                                <a style="font-size: 12px; padding: 9px 10px" href="javascript:void(0)" onclick="$('#date_form').submit()" class="btn waves-effect waves-light btn-danger pull-right"><i class="fa fa-search"></i> </a>
                                            </div>
                                            <div class="clear-float"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="statistics_day4" style="height: 427px;"></div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Статистика регистрации пользователей по школам</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-block">
                        <div id="statistics_day5" style="height: 427px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Статистика регистрации пользователей по регионам</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-block">
                        <div id="statistics_day6" style="height: 427px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection


    @section('js')

    <!-- Chart JS -->
    <script src="/admin/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/custom/js/chart.js"></script>

    <script src="/admin/assets/plugins/moment/moment.js"></script>
    <script src="/admin/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <script src="/admin/assets/plugins/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.js" type="text/javascript"></script>

    <script>

        $('.date-format').bootstrapMaterialDatePicker({ format: 'DD.MM.YYYY' });

    </script>

    <!-- Chart JS -->
    <script src="/admin/assets/plugins/echarts/echarts-all.js"></script>
    <script src="/admin/assets/plugins/toast-master/js/jquery.toast.js"></script>

    <script src="/admin/assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>

    <script>

        var regions_name = [];
        var region_authorize_count = [];
        var region_lesson_count = [];

        @foreach($regions as $key => $item)
            regions_name['{{$key}}'] = '{{$item['region_name']}}';
            region_authorize_count['{{$key}}'] = parseInt('{{$item['authorize_count']}}');
            region_lesson_count['{{$key}}'] = parseInt('{{$item['lesson_count']}}');
        @endforeach



        var regions_name_teacher = [];
        var region_authorize_count_teacher = [];

        @foreach($regions_teacher as $key => $item)
            regions_name_teacher['{{$key}}'] = '{{$item['region_name']}}';
            region_authorize_count_teacher['{{$key}}'] = parseInt('{{$item['authorize_count']}}');
        @endforeach



        var regions_name_daryn = [];
        var region_user_count = [];

        @foreach($regions_daryn as $key => $item)
            regions_name_daryn['{{$key}}'] = '{{$item['region_name']}}';
            region_user_count['{{$key}}'] = parseInt('{{$item['user_count']}}');
        @endforeach


        var school_name = [];
        var school_authorize_count = [];
        var school_lesson_count = [];

        @foreach($schools as $key => $item)
            school_name['{{$key}}'] = '{{$item['school_name']}}';
            school_authorize_count['{{$key}}'] = parseInt('{{$item['authorize_count']}}');
            school_lesson_count['{{$key}}'] = parseInt('{{$item['lesson_count']}}');
        @endforeach


        var school_name_teacher = [];
        var school_authorize_count_teacher = [];

        @foreach($schools_teacher as $key => $item)
            school_name_teacher['{{$key}}'] = '{{$item['school_name']}}';
            school_authorize_count_teacher['{{$key}}'] = parseInt('{{$item['authorize_count']}}');
        @endforeach

        var school_name_daryn = [];
        var school_user_count = [];

        @foreach($schools_daryn as $key => $item)
            school_name_daryn['{{$key}}'] = '{{str_replace('"','',$item['school_name'])}}';
            school_user_count['{{$key}}'] = parseInt('{{$item['user_count']}}');
        @endforeach

    </script>


        <script>
            function painterStatisticsArticleCount(objName, xArr, yArrCount, yArrView,title,first_color, second_color) {
                Highcharts.chart(objName, {
                    chart: {
                        zoomType: 'xy',
                    },
                    credits: {
                        enabled: false
                    },
                    title: {
                        text: title
                    },
                    xAxis: [{
                        categories: xArr,
                        crosshair: true
                    }],
                    yAxis: [{
                        labels: {
                            format: '{value}',
                            style: {
                                color: second_color,
                                fill: 'red'
                            }
                        },
                        title: {
                            text: 'Посещаемость',
                            style: {
                                color: second_color,
                                fill: 'red'
                            }
                        }
                    }, {
                        title: {
                            text: 'Урок',
                            style: {
                                color: first_color
                            }
                        },
                        labels: {
                            format: '{value}',
                            style: {
                                color: first_color
                            }
                        },
                        opposite: true
                    }],
                    tooltip: {
                        shared: true
                    },
                    series: [{
                        name: 'Урок',
                        type: 'column',
                        yAxis: 1,
                        data: yArrView,
                        tooltip: {
                            valueSuffix: ''
                        }

                    }, {
                        name: 'Посещаемость',
                        type: 'column',
                        data: yArrCount,
                        tooltip: {
                            valueSuffix: ''
                        }
                    }],
                    colors: [first_color, second_color]
                });
            }

            function painterStatisticsCount(objName, xArr, yArrView,title,first_color,type) {
                Highcharts.chart(objName, {
                    chart: {
                        zoomType: 'x',
                    },
                    credits: {
                        enabled: false
                    },
                    title: {
                        text: title
                    },
                    xAxis: [{
                        categories: xArr,
                        crosshair: true
                    }],
                    yAxis: [{
                        labels: {
                            format: '{value}',
                            style: {
                                color: first_color,
                                fill: 'red'
                            }
                        },
                        title: {
                            text: type,
                            style: {
                                color: first_color,
                                fill: 'red'
                            }
                        }
                    }],
                    tooltip: {
                        shared: true
                    },
                    series: [{
                        name: type,
                        type: 'column',
                        data: yArrView,
                        tooltip: {
                            valueSuffix: ''
                        }

                    }],
                    colors: [first_color]
                });
            }

            $(function () {

                painterStatisticsArticleCount("statistics_day", regions_name, region_lesson_count, region_authorize_count,'Активность по ученикам','#469537','#0d233a');

                painterStatisticsArticleCount("statistics_day3", school_name, school_lesson_count, school_authorize_count,'Лучшие школы по активности учеников','#F62D51','#0d233a');

                painterStatisticsCount("statistics_day2", regions_name_teacher, region_authorize_count_teacher,'Активность по педагогам','#2f7ed8','Посещаемость');

                painterStatisticsCount("statistics_day4", school_name_teacher, school_authorize_count_teacher,'Лучшие школы по активности педагогов','#F75B00','Посещаемость');

                painterStatisticsCount("statistics_day5", school_name_daryn, school_user_count,'Статистика регистрации пользователей по школам','#2f7ed8','Регистрация');

                painterStatisticsCount("statistics_day6", regions_name_daryn, region_user_count,'Статистика регистрации пользователей по регионом','#469537','Регистрация');



            })

        </script>
@endsection
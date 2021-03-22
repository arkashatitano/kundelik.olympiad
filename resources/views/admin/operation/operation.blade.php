@extends('admin.layout.layout')

@section('content')

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0 d-inline-block menu-tab">
                    <a>Операции</a>
                </h3>
                <div class="clear-float"></div>
            </div>
        </div>

        <div class="row white-bg">
            <div class="col-md-12">
                <div class="box-body">
                    <table id="review_datatable" class="table table-bordered table-striped">
                        <thead>
                        <tr style="border: 1px">
                            <th style="width: 30px">№</th>
                            <th>Автор </th>
                            <th>Вид </th>
                            <th>Коммент </th>
                            <th>Сумма</th>
                            <th>Дата</th>
                        </tr>
                        </thead>

                        <tbody>

                        <tr>
                            <td></td>
                            <td>
                                <form>
                                    <input value="{{$request->operation_type_name}}" type="hidden" class="form-control" name="operation_type_name" placeholder="">
                                    <input value="{{$request->user_name}}" type="text" class="form-control" name="user_name" placeholder="">
                                    <input value="{{$request->comment}}" type="hidden" class="form-control" name="comment" placeholder="">
                                </form>
                            </td>
                            <td>
                                <form>
                                    <input value="{{$request->operation_type_name}}" type="text" class="form-control" name="operation_type_name" placeholder="">
                                    <input value="{{$request->user_name}}" type="hidden" class="form-control" name="user_name" placeholder="">
                                    <input value="{{$request->comment}}" type="hidden" class="form-control" name="comment" placeholder="">
                                </form>
                            </td>
                            <td>
                                <form>
                                    <input value="{{$request->operation_type_name}}" type="hidden" class="form-control" name="operation_type_name" placeholder="">
                                    <input value="{{$request->user_name}}" type="hidden" class="form-control" name="user_name" placeholder="">
                                    <input value="{{$request->comment}}" type="text" class="form-control" name="comment" placeholder="">
                                </form>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>

                        @foreach($row as $key => $val)

                            <tr>
                                <td> {{ $key + 1 }}</td>
                                <td>
                                    {{ $val['user_name']}}
                                    <div><strong>{{ $val['email']}}</strong></div>
                                    <div>{{ $val['phone']}}</div>
                                    <div style="border-top: 1px dotted black"><strong>{{ $val['region_name_ru']}}</strong></div>
                                    <div>{{ $val['school_name_ru']}}</div>
                                </td>
                                <td>
                                    {{ $val['operation_type_name_ru']}}
                                </td>
                                <td>
                                    <div>{{ $val['sender_user_name']}}</div>
                                    {{ $val['comment']}}
                                </td>
                                <td>
                                    <strong style="@if($val->daryn > 0) color:green; @else color:red @endif">{{ $val['score']}}</strong>
                                </td>
                                <td>
                                    {{ $val['date']}}
                                </td>
                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                    <div style="text-align: center">
                        {{ $row->withQueryString()->links() }}
                    </div>

                </div>
            </div>
        </div>

    </div>

@endsection

@section('js')

    <style>
        .table-bordered > tbody > tr > td,.table-bordered > tbody > tr > th {
            font-size: 14px !important;
            font-weight: 400 !important;
            color: #4B4B4B !important;
            font-family: Calibri;
        }
        .table-bordered > thead > tr > th {
            font-size: 14px !important;
            font-family: Calibri;
        }
        .f-15 {
            font-size: 13px;
        }
    </style>

    <link href="/custom/fancybox/jquery.fancybox.css" type="text/css" rel="stylesheet">
    <script src="/custom/fancybox/jquery.fancybox.pack.js" type="text/javascript"></script>

    <script>
        $('a.fancybox').fancybox({
            padding: 10
        });
    </script>
@endsection

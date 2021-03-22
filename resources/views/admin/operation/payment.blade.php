@extends('admin.layout.layout')

@section('content')

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0 d-inline-block menu-tab">
                    <a>Платежи</a>
                </h3>
                <div class="clear-float"></div>
            </div>
            <div class="col-md-4 text-right">
                <p style="font-size: 16px;margin-top: 9px;">Общая сумма: <strong style="color: red">{{$total_sum}} тг</strong></p>
            </div>
        </div>

        <div class="row white-bg">
            <div class="col-md-12">
                <div class="box-body">
                    <table id="review_datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr style="border: 1px">
                                <th style="width: 100px">Номер платежа</th>
                                <th>Пользователь</th>
                                <th>Сумма</th>
                                <th>Номер транзакции</th>
                                <th>Способ платежа</th>
                                <th>Дата покупки</th>
                                <th>Вид</th>
                                <th>Статус</th>
                            </tr>
                        </thead>

                        <tbody>

                        <tr>
                            <td>
                                <form>
                                    <input value="{{$request->user_name}}" type="hidden" class="form-control" name="user_name" placeholder="">
                                    <input value="{{$request->range_from}}" type="hidden" class="form-control" name="range_from" placeholder="">
                                    <input value="{{$request->range_to}}" type="hidden" class="form-control" name="range_to" placeholder="">
                                    <input value="{{$request->transaction_number}}" type="hidden" class="form-control" name="transaction_number" placeholder="">
                                    <input value="{{$request->user_request_id}}" type="text" class="form-control" name="user_request_id" placeholder="">
                                    <input value="{{$request->payment_type_name}}" type="hidden" class="form-control" name="payment_type_name" placeholder="">
                                </form>
                            </td>
                            <td>
                                <form>
                                    <input value="{{$request->user_name}}" type="text" class="form-control" name="user_name" placeholder="">
                                    <input value="{{$request->range_from}}" type="hidden" class="form-control" name="range_from" placeholder="">
                                    <input value="{{$request->range_to}}" type="hidden" class="form-control" name="range_to" placeholder="">
                                    <input value="{{$request->transaction_number}}" type="hidden" class="form-control" name="transaction_number" placeholder="">
                                    <input value="{{$request->user_request_id}}" type="hidden" class="form-control" name="user_request_id" placeholder="">
                                    <input value="{{$request->payment_type_name}}" type="hidden" class="form-control" name="payment_type_name" placeholder="">
                                </form>
                            </td>
                            <td>
                                <form id="range_form">
                                    <input value="{{$request->user_name}}" type="hidden" class="form-control" name="user_name" placeholder="">
                                    <input value="{{$request->range_from}}" style="font-size: 11px;min-height: 8px;padding: 4px 10px;" type="number" class="form-control" name="range_from" placeholder="От">
                                    <input value="{{$request->range_to}}" style="margin: 1px 0px; font-size: 11px;min-height: 8px;padding: 4px 10px;" type="number" class="form-control" name="range_to" placeholder="До">
                                    <input value="{{$request->transaction_number}}" type="hidden" class="form-control" name="transaction_number" placeholder="">
                                    <input value="{{$request->user_request_id}}" type="hidden" class="form-control" name="user_request_id" placeholder="">
                                    <input value="{{$request->payment_type_name}}" type="hidden" class="form-control" name="payment_type_name" placeholder="">
                                    <div >
                                        <a style="font-size: 12px; padding: 2px 10px;width: 100%;" href="javascript:void(0)" onclick="$('#range_form').submit()" class="btn waves-effect waves-light btn-danger pull-right hidden-sm-down"><i class="fa fa-search"></i> </a>
                                    </div>
                                </form>
                            </td>
                            <td>
                                <form>
                                    <input value="{{$request->user_name}}" type="hidden" class="form-control" name="user_name" placeholder="">
                                    <input value="{{$request->range_from}}" type="hidden" class="form-control" name="range_from" placeholder="">
                                    <input value="{{$request->range_to}}" type="hidden" class="form-control" name="range_to" placeholder="">
                                    <input value="{{$request->transaction_number}}" type="text" class="form-control" name="transaction_number" placeholder="">
                                    <input value="{{$request->user_request_id}}" type="hidden" class="form-control" name="user_request_id" placeholder="">
                                    <input value="{{$request->payment_type_name}}" type="hidden" class="form-control" name="payment_type_name" placeholder="">
                                </form>
                            </td>
                            <td>
                                <form>
                                    <input value="{{$request->user_name}}" type="hidden" class="form-control" name="user_name" placeholder="">
                                    <input value="{{$request->range_from}}" type="hidden" class="form-control" name="range_from" placeholder="">
                                    <input value="{{$request->range_to}}" type="hidden" class="form-control" name="range_to" placeholder="">
                                    <input value="{{$request->transaction_number}}" type="hidden" class="form-control" name="transaction_number" placeholder="">
                                    <input value="{{$request->user_request_id}}" type="hidden" class="form-control" name="user_request_id" placeholder="">
                                    <input value="{{$request->payment_type_name}}" type="text" class="form-control" name="payment_type_name" placeholder="">
                                </form>
                            </td>
                            <td colspan="2">
                                <form id="date_form">
                                    <div style="width: 180px">
                                        <div style="float:left; padding-bottom: 3px; width: 45%; ">
                                            <input style="font-size: 11px" value="{{$request->date_from}}" type="text" class="form-control date-format datetimepicker-input" name="date_from" placeholder="с">
                                        </div>
                                        <div style="float:right; width: 45%;">
                                            <input style="font-size: 11px" value="{{$request->date_to}}" type="text" class="form-control date-format datetimepicker-input" name="date_to" placeholder="до">
                                        </div>
                                        <div class="clear-float"></div>
                                    </div>
                                    <input value="{{$request->range_from}}" type="hidden" class="form-control" name="range_from" placeholder="">
                                    <input value="{{$request->range_to}}" type="hidden" class="form-control" name="range_to" placeholder="">
                                    <input value="{{$request->email}}" type="hidden" class="form-control" name="email" placeholder="">
                                    <input value="{{$request->redaction}}" type="hidden" class="form-control" name="redaction" placeholder="">
                                    <input value="{{$request->role}}" type="hidden" class="form-control" name="role" placeholder="">
                                    <input value="{{$request->client_name}}" type="hidden" class="form-control" name="client_name" placeholder="">
                                    <input value="@if(isset($request->active)){{$request->active}}@else{{'0'}}@endif" type="hidden" class="form-control" name="active" placeholder="">
                                </form>
                            </td>
                            <td>
                                <div style="float:right; width: 3%;">
                                    <a style="font-size: 12px; padding: 9px 10px" href="javascript:void(0)" onclick="$('#date_form').submit()" class="btn waves-effect waves-light btn-danger pull-right hidden-sm-down"><i class="fa fa-search"></i> </a>
                                </div>
                            </td>
                        </tr>

                        @foreach($row as $key => $val)

                            <tr>
                                <td>{{ $val['user_request_id'] }}</td>
                                <td>
                                    {{ $val['user_name']}}
                                    <div><strong>{{ $val['email']}}</strong></div>
                                    <div>{{ $val['phone']}}</div>
                                    <div style="border-top: 1px dotted black"><strong>{{ $val['region_name_ru']}}</strong></div>
                                    <div>{{ $val['school_name_ru']}}</div>
                                </td>
                                <td>
                                    {{ $val['cost']}}

                                    @if($val->is_use_bonus > 0)

                                        <div>
                                            <strong style="color: red">{{ $val['used_bonus']}}</strong>
                                        </div>

                                    @endif

                                </td>
                                <td>
                                    {{ $val['transaction_number']}}
                                </td>
                                <td>
                                    <strong>{{ $val['payment_type_name_ru']}}</strong>
                                    @if($val->is_use_bonus > 0)
                                        <strong style="color: red"> + bonus</strong>
                                    @endif
                                </td>
                                <td>
                                    {{ $val['date']}}
                                </td>
                                <td>
                                    @if($val->is_combo == 1)
                                        Оплата комбо
                                    @elseif($val->is_purse == 1 || $val->payment_type_id == 5)
                                        Пополнение кошелька
                                    @else
                                        Оплата курса
                                    @endif
                                </td>
                                <td>
                                    @if($val->is_pay == 1)
                                        <span class="label label-success f-15">Оплачено</span>
                                    @endif

                                    @if($val->is_success == 0)
                                        <span class="label label-danger f-15">Ошибка</span>
                                    @endif
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

    <script src="/admin/assets/plugins/moment/moment.js"></script>
    <script src="/admin/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>

    <script>


        $('.date-format').datepicker({
            format: 'dd-mm-yyyy'
        });

    </script>

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

@extends('admin.layout.layout')

@section('content')

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-8 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0 d-inline-block menu-tab">
                    <a href="/admin/client" class="@if(!isset($request->active) || $request->active == '0') active-page @endif">Активные пользователи</a>
                </h3>
                <h3 class="text-themecolor m-b-0 m-t-0 d-inline-block menu-tab second-tab" >
                    <a href="/admin/client?active=1" class="@if($request->active == '1') active-page @endif">Заблокированные пользователи</a>
                </h3>
                <div class="clear-float"></div>
            </div>
            <div class="col-md-4 col-4 align-self-center text-right">
                <a href="/admin/client/create" class="btn waves-effect waves-light btn-danger pull-right hidden-sm-down"> Добавить</a>
            </div>
        </div>

        <div class="row white-bg">
            <div style="text-align: left" class="form-group col-md-6" >

                @if($request->active == '1')

                    <h4 class="box-title box-edit-click">
                        <a href="javascript:void(0)" onclick="isShowDisabledAll('client')">Разблокировать отмеченные</a>
                    </h4>

                @else

                    <h4 class="box-title box-edit-click">
                        <a href="javascript:void(0)" onclick="isShowEnabledAll('client')">Заблокировать отмеченные</a>
                    </h4>

                @endif

            </div>
            <div style="text-align: right" class="form-group col-md-6" >
                <h4 class="box-title box-delete-click">
                    <a href="javascript:void(0)" onclick="deleteAll('client')">Удалить отмеченные</a>
                </h4>
            </div>

            <div class="col-md-12">
                <div class="box-body">
                    <table id="client_datatable" class="table table-bordered table-striped">
                        <thead>
                        <tr style="border: 1px">
                            <th style="width: 100px">ID</th>
                            <th>Фото</th>
                            <th>ФИО</th>
                            <th>Email</th>
                            <th>Роль</th>
                            <th>Телефон</th>
                            <th>Сбросить пароль</th>
                            <th style="width: 15px"></th>
                            <th class="no-sort" style="width: 0px; text-align: center; padding-right: 16px; padding-left: 14px;" >
                                <input onclick="selectAllCheckbox(this)" style="font-size: 15px" type="checkbox" value="1"/>
                            </th>
                        </tr>
                        </thead>

                        <tbody>

                        <tr>
                            <td>
                                <form>
                                    <input style="font-size: 12px" value="{{$request->client_id}}" type="text" class="form-control" name="client_id" placeholder="">
                                    <input value="{{$request->email}}" type="hidden" class="form-control" name="email" placeholder="">
                                    <input value="{{$request->phone}}" type="hidden" class="form-control" name="phone" placeholder="">
                                    <input value="{{$request->role}}" type="hidden" class="form-control" name="role" placeholder="">
                                    <input value="{{$request->grade}}" type="hidden" class="form-control" name="grade" placeholder="">
                                    <input value="{{$request->client_name}}" type="hidden" class="form-control" name="client_name" placeholder="">
                                    <input type="hidden" value="@if(!isset($request->active)){{'0'}}@else{{$request->active}}@endif" name="active"/>
                                </form>
                            </td>
                            <td></td>
                            <td>
                                <form>
                                     <input value="{{$request->client_id}}" type="hidden" class="form-control" name="client_id" placeholder="">
                                     <input value="{{$request->email}}" type="hidden" class="form-control" name="email" placeholder="">
                                     <input value="{{$request->phone}}" type="hidden" class="form-control" name="phone" placeholder="">
                                     <input value="{{$request->role}}" type="hidden" class="form-control" name="role" placeholder="">
                                     <input value="{{$request->grade}}" type="hidden" class="form-control" name="grade" placeholder="">
                                     <input value="{{$request->client_name}}" type="text" class="form-control" name="client_name" placeholder="">
                                     <input type="hidden" value="@if(!isset($request->active)){{'0'}}@else{{$request->active}}@endif" name="active"/>
                                </form>
                            </td>
                            <td>
                                <form>
                                    <input value="{{$request->client_id}}" type="hidden" class="form-control" name="client_id" placeholder="">
                                    <input value="{{$request->email}}" type="text" class="form-control" name="email" placeholder="">
                                    <input value="{{$request->phone}}" type="hidden" class="form-control" name="phone" placeholder="">
                                    <input value="{{$request->role}}" type="hidden" class="form-control" name="role" placeholder="">
                                    <input value="{{$request->grade}}" type="hidden" class="form-control" name="grade" placeholder="">
                                    <input value="{{$request->client_name}}" type="hidden" class="form-control" name="client_name" placeholder="">
                                    <input type="hidden" value="@if(!isset($request->active)){{'0'}}@else{{$request->active}}@endif" name="active"/>
                                </form>
                            </td>
                            <td>
                                <form>
                                    <input value="{{$request->client_id}}" type="hidden" class="form-control" name="client_id" placeholder="">
                                    <input value="{{$request->email}}" type="hidden" class="form-control" name="email" placeholder="">
                                    <input value="{{$request->phone}}" type="hidden" class="form-control" name="phone" placeholder="">
                                    <input value="{{$request->role}}" type="text" class="form-control" name="role" placeholder="">
                                    <input value="{{$request->grade}}" type="hidden" class="form-control" name="grade" placeholder="">
                                    <input value="{{$request->client_name}}" type="hidden" class="form-control" name="client_name" placeholder="">
                                    <input type="hidden" value="@if(!isset($request->active)){{'0'}}@else{{$request->active}}@endif" name="active"/>
                                </form>
                            </td>
                            <td>
                                <form>
                                    <input value="{{$request->client_id}}" type="hidden" class="form-control" name="client_id" placeholder="">
                                    <input value="{{$request->email}}" type="hidden" class="form-control" name="email" placeholder="">
                                    <input value="{{$request->phone}}" type="text" class="form-control" name="phone" placeholder="">
                                    <input value="{{$request->role}}" type="hidden" class="form-control" name="role" placeholder="">
                                    <input value="{{$request->grade}}" type="hidden" class="form-control" name="grade" placeholder="">
                                    <input value="{{$request->client_name}}" type="hidden" class="form-control" name="client_name" placeholder="">
                                    <input type="hidden" value="@if(!isset($request->active)){{'0'}}@else{{$request->active}}@endif" name="active"/>
                                </form>
                            </td>

                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        @foreach($row as $key => $val)

                            <tr>
                                <td>{{ $val['user_id']}}</td>
                                <td>
                                    <div class="object-image" style="margin: 0px !important;">
                                        <a class="fancybox" href="{{$val->avatar}}">
                                            <img style="width: 30px; height: 30px" src="{{$val->avatar}}">
                                        </a>
                                    </div>
                                    <div class="clear-float"></div>
                                </td>
                                <td>
                                    {{ $val['name']}}
                                </td>
                                <td>
                                    <span style="color: red">{{ $val['email']}}</span>
                                    <div>
                                        @if($val['parent_region_name_ru'] != '')
                                            <strong>{{ $val['parent_region_name_ru'] }},</strong><br/>
                                        @endif

                                        <strong>{{ $val['region_name_ru']}}</strong>
                                    </div>
                                </td>

                                <td>
                                    {{ $val['role_name_ru']}}


                                </td>
                                <td>
                                    <span style="color: red">{{ $val['phone']}}</span>

                                    @if($val->is_confirm_email == 0)
                                        <div>
                                            <span style="color: green" id="status_label_{{$val->user_id}}">Почта не подтвержден</span>
                                        </div>
                                    @endif

                                    <div>
                                        <strong>Регистрация:</strong><span>{{ $val['date']}}</span>
                                    </div>
                                    <div>
                                        <strong>Бонус:</strong><span> {{ $val['bonus']}}</span>
                                    </div>
                                    <div>
                                        <strong>Кошелек:</strong><span> {{ $val['money']}}</span>
                                    </div>
                                </td>
                                <td>
                                    <a href="/admin/client/reset/{{$val->user_id}}?page={{$request->page}}" class="btn waves-effect waves-light btn-info pull-right hidden-sm-down" ><i class="mdi mdi-settings"></i>Сбросить пароль</a>
                                </td>
                                <td style="text-align: center">
                                    <a href="javascript:void(0)" onclick="delItem(this,'{{ $val->user_id }}','client')">
                                        <i class="mdi mdi-delete" style="font-size: 20px; color: red;"></i>
                                    </a>
                                    <div>
                                        <a href="/admin/client/{{ $val->user_id }}/edit">
                                            <i class="mdi mdi-grease-pencil" style="font-size: 20px;"></i>
                                        </a>
                                    </div>
                                    <div>
                                        <a href="javascript:void(0)" onclick="getClientPhoneById('{{ $val->user_id }}')">
                                            <i class="mdi mdi-phone" style="font-size: 20px; color: green"></i>
                                        </a>
                                    </div>
                                </td>
                                <td style="text-align: center;">
                                    <input class="select-all" style="font-size: 15px" type="checkbox" value="{{$val->user_id}}"/>
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

    <div id="modal_list"></div>

@endsection

@section('js')

    <link href="/custom/fancybox/jquery.fancybox.css" type="text/css" rel="stylesheet">
    <script src="/custom/fancybox/jquery.fancybox.pack.js" type="text/javascript"></script>

    <script>
        $('a.fancybox').fancybox({
            padding: 10
        });
    </script>
@endsection


@section('css')

    <style>
        .table-bordered > tbody > tr > td,.table-bordered > tbody > tr > th {
            font-size: 13px !important;
            font-weight: 400 !important;
            color: #4B4B4B !important;
            font-family: Calibri;
        }
        .table-bordered > thead > tr > th {
            font-size: 13px !important;
            font-family: Calibri;
        }
        .f-15 {
            font-size: 12px;
        }
    </style>

@endsection

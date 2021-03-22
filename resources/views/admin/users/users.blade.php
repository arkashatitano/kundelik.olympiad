@extends('admin.layout.layout')

@section('content')

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-8 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0 d-inline-block menu-tab">
                    <a href="/admin/user" class="@if(!isset($request->active) || $request->active == '0') active-page @endif">Активные администраторы</a>
                </h3>
                <h3 class="text-themecolor m-b-0 m-t-0 d-inline-block menu-tab second-tab" >
                    <a href="/admin/user?active=1" class="@if($request->active == '1') active-page @endif">Заблокированные администраторы</a>
                </h3>
                <div class="clear-float"></div>
            </div>
            <div class="col-md-4 col-4 align-self-center text-right">
                <a href="/admin/user/create" class="btn waves-effect waves-light btn-danger pull-right hidden-sm-down"> Добавить</a>
            </div>
        </div>

        <div class="row white-bg">
            <div style="text-align: left" class="form-group col-md-6" >

                @if($request->active == '1')

                    <h4 class="box-title box-edit-click">
                        <a href="javascript:void(0)" onclick="isShowDisabledAll('user')">Разблокировать отмеченные</a>
                    </h4>

                @else

                    <h4 class="box-title box-edit-click">
                        <a href="javascript:void(0)" onclick="isShowEnabledAll('user')">Заблокировать отмеченные</a>
                    </h4>

                @endif

            </div>
            <div style="text-align: right" class="form-group col-md-6" >
                <h4 class="box-title box-delete-click">
                    <a href="javascript:void(0)" onclick="deleteAll('user')">Удалить отмеченные</a>
                </h4>
            </div>

            <div class="col-md-12">
                <div class="box-body">
                    <table id="user_datatable" class="table table-bordered table-striped">
                        <thead>
                        <tr style="border: 1px">
                            <th style="width: 30px">№</th>
                            <th>Фото</th>
                            <th>ФИО</th>
                            <th>Логин</th>
                            <th>Сбросить пароль</th>
                            <th style="width: 15px"></th>
                            <th style="width: 15px"></th>
                            <th class="no-sort" style="width: 0px; text-align: center; padding-right: 16px; padding-left: 14px;" >
                                <input onclick="selectAllCheckbox(this)" style="font-size: 15px" type="checkbox" value="1"/>
                            </th>
                        </tr>
                        </thead>

                        <tbody>

                        <tr>
                            <td></td>
                            <td></td>
                            <td>
                                <form>
                                     <input value="{{$request->login}}" type="hidden" class="form-control" name="login" placeholder="">
                                     <input value="{{$request->name}}" type="text" class="form-control" name="name" placeholder="">
                                     <input type="hidden" value="@if(!isset($request->active)){{'0'}}@else{{$request->active}}@endif" name="active"/>
                                </form>
                            </td>
                            <td>
                                <form>
                                    <input value="{{$request->login}}" type="text" class="form-control" name="login" placeholder="">
                                    <input value="{{$request->name}}" type="hidden" class="form-control" name="name" placeholder="">
                                    <input type="hidden" value="@if(!isset($request->active)){{'0'}}@else{{$request->active}}@endif" name="active"/>
                                </form>
                            </td>
                            <td>
                                <form>
                                    <input value="{{$request->login}}" type="hidden" class="form-control" name="login" placeholder="">
                                    <input value="{{$request->name}}" type="hidden" class="form-control" name="name" placeholder="">
                                    <input type="hidden" value="@if(!isset($request->active)){{'0'}}@else{{$request->active}}@endif" name="active"/>
                                </form>
                            </td>
                            <td></td>
                            <td></td>

                            <td></td>
                            <td></td>
                        </tr>

                        @foreach($row as $key => $val)

                            <tr>
                                <td> {{ $key + 1 }}</td>
                                <td>
                                    <div class="object-image">
                                        <a class="fancybox" href="{{$val->avatar}}">
                                            <img src="{{$val->avatar}}">
                                        </a>
                                    </div>
                                    <div class="clear-float"></div>
                                </td>
                                <td>
                                    {{ $val['name']}}
                                </td>
                                <td>
                                    {{ $val['email']}}
                                </td>
                                <td>
                                    <a href="/admin/user/reset/{{$val->user_id}}?page={{$request->page}}" class="btn waves-effect waves-light btn-success pull-right hidden-sm-down" ><i class="mdi mdi-settings"></i>Сбросить пароль</a>
                                </td>
                                <td style="text-align: center">
                                    <a href="javascript:void(0)" onclick="delItem(this,'{{ $val->user_id }}','user')">
                                        <i class="mdi mdi-delete" style="font-size: 20px; color: red;"></i>
                                    </a>
                                </td>
                                <td style="text-align: center">
                                    <a href="/admin/user/{{ $val->user_id }}/edit">
                                        <i class="mdi mdi-grease-pencil" style="font-size: 20px;"></i>
                                    </a>
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

@extends('admin.layout.layout')

@section('content')

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-8 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0 d-inline-block menu-tab">
                    <a href="/admin/menu<?php if(isset($_GET['parent_id']))echo '?parent_id='.$_GET['parent_id'];?>" class="@if(!isset($request->active) || $request->active == '1') active-page @endif">Активные страницы</a>
                </h3>
                <h3 class="text-themecolor m-b-0 m-t-0 d-inline-block menu-tab second-tab" >
                    <a href="/admin/menu?active=0<?php if(isset($_GET['parent_id']))echo '&parent_id='.$_GET['parent_id'];?>" class="@if($request->active == '0') active-page @endif">Неактивные страницы</a>
                </h3>
                <div class="clear-float"></div>
            </div>
            <div class="col-md-4 col-4 align-self-center text-right">
                @if(isset($_GET['parent_id']))
                    <a href="/admin/menu" class="btn waves-effect waves-light btn-danger pull-right hidden-sm-down"> Назад</a>
                @endif

                <a href="/admin/menu/create<?php if(isset($_GET['parent_id']))echo '?parent_id='.$_GET['parent_id'];?>" class="btn waves-effect waves-light btn-danger pull-right hidden-sm-down"> Добавить</a>
            </div>
        </div>

        <div class="row white-bg">
            <div style="text-align: left" class="form-group col-md-6" >

                @if($request->active == '0')

                    <h4 class="box-title box-edit-click">
                        <a href="javascript:void(0)" onclick="isShowEnabledAll('menu')">Сделать активным отмеченные</a>
                    </h4>

                @else

                    <h4 class="box-title box-edit-click">
                        <a href="javascript:void(0)" onclick="isShowDisabledAll('menu')">Сделать неактивным отмеченные</a>
                    </h4>

                @endif

            </div>
            <div style="text-align: right" class="form-group col-md-6" >
                <h4 class="box-title box-delete-click">
                    <a href="javascript:void(0)" onclick="deleteAll('menu')">Удалить отмеченные</a>
                </h4>
            </div>

            <div class="col-md-12">
                <div class="box-body">
                    <table id="menu_datatable" class="table table-bordered table-striped">
                        <thead>
                        <tr style="border: 1px">
                            <th style="width: 30px">№</th>
                            <th>Название</th>
                            <th>Ссылка</th>
                            <th>Порядок сортировки</th>
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
                            <td>
                                <form>
                                    <input value="{{$request->menu_name}}" type="text" class="form-control" name="menu_name" placeholder="">
                                    <input type="hidden" value="@if(!isset($request->active)){{'1'}}@else{{$request->active}}@endif" name="active"/>
                                </form>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>

                            <td></td>
                            <td></td>
                        </tr>

                        @foreach($row as $key => $val)

                            <tr>
                                <td> {{ $key + 1 }}</td>
                                <td>
                                    <a class="object-name" href="/admin/menu?parent_id={{$val->menu_id}}">
                                        {{ $val['menu_name_ru']}}
                                    </a>
                                </td>
                                <td>
                                    {{ $val['menu_redirect']}}
                                </td>
                                <td>
                                    {{ $val['sort_num']}}
                                </td>
                                <td style="text-align: center">
                                    <a href="javascript:void(0)" onclick="delItem(this,'{{ $val->menu_id }}','menu')">
                                        <i class="mdi mdi-delete" style="font-size: 20px; color: red;"></i>
                                    </a>
                                </td>
                                <td style="text-align: center">
                                    <a href="/admin/menu/{{ $val->menu_id }}/edit<?php if(isset($_GET['parent_id']))echo '?parent_id='.$_GET['parent_id'];?>"">
                                        <i class="mdi mdi-grease-pencil" style="font-size: 20px;"></i>
                                    </a>
                                </td>
                                <td style="text-align: center;">
                                    <input class="select-all" style="font-size: 15px" type="checkbox" value="{{$val->menu_id}}"/>
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

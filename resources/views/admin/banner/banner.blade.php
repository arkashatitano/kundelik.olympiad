@extends('admin.layout.layout')

@section('content')

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-8 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0 d-inline-block menu-tab">
                    <a href="/admin/banner" class="@if(!isset($request->active) || $request->active == '1') active-page @endif">Опубликованные баннеры</a>
                </h3>
                <h3 class="text-themecolor m-b-0 m-t-0 d-inline-block menu-tab second-tab" >
                    <a href="/admin/banner?active=0" class="@if($request->active == '0') active-page @endif">Неопубликованные</a>
                </h3>
                <div class="clear-float"></div>
            </div>
            <div class="col-md-4 col-4 align-self-center text-right">
                <a href="/admin/banner/create" class="btn waves-effect waves-light btn-danger pull-right hidden-sm-down"> Добавить</a>
            </div>
        </div>

        <div class="row white-bg">
            <div style="text-align: left" class="form-group col-md-6" >

                @if($request->active == '0')

                    <h4 class="box-title box-edit-click">
                        <a href="javascript:void(0)" onclick="isShowEnabledAll('banner')">Опубликовать отмеченные</a>
                    </h4>

                @else

                    <h4 class="box-title box-edit-click">
                        <a href="javascript:void(0)" onclick="isShowDisabledAll('banner')">Неопубликовать отмеченные</a>
                    </h4>

                @endif

            </div>
            <div style="text-align: right" class="form-group col-md-6" >
                <h4 class="box-title box-delete-click">
                    <a href="javascript:void(0)" onclick="deleteAll('banner')">Удалить отмеченные</a>
                </h4>
            </div>

            <div class="col-md-12">
                <div class="box-body">
                    <table id="banner_datatable" class="table table-bordered table-striped">
                        <thead>
                        <tr style="border: 1px">
                            <th style="width: 30px">№</th>
                            <th>Фото</th>
                            <th>Название</th>
                            <th>Ссылка</th>
                            <th>Cекция</th>
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
                                     <input value="{{$request->banner_name}}" type="text" class="form-control" name="banner_name" placeholder="">
                                     <input value="{{$request->section_name}}" type="hidden" class="form-control" name="section_name" placeholder="">
                                     <input value="{{$request->user_name}}" type="hidden" class="form-control" name="user_name" placeholder="">
                                     <input type="hidden" value="@if(!isset($request->active)){{'1'}}@else{{$request->active}}@endif" name="active"/>
                                </form>
                            </td>
                            <td></td>
                            <td>
                                <form>
                                    <input value="{{$request->banner_name}}" type="hidden" class="form-control" name="banner_name" placeholder="">
                                    <input value="{{$request->section_name}}" type="text" class="form-control" name="section_name" placeholder="">
                                    <input value="{{$request->user_name}}" type="hidden" class="form-control" name="user_name" placeholder="">
                                    <input type="hidden" value="@if(!isset($request->active)){{'1'}}@else{{$request->active}}@endif" name="active"/>
                                </form>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        @foreach($row as $key => $val)

                            <tr>
                                <td> {{ $key + 1 }}</td>
                                <td>
                                    <div class="object-image">
                                        <a class="fancybox" href="{{$val->banner_image}}">
                                            <img src="{{$val->banner_image}}">
                                        </a>
                                    </div>
                                    <div class="clear-float"></div>
                                </td>
                                <td>
                                    {{ $val['banner_name_ru']}}
                                </td>
                                <td>
                                    {{ $val['banner_website']}}
                                </td>
                                <td>
                                    {{ $val['section_name']}}
                                </td>
                                <td style="text-align: center">
                                    <a href="javascript:void(0)" onclick="delItem(this,'{{ $val->banner_id }}','banner')">
                                        <i class="mdi mdi-delete" style="font-size: 20px; color: red;"></i>
                                    </a>
                                </td>
                                <td style="text-align: center">
                                    <a href="/admin/banner/{{ $val->banner_id }}/edit">
                                        <i class="mdi mdi-grease-pencil" style="font-size: 20px;"></i>
                                    </a>
                                </td>
                                <td style="text-align: center;">
                                    <input class="select-all" style="font-size: 15px" type="checkbox" value="{{$val->banner_id}}"/>
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

@section('css')

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

@endsection


@extends('admin.layout.layout')

@section('content')

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-8 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0 d-inline-block menu-tab">
                    <a href="/admin/olympiad-test" class="@if(!isset($request->active) || $request->active == '1') active-page @endif">Активные тесты олимпиады</a>
                </h3>
                <h3 class="text-themecolor m-b-0 m-t-0 d-inline-block menu-tab second-tab" >
                    <a href="/admin/olympiad-test?active=0" class="@if($request->active == '0') active-page @endif">Неактивные тесты</a>
                </h3>
                <div class="clear-float"></div>
            </div>
            <div class="col-md-4 col-4 align-self-center text-right">
                <a href="/admin/olympiad-test/create" class="btn waves-effect waves-light btn-danger pull-right hidden-sm-down"> Добавить</a>
            </div>
        </div>

        <div class="row white-bg">
            <div style="text-align: left" class="form-group col-md-6" >

                @if($request->active == '0')

                    <h4 class="box-title box-edit-click">
                        <a href="javascript:void(0)" onclick="isShowEnabledAll('olympiad-test')">Сделать активным отмеченные</a>
                    </h4>

                @else

                    <h4 class="box-title box-edit-click">
                        <a href="javascript:void(0)" onclick="isShowDisabledAll('olympiad-test')">Сделать неактивным отмеченные</a>
                    </h4>

                @endif

            </div>
            <div style="text-align: right" class="form-group col-md-6" >
                <h4 class="box-title box-delete-click">
                    <a href="javascript:void(0)" onclick="deleteAll('olympiad-test')">Удалить отмеченные</a>
                </h4>
            </div>

            <div class="col-md-12">
                <div class="box-body">
                    <table id="olympiad_test_datatable" class="table table-bordered table-striped">
                        <thead>
                        <tr style="border: 1px">
                            <th style="width: 30px">№</th>
                            <th>Фото</th>
                            <th>Название</th>
                            <th>Краткое описание</th>
                            <th>Инфо</th>
                            <th>Дата</th>
                            <th>Стоимость</th>
                            <th>Вопросы</th>
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
                                    <input value="{{$request->olympiad_test_name}}" type="text" class="form-control" name="olympiad_test_name" placeholder="">
                                    <input value="{{$request->subject_name}}" type="hidden" class="form-control" name="subject_name" placeholder="">
                                    <input type="hidden" value="@if(!isset($request->active)){{'1'}}@else{{$request->active}}@endif" name="active"/>
                                </form>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
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
                                    <div class="object-image">
                                        <a class="fancybox" href="{{$val->olympiad_test_image}}">
                                            <img src="{{$val->olympiad_test_image}}">
                                        </a>
                                    </div>
                                    <div class="clear-float"></div>
                                </td>
                                <td>
                                    {{ $val['olympiad_test_name_ru']}}
                                </td>
                                <td>
                                    {{ $val['olympiad_test_desc_ru']}}
                                </td>
                                <td>
                                    @if($val['olympiad_test_is_childhood'] == 0 && $val['olympiad_test_is_childhood'] != '')
                                        <p style="margin-bottom: 0px">Для преподавателей</p>
                                    @elseif($val['olympiad_test_is_childhood'] == 1 && $val['olympiad_test_is_childhood'] != '')
                                        <p style="margin-bottom: 0px">Для школьников</p>
                                    @endif

                                   {{-- @if($val['olympiad_test_grade'] != '' && $val['olympiad_test_grade'] != 0)
                                        <p style="margin-bottom: 0px"><strong>Класс:</strong> {{$val['olympiad_test_grade']}}</p>
                                    @endif--}}

                                    {{--@if($val['olympiad_type_name_ru'] != '')
                                        <p style="margin-bottom: 0px"><strong>Тип:</strong> {{$val['olympiad_type_name_ru']}}</p>
                                    @endif--}}

                                        <p style="margin-bottom: 0px"><strong>Количество обычных вопросов:</strong> {{$val['olympiad_test_question_count']}}</p>
                                        <p style="margin-bottom: 0px"><strong>Количество общих вопросов:</strong> {{$val['special_question_count']}}</p>

                                        @if($val->is_show_level == 1)
                                            <p style="margin-bottom: 0px"><strong>Разделять вопросы по сложности:</strong> Да</p>
                                        @else
                                            <p style="margin-bottom: 0px"><strong>Разделять вопросы по сложности:</strong> Нет</p>
                                        @endif
                                        {{--<p style="margin-bottom: 0px"><strong>Дизайн сертификата:</strong> {{$val['certificate_type_id']}}</p>
                                        <p style="margin-bottom: 0px"><strong>Минимальный балл для диплома:</strong> {{$val['min_point_to_diploma']}}</p>
                                        <p style="margin-bottom: 0px"><strong>Минимальный балл для 2 место:</strong> {{$val['min_point_to_second_place']}}</p>
                                        <p style="margin-bottom: 0px"><strong>Минимальный балл для 1 место:</strong> {{$val['min_point_to_first_place']}}</p>--}}
                                </td>
                                <td>
                                    {{ $val['olympiad_test_date_start']}} - {{ $val['olympiad_test_date_end']}}
                                </td>
                                <td>
                                    {{ $val['olympiad_test_cost']}}тг
                                </td>
                                <td>
                                    <a class="object-name" href="/admin/olympiad-test-question?olympiad_test_id={{$val->olympiad_test_id}}">
                                        Вопросы
                                    </a>
                                </td>
                                <td style="text-align: center">
                                    <a href="javascript:void(0)" onclick="delItem(this,'{{ $val->olympiad_test_id }}','olympiad-test')">
                                        <i class="mdi mdi-delete" style="font-size: 20px; color: red;"></i>
                                    </a>
                                </td>
                                <td style="text-align: center">
                                    <a href="/admin/olympiad-test/{{ $val->olympiad_test_id }}/edit<?php if(isset($_GET['subject_id']))echo '?subject_id='.$_GET['subject_id'];?>"">
                                    <i class="mdi mdi-grease-pencil" style="font-size: 20px;"></i>
                                    </a>
                                </td>
                                <td style="text-align: center;">
                                    <input class="select-all" style="font-size: 15px" type="checkbox" value="{{$val->olympiad_test_id}}"/>
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

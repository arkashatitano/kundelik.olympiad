@extends('admin.layout.layout')

@section('content')

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-8 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0 d-inline-block menu-tab">
                    <a>Ответы Олимпиады</a>
                </h3>
                <div class="clear-float"></div>
            </div>
        </div>

        <div class="row white-bg">
            <div class="col-md-12">
                <div class="box-body">
                    <table id="test_datatable" class="table table-bordered table-striped">
                        <thead>
                        <tr style="border: 1px">
                            <th style="width: 30px">№</th>
                            <th>Пользователь</th>
                            <th>Аудан</th>
                            <th>Тест</th>
                            <th>Балл</th>
                            <th>Статус</th>
                            <th>Ответы</th>
                            <th>Время (c)</th>
                            <th>Дата</th>
                        </tr>
                        </thead>

                        <tbody>

                        <tr>
                            <td></td>
                            <td>
                                <form>
                                    <input value="{{$request->region_name}}" type="hidden" class="form-control" name="region_name" placeholder="">
                                    <input value="{{$request->user_name}}" type="text" class="form-control" name="user_name" placeholder="">
                                    <input value="{{$request->subject_name}}" type="hidden" class="form-control" name="subject_name" placeholder="">
                                    <input value="{{$request->sort_by}}" type="hidden" class="form-control" name="sort_by" placeholder="">
                                    <input value="{{$request->test_name}}" type="hidden" class="form-control" name="test_name" placeholder="">
                                    <input type="hidden" value="@if(!isset($request->active)){{'1'}}@else{{$request->active}}@endif" name="active"/>
                                </form>
                            </td>
                            <td>
                                <form>
                                    <input value="{{$request->region_name}}" type="text" class="form-control" name="region_name" placeholder="">
                                    <input value="{{$request->user_name}}" type="hidden" class="form-control" name="user_name" placeholder="">
                                    <input value="{{$request->subject_name}}" type="hidden" class="form-control" name="subject_name" placeholder="">
                                    <input value="{{$request->sort_by}}" type="hidden" class="form-control" name="sort_by" placeholder="">
                                    <input value="{{$request->test_name}}" type="hidden" class="form-control" name="test_name" placeholder="">
                                    <input type="hidden" value="@if(!isset($request->active)){{'1'}}@else{{$request->active}}@endif" name="active"/>
                                </form>
                            </td>
                            <td>
                                <form>
                                    <input value="{{$request->region_name}}" type="hidden" class="form-control" name="region_name" placeholder="">
                                    <input value="{{$request->test_name}}" type="text" class="form-control" name="test_name" placeholder="">
                                    <input value="{{$request->sort_by}}" type="hidden" class="form-control" name="sort_by" placeholder="">
                                    <input value="{{$request->user_name}}" type="hidden" class="form-control" name="user_name" placeholder="">
                                    <input value="{{$request->subject_name}}" type="hidden" class="form-control" name="subject_name" placeholder="">
                                    <input type="hidden" value="@if(!isset($request->active)){{'1'}}@else{{$request->active}}@endif" name="active"/>
                                </form>
                            </td>
                            <td>
                                <form>
                                    <input value="{{$request->region_name}}" type="hidden" class="form-control" name="region_name" placeholder="">
                                    <input value="{{$request->user_name}}" type="hidden" class="form-control" name="user_name" placeholder="">
                                    <input value="{{$request->subject_name}}" type="hidden" class="form-control" name="subject_name" placeholder="">
                                    <input value="{{$request->test_name}}" type="hidden" class="form-control" name="test_name" placeholder="">
                                    <input type="hidden" value="@if(!isset($request->active)){{'1'}}@else{{$request->active}}@endif" name="active"/>

                                    <select class="form-control select2" name="sort_by" onchange="submit(this)">
                                        <option @if($request->sort_by == '') selected="selected" @endif value="">Сортировка по дате</option>
                                        <option @if($request->sort_by == "rating") selected="selected" @endif value="rating">Сортировка по баллу</option>
                                    </select>
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
                                    {{ $val['name']}}
                                    <div><strong>{{ $val['email']}}</strong></div>
                                    <div>{{ $val['phone']}}</div>
                                </td>
                                <td>
                                    <div>
                                        @if($val['parent_region_name_ru'] != '')
                                            <strong>{{ $val['parent_region_name_ru'] }},</strong><br/>
                                        @endif

                                        <p>{{ $val['region_name_ru']}}</p>
                                    </div>
                                </td>
                                <td>
                                    {{ $val['olympiad_test_name_ru']}}
                                </td>
                                <td>
                                    {{$val->score}}
                                </td>
                                <td>
                                    @if($val->score > 13)
                                        <span class="label label-success f-15">Пройдено</span>
                                    @else
                                        <span class="label label-danger f-15">Не пройдено</span>
                                    @endif
                                </td>
                                <td>
                                    <a style="text-decoration: underline" href="/admin/answer-olympiad-test/{{$val->user_olympiad_test_id}}" target="_blank">
                                        Подробнее
                                    </a>
                                </td>
                                <td>
                                    {{$val->spent_second}} c
                                </td>
                                <td>
                                    {{\App\Http\Helpers::getDateFormat($val->created_at)}}
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

@extends('admin.layout.layout')

@section('content')

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-8 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0 d-inline-block" >
                    <a>Действия пользователей</a>
                </h3>
                <div class="clear-float"></div>
            </div>
        </div>

        <div class="row white-bg">

            <div class="col-md-12">
                <div class="box-body">
                    <table id="user_datatable" class="table table-bordered table-striped">
                        <thead>
                        <tr style="border: 1px">
                            <th style="width: 30px">№</th>
                            <th>Пользователь</th>
                            <th>Действие</th>
                            <th>Дата</th>
                        </tr>
                        </thead>

                        <tbody>

                        <tr>
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
                                    <input value="{{$request->action_name}}" type="text" class="form-control" name="action_name" placeholder="">
                                    <input value="{{$request->name}}" type="hidden" class="form-control" name="name" placeholder="">
                                    <input type="hidden" value="@if(!isset($request->active)){{'0'}}@else{{$request->active}}@endif" name="active"/>
                                </form>
                            </td>
                            <td></td>
                        </tr>

                        @foreach($row as $key => $val)

                            <tr>
                                <td> {{ $key + 1 }}</td>
                                <td>
                                    {{ $val['name']}}
                                </td>
                                <td>
                                    {{ $val['action_text_ru']}}
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

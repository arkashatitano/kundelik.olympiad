@extends('admin.layout.layout')

@section('content')

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-8 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0 d-inline-block menu-tab">
                    <a>Ответы</a>
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
                                <th>Вопрос</th>
                                <th>Правильный ответ</th>
                                <th>Ответ пользователя</th>
                                <th>Статус</th>
                            </tr>

                        </thead>

                        <tbody>

                        @foreach($row as $key => $val)

                            <tr>
                                <td> {{ $key + 1 }}</td>
                                <td>
                                    {{ $val['name']}}
                                </td>
                                <td>
                                    {!!$val->olympiad_test_question_name_ru!!}
                                </td>
                                <td>
                                    {!!$val['variant'.$val->correct_variant]!!}
                                </td>
                                <td>
                                    {!!$val['variant'.$val->user_variant]!!}
                                </td>
<td>
    @if($val->is_correct == 1)
        <span class="label label-success f-15">Ответил</span>
    @else
        <span class="label label-danger f-15">Не ответил</span>
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

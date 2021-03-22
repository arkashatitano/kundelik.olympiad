@foreach($payment_list as $item)

    <div class="history">
        <div class="historyDate">
            <p>{{\App\Http\Helpers::getDateFormat2($item->created_at)}}</p>
        </div>
        <div class="historyName">
            <p>{{$item['olympiad_test_name_ru']}}</p>
        </div>
        <div class="historyStatus">
            <div class="success">
                @if($item->is_pay == 1)
                    Оплачено
                @else
                    Ошибка
                @endif
            </div>
        </div>
    </div>

@endforeach

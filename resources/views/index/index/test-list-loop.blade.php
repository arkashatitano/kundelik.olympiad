@foreach($olympiad_tests as $item)

    <div class="olympiad-item olympiad_type_{{$item->olympiad_test_is_childhood}}">
        <div class="olympiad-item-top">
            <div class="olympiad-item-img">
                <img src="{{$item->olympiad_test_image}}">
            </div>
            <div class="olympiad-item-caption">
                <h3>{{$item->olympiad_test_name_ru}}</h3>
                <div class="meta-time">
                    <i class="icon icon-watch"></i>
                    <span>до {{$item->olympiad_test_date_end}} </span>
                </div>
            </div>
        </div>
        <div class="olympiad-item-bottom">
            <a class="btn-plain btn-main" href="javascript:void(0)" onclick="payOlympiad('{{$item->olympiad_test_id}}',0)">Участвовать {{$item->olympiad_test_cost}} ₸</a>
        </div>
    </div>

@endforeach

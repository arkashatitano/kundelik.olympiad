@foreach($test_list as $item)



        @if($item->is_success == 0)

            <div class="olympiad-card unfinished-card" style="display: none">
                <h3>{{$item['olympiad_test_name_ru']}}</h3>

                <div class="progress-wrapper">
                    <div class="progress">
                        <div class="progress-bar" style="width: 0%"></div>
                    </div>
                    <div class="progress-info">
                        <span>В процессе...</span>
                    </div>

                </div>
                <a class="btn-plain btn-main" href="/test/{{$item->olympiad_test_id}}/{{$item->user_olympiad_test_id}}">Начать тест</a>

            </div>

        @else

            <div class="olympiad-card complete-card">
                <h3>{{$item['olympiad_test_name_ru']}}</h3>

                <div class="progress-wrapper">
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <div class="progress-info">
                        <i class="icon check-green"></i>
                        <span>Пройдено, вы набрали <strong>{{$item->score}}</strong> баллов</span>
                    </div>
                </div>

                @if($item->is_has_diploma > 0)
                    <a target="_blank" class="btn-plain btn-dark" href="/certificate/{{$item->user_olympiad_test_id}}">
                        <i class="icon icon-doc"></i>
                        <span>Скачать сертификат</span>
                    </a>
                @endif

            </div>

        @endif




@endforeach

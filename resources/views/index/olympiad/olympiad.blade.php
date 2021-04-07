@extends('index.layout.layout')

@section('meta-tags')

    <title>{{$olympiad['olympiad_test_name_ru']}}</title>


@endsection

@section('header')
    @include('index.layout.header')
@endsection


@section('content')

    <div class="test-wrapper">
        <div class="container">
            <div class="testPage">
                <ul class="breadcrumb">
                    <li>
                        <a href="/">
                            <i class="icon arrow-left"></i>
                            <span>Олимпиада</span>
                        </a>
                    </li>
                    <li>
                        <span>{{$olympiad['olympiad_test_name_ru']}}</span>
                    </li>
                </ul>

                <h1>{{$olympiad['olympiad_test_name_ru']}}</h1>

                <div class="testPage-content">
                    <div class="testBox">
                        <input type="hidden" value="{{$user_olympiad_test_id}}" id="user_olympiad_test_id"/>

                        <div class="testBox-body">
                            <h6>Вопросы</h6>
                            <ul class="testNumber-list">

                                @for($i = 1; $i <= count($question_list); $i++)

                                    <li class="question-tab-{{$i}} @if($i == 1) active @endif">
                                        <a class="test-number" href="javascript:void(0)" onclick="showQuestion(this,'{{$i}}')">{{$i}}</a>
                                    </li>

                                @endfor

                            </ul>

                            @foreach($question_list as $key => $item)

                                <div class="testDetail question_{{$key}}" @if($key > 0) style="display: none" @endif>

                                    <input type="hidden" value="{{$item->olympiad_test_question_id}}" class="question_id"/>

                                    <?php
                                    $variants = array();
                                    $original_variants = array();
                                    ?>

                                    @for($i = 1; $i <= 5; $i++)

                                        @if($item['variant'.$i] != '')
                                            <?php $variants[] = $item['variant'.$i]; ?>
                                            <?php $original_variants[] = $item['variant'.$i]; ?>
                                        @endif

                                    @endfor

                                    <?php
                                    shuffle($variants);
                                    ?>


                                    <p>{!!$item->olympiad_test_question_name_ru!!}</p>

                                    <div class="answers">

                                        @foreach($variants as $item2)

                                            <label class="radio-container">
                                                {!!$item2!!}
                                                <input name="radio_{{$item->olympiad_test_question_id}}" value="{{array_search($item2,$original_variants,false) + 1}}" type="radio" class="question_variant_{{$item->olympiad_test_question_id}}">
                                                <span class="checkmark">
                                                    <i class="icon check-mark-mini"></i>
                                                </span>
                                            </label>

                                        @endforeach

                                    </div>
                                </div>

                            @endforeach

                        </div>
                        <div class="testBox-bottom">
                            <button style="margin-right: 10px" class="btn-plain btn-main" onclick="showNextQuestion()">Далее</button>
                            <button class="btn-plain btn-main" onclick="sendOlympiadTestVariants()">Закончить тестирование</button>
                        </div>
                    </div>
                    <div class="testTime">
                        <button class="btn-plain testTime-btn">
                            <i class="icon"></i>
                        </button>
                        <div class="testTime-caption">
                            <p class="time-last"><span id="minute">39</span>:<span id="second">59</span></p>
                            <span>Осталось времени</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')

    <script>
        g_question_count = '{{count($question_list)}}';

        timeend= new Date('{{date('Y',strtotime($date))}}', '{{date('m',strtotime($date)) - 1}}', '{{date('d',strtotime($date))}}', '{{date('H',strtotime($date))}}', '{{date('i',strtotime($date))}}', '{{date('s',strtotime($date))}}');
        today_date = new Date('{{date('Y',strtotime($now_date))}}', '{{date('m',strtotime($now_date)) - 1}}', '{{date('d',strtotime($now_date))}}', '{{date('H',strtotime($now_date))}}', '{{date('i',strtotime($now_date))}}', '{{date('s',strtotime($now_date))}}');

        function time() {
            today = new Date(today_date.getTime() + 1000);
            today_date = today;
            today = Math.floor((timeend-today)/1000);

            tsec=today%60; today=Math.floor(today/60); if(tsec<10)tsec='0'+tsec;
            tmin=today%60; today=Math.floor(today/60); if(tmin<10)tmin='0'+tmin;
            thour=today%24; today=Math.floor(today/24);

            if(thour < 0){
                sendOlympiadTestVariants();
            }
            else {
                $('#hour').html(thour);
                $('#minute').html(tmin);
                $('#second').html(tsec);

                window.setTimeout("time()",1000);
            }

        }


        window.onload = function () {
            time();
        };
    </script>

    <script>

        //modal
        $('.testBox-bottom').find('.btn-main').click(function (){
            $('.test-modal').modal('show');
        });

        function showQuestion(ob,i) {
            $('.test-number').closest('li').removeClass('active');
            $(ob).closest('li').addClass('active');
            $('.testDetail').fadeOut(0);
            $('.question_' + i).fadeIn(0);
            g_current_question = i;
        }

        var g_current_question = 1;

        function showNextQuestion() {
            g_current_question++;

            if(g_current_question == (parseInt(g_question_count) + 1)){
                sendOlympiadTestVariants();
                return;
            }

            $('.test-number').closest('li').removeClass('active');
            $('.question-tab-' + g_current_question).addClass('active');
            $('.testDetail').fadeOut(0);
            $('.question_' + g_current_question).fadeIn(0);
        }


    </script>

    <script type="text/x-mathjax-config">
        MathJax.Hub.Config({
          tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
        });
    </script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/MathJax.js?config=TeX-AMS_HTML"></script>


@endsection

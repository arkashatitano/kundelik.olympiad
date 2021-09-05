<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers;
use App\Models\Actions;
use App\Models\Chapter;
use App\Models\Lesson;
use App\Models\OlympiadTest;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use View;
use DB;
use Auth;

class OlympiadTestController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        View::share('menu', 'olympiad-test');
    }

    public function index(Request $request)
    {
        $row = OlympiadTest::orderBy('olympiad_test_id','desc')
                     ->orderBy('sort_num','asc')
                     ->select(
                         'olympiad_test.*',
                         DB::raw('DATE_FORMAT(olympiad_test.olympiad_test_date_start,"%d.%m.%Y") as olympiad_test_date_start'),
                         DB::raw('DATE_FORMAT(olympiad_test.olympiad_test_date_end,"%d.%m.%Y") as olympiad_test_date_end')
                     );

        if(isset($request->active))
            $row->where('olympiad_test.is_show',$request->active);
        else $row->where('olympiad_test.is_show','1');

        if(isset($request->olympiad_test_name) && $request->olympiad_test_name != ''){
            $row->where(function($query) use ($request){
                $query->where('olympiad_test_name_ru','like','%' .$request->olympiad_test_name .'%');
            });
        }

        $row = $row->paginate(20);

        return  view('admin.olympiad-test.olympiad-test',[
            'row' => $row,
            'request' => $request
        ]);
    }

    public function create(Request $request)
    {
        $row = new OlympiadTest();
        $row->olympiad_test_image = '/img/default.jpg';

        return  view('admin.olympiad-test.olympiad-test-edit', [
            'title' => 'Добавить тест',
            'row' => $row
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'olympiad_test_name_ru' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();

            return  view('admin.olympiad-test.olympiad-test-edit', [
                'title' => 'Добавить тест',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }

        $test = new OlympiadTest();
        $test->olympiad_test_name_ru = $request->olympiad_test_name_ru;
        $test->certificate_text_1 = $request->certificate_text_1;
        $test->certificate_text_2 = $request->certificate_text_2;
        $test->certificate_text_3 = $request->certificate_text_3;
        $test->olympiad_rule = $request->olympiad_rule;
        $test->olympiad_test_text_ru = $request->olympiad_test_text_ru;
        $test->olympiad_test_image = $request->olympiad_test_image;
        $test->is_show_level = $request->is_show_level;
        $test->olympiad_test_is_childhood = $request->olympiad_test_is_childhood;
        $test->olympiad_test_grade = $request->olympiad_test_grade;
        $test->certificate_type_id = $request->certificate_type_id;
        $test->olympiad_test_date_start = date("Y-m-d", strtotime($request->olympiad_test_date_start));
        $test->olympiad_test_date_end = date("Y-m-d", strtotime($request->olympiad_test_date_end));
        $test->is_show = 1;
        $test->sort_num = $request->sort_num?$request->sort_num:100;
        $test->min_point_to_diploma = is_numeric($request->min_point_to_diploma)?$request->min_point_to_diploma:14;
        $test->min_point_to_second_place = is_numeric($request->min_point_to_second_place)?$request->min_point_to_second_place:18;
        $test->min_point_to_first_place = is_numeric($request->min_point_to_first_place)?$request->min_point_to_first_place:16;
        $test->olympiad_test_question_count = is_numeric($request->olympiad_test_question_count)?$request->olympiad_test_question_count:20;
        $test->special_question_count = is_numeric($request->special_question_count)?$request->special_question_count:0;
        $test->olympiad_test_cost = is_numeric($request->olympiad_test_cost)?$request->olympiad_test_cost:0;
        $test->olympiad_test_duration = is_numeric($request->olympiad_test_duration)?$request->olympiad_test_duration:100;
        $test->save();

        $test->olympiad_test_url_ru = '/olympiad-test/'.$test->olympiad_test_id.'-'.Helpers::getTranslatedSlugRu($request->olympiad_test_name_ru);
        $test->save();

        $action = new Actions();
        $action->action_code_id = 2;
        $action->action_comment = 'olympiad-test';
        $action->action_text_ru = 'добавил(а) тест олимпиады "' .$test->olympiad_test_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $test->olympiad_test_id;
        $action->save();

        Cache::flush();

        return redirect('/admin/olympiad-test');
    }

    public function edit($id)
    {
        $row = OlympiadTest::find($id);

        return  view('admin.olympiad-test.olympiad-test-edit', [
            'title' => 'Редактировать данные теста',
            'row' => $row
        ]);
    }

    public function show(Request $request,$id){

    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'olympiad_test_name_ru' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();

            return  view('admin.olympiad-test.olympiad-test-edit', [
                'title' => 'Редактировать данные теста',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }

        $test = OlympiadTest::find($id);
        $test->olympiad_test_name_ru = $request->olympiad_test_name_ru;
        $test->certificate_text_1 = $request->certificate_text_1;
        $test->certificate_text_2 = $request->certificate_text_2;
        $test->certificate_text_3 = $request->certificate_text_3;
        $test->olympiad_rule = $request->olympiad_rule;
        $test->olympiad_test_image = $request->olympiad_test_image;
        $test->is_show_level = $request->is_show_level;
        $test->olympiad_test_is_childhood = $request->olympiad_test_is_childhood;
        $test->certificate_type_id = $request->certificate_type_id;
        $test->olympiad_test_grade = $request->olympiad_test_grade;
        $test->olympiad_test_date_start = date("Y-m-d", strtotime($request->olympiad_test_date_start));
        $test->olympiad_test_date_end = date("Y-m-d", strtotime($request->olympiad_test_date_end));
        $test->sort_num = $request->sort_num?$request->sort_num:100;
        $test->min_point_to_diploma = is_numeric($request->min_point_to_diploma)?$request->min_point_to_diploma:14;
        $test->min_point_to_second_place = is_numeric($request->min_point_to_second_place)?$request->min_point_to_second_place:18;
        $test->min_point_to_first_place = is_numeric($request->min_point_to_first_place)?$request->min_point_to_first_place:16;
        $test->olympiad_test_question_count = is_numeric($request->olympiad_test_question_count)?$request->olympiad_test_question_count:20;
        $test->special_question_count = is_numeric($request->special_question_count)?$request->special_question_count:0;
        $test->olympiad_test_cost = is_numeric($request->olympiad_test_cost)?$request->olympiad_test_cost:0;
        $test->olympiad_test_duration = is_numeric($request->olympiad_test_duration)?$request->olympiad_test_duration:100;
        $test->olympiad_test_url_ru = '/olympiad-test/'.$test->olympiad_test_id.'-'.Helpers::getTranslatedSlugRu($request->olympiad_test_name_ru);
        $test->save();

        $action = new Actions();
        $action->action_code_id = 3;
        $action->action_comment = 'olympiad-test';
        $action->action_text_ru = 'редактировал(а) данные теста олимпиады "' .$test->olympiad_test_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $test->olympiad_test_id;
        $action->save();

        Cache::flush();

        return redirect('/admin/olympiad-test');
    }

    public function destroy($id)
    {
        $test = OlympiadTest::find($id);

        $old_name = $test->olympiad_test_name_ru;

        $test->delete();

        $action = new Actions();
        $action->action_code_id = 1;
        $action->action_comment = 'olympiad-test';
        $action->action_text_ru = 'удалил(а) тест олимпиады "' .$test->olympiad_test_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $id;
        $action->save();

        Cache::flush();

    }

    public function changeIsShow(Request $request){
        $test = OlympiadTest::find($request->id);
        $test->is_show = $request->is_show;
        $test->save();

        $action = new Actions();
        $action->action_comment = 'olympiad-test';

        if($request->is_show == 1){
            $action->action_text_ru = 'отметил(а) как активное - тест олимпиады "' .$test->olympiad_test_name_ru .'"';
            $action->action_code_id = 5;
        }
        else {
            $action->action_text_ru = 'отметил(а) как неактивное - тест олимпиады"' .$test->olympiad_test_name_ru .'"';
            $action->action_code_id = 4;
        }

        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $test->olympiad_test_id;
        $action->save();

        Cache::flush();
    }

}

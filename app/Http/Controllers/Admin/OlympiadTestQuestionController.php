<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers;
use App\Models\Actions;
use App\Models\Chapter;
use App\Models\OlympiadTest;
use App\Models\OlympiadTestQuestion;
use App\Models\School;
use App\Models\SchoolTest;
use App\Models\Test;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use View;
use DB;
use Auth;
use Excel;

class OlympiadTestQuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        View::share('menu', 'question');

        $tests = OlympiadTest::orderBy('olympiad_test_name_ru','asc')->select('olympiad_test_id','olympiad_test_name_ru')->get();
        View::share('tests', $tests);
    }

    public function index(Request $request)
    {
        $row = OlympiadTestQuestion::leftJoin('olympiad_test','olympiad_test.olympiad_test_id','=','olympiad_test_question.olympiad_test_id')
                     ->orderBy('olympiad_test_question.created_at','desc')
                     ->select(
                         'olympiad_test_question.*',
                         'olympiad_test.olympiad_test_name_ru',
                        DB::raw('DATE_FORMAT(olympiad_test_question.created_at,"%d.%m.%Y %H:%i") as date'));

        if(isset($request->active))
            $row->where('olympiad_test_question.is_show',$request->active);
        else $row->where('olympiad_test_question.is_show','1');

        if(isset($request->olympiad_test_question_name) && $request->olympiad_test_question_name != ''){
            $row->where(function($query) use ($request){
                $query->where('olympiad_test_question_name_ru','like','%' .$request->olympiad_test_question_name .'%');
            });
        }

        if(isset($request->olympiad_test_name) && $request->olympiad_test_name != ''){
            $row->where(function($query) use ($request){
                $query->where('olympiad_test_name_ru','like','%' .$request->olympiad_test_name .'%');
            });
        }

        if(isset($request->olympiad_test_question_level) && $request->olympiad_test_question_level != ''){
            $row->where(function($query) use ($request){
                $query->where('olympiad_test_question_level',$request->olympiad_test_question_level);
            });
        }

        if(isset($request->olympiad_test_id)){
            $row->where('olympiad_test_question.olympiad_test_id',$request->olympiad_test_id);
        }

        $row = $row->paginate(20);

        return  view('admin.olympiad-test-question.olympiad-test-question',[
            'row' => $row,
            'request' => $request
        ]);
    }

    public function create(Request $request)
    {
        $row = new OlympiadTestQuestion();

        return  view('admin.olympiad-test-question.olympiad-test-question-edit', [
            'title' => 'Добавить вопрос',
            'row' => $row
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'olympiad_test_question_name_ru' => 'required',
            'olympiad_test_id' => 'required'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();

            return  view('admin.olympiad-test-question.olympiad-test-question-edit', [
                'title' => 'Добавить вопрос',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }

        $question = new OlympiadTestQuestion();
        $question->olympiad_test_question_name_ru = $request->olympiad_test_question_name_ru;
        $question->olympiad_test_question_level = $request->olympiad_test_question_level;
        $question->olympiad_test_question_lang = $request->olympiad_test_question_lang;
        $question->variant1 = $request->variant1;
        $question->variant2 = $request->variant2;
        $question->variant3 = $request->variant3;
        $question->variant4 = $request->variant4;
        $question->variant5 = $request->variant5;
        $question->correct_variant = $request->correct_variant;
        $question->olympiad_test_id = $request->olympiad_test_id;
        $question->is_show = 1;
        $question->save();


        $action = new Actions();
        $action->action_code_id = 2;
        $action->action_comment = 'question';
        $action->action_text_ru = 'добавил(а) вопрос олимпиады "' .$question->olympiad_test_question_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $question->olympiad_test_question_id;
        $action->save();



        $url = '';
        if($request->olympiad_test_id != '')
            $url = '?olympiad_test_id=' .$request->olympiad_test_id;

        return redirect('/admin/olympiad-test-question'.$url);
    }

    public function edit($id)
    {
        $row = OlympiadTestQuestion::find($id);

        return  view('admin.olympiad-test-question.olympiad-test-question-edit', [
            'title' => 'Редактировать данные вопроса',
            'row' => $row
        ]);
    }

    public function show(Request $request,$id){

    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'olympiad_test_question_name_ru' => 'required',
            'olympiad_test_id' => 'required'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            return  view('admin.olympiad-test-question.olympiad-test-question-edit', [
                'title' => 'Редактировать данные вопроса',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }

        $question = OlympiadTestQuestion::find($id);
        $question->olympiad_test_question_name_ru = $request->olympiad_test_question_name_ru;
        $question->olympiad_test_question_level = $request->olympiad_test_question_level;
        $question->olympiad_test_question_lang = $request->olympiad_test_question_lang;
        $question->variant1 = $request->variant1;
        $question->variant2 = $request->variant2;
        $question->variant3 = $request->variant3;
        $question->variant4 = $request->variant4;
        $question->variant5 = $request->variant5;
        $question->correct_variant = $request->correct_variant;
        $question->olympiad_test_id = $request->olympiad_test_id;
        $question->is_show = 1;
        $question->save();

        $action = new Actions();
        $action->action_code_id = 3;
        $action->action_comment = 'question';
        $action->action_text_ru = 'редактировал(а) данные вопроса олимпиады "' .$question->olympiad_test_question_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $question->olympiad_test_question_id;
        $action->save();



        $url = '';
        if($request->olympiad_test_id != '')
            $url = '?olympiad_test_id=' .$request->olympiad_test_id;

        return redirect('/admin/olympiad-test-question'.$url);
    }

    public function destroy($id)
    {
        $question = OlympiadTestQuestion::find($id);

        $old_name = $question->olympiad_test_question_name_ru;

        $question->delete();

        $action = new Actions();
        $action->action_code_id = 1;
        $action->action_comment = 'question';
        $action->action_text_ru = 'удалил(а) вопрос олимпиады "' .$question->olympiad_test_question_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $id;
        $action->save();



    }

    public function changeIsShow(Request $request){
        $question = OlympiadTestQuestion::find($request->id);
        $question->is_show = $request->is_show;
        $question->save();

        $action = new Actions();
        $action->action_comment = 'question';

        if($request->is_show == 1){
            $action->action_text_ru = 'отметил(а) как активное - вопрос олимпиады "' .$question->olympiad_test_question_name_ru .'"';
            $action->action_code_id = 5;
        }
        else {
            $action->action_text_ru = 'отметил(а) как неактивное - вопрос олимпиады "' .$question->olympiad_test_question_name_ru .'"';
            $action->action_code_id = 4;
        }

        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $question->olympiad_test_question_id;
        $action->save();


    }

    public function importExcel(Request $request){
        $file = $request->image;
        $extension = $file->getClientOriginalExtension();

        if($extension != 'xlsx' && $extension != 'xls') {
            $result['error'] = 'Загружайте только файлы форматов xlsx, xls';
            $result['success'] = false;
            return response()->json($result);
        }
        elseif($request->olympiad_test_id == ''){
            $result['error'] = 'Вы не указали тест';
            $result['success'] = false;
            return response()->json($result);
        }

        Excel::load($file, function($reader) use ($request) {
            $reader->formatDates(true, 'Y-m-d');
            $reader->each(function($sheet) use ($request) {
                $sheet->each(function($row) use ($request) {

                    $question = new OlympiadTestQuestion();
                    $question->olympiad_test_question_name_ru = $row['vopros'];
                    $question->olympiad_test_question_level = strtolower($row['uroven']);

                    if(isset($row['yazik']) && ($row['yazik'] == 'kz' || $row['yazik'] == 'ru' || $row['yazik'] == 'en'))
                        $question->olympiad_test_question_lang = $row['yazik'];

                    $question->variant1 = $row['variant1'];
                    $question->variant2 = $row['variant2'];
                    $question->variant3 = $row['variant3'];
                    $question->variant4 = $row['variant4'];

                    if(isset($row['variant5']) && $row['variant5'] != '')
                        $question->variant5 = $row['variant5'];

                    $question->correct_variant = $row['otvet'];
                    $question->olympiad_test_id = $request->olympiad_test_id;
                    $question->is_show = 1;
                    $question->save();

                });
                return;
            });
        });

        $result['success'] = true;
        return response()->json($result);
    }

    public function importExcel2(Request $request){
        $file = $request->image;
        $extension = $file->getClientOriginalExtension();

        if($extension != 'xlsx' && $extension != 'xls') {
            $result['error'] = 'Загружайте только файлы форматов xlsx, xls';
            $result['success'] = false;
            return response()->json($result);
        }
        elseif($request->olympiad_test_id == ''){
            $result['error'] = 'Вы не указали тест';
            $result['success'] = false;
            return response()->json($result);
        }

        $count = 0;

        Excel::load($file, function($reader) use ($request,$count) {
            $reader->formatDates(true, 'Y-m-d');

            $reader->each(function($sheet) use ($request,$count) {

                //   $array = array ($sheet[]);

                $json = json_encode($sheet);

                $array = json_decode($json);

                $count = 0;

                $array = (array) $array;
                //dd($array);

                // dd($array['school.bin']);


                if(isset($array['school.bin'])){
                    $school = School::where('bin',$array['school.bin'])->first();
                    if($school != null){
                        $school->kundelik_school_id = $array['school.id'];
                        $school->save();
                    }
                    return;
                }

            });
        });

        $result['success'] = true;
        return response()->json($result);
    }

    public function importExcel3(Request $request){
        $file = $request->image;
        $extension = $file->getClientOriginalExtension();

        if($extension != 'xlsx' && $extension != 'xls') {
            $result['error'] = 'Загружайте только файлы форматов xlsx, xls';
            $result['success'] = false;
            return response()->json($result);
        }
        elseif($request->olympiad_test_id == ''){
            $result['error'] = 'Вы не указали тест';
            $result['success'] = false;
            return response()->json($result);
        }

        $count = 0;

        Excel::load($file, function($reader) use ($request,$count) {
            $reader->formatDates(true, 'Y-m-d');

            $reader->each(function($sheet) use ($request,$count) {

                //   $array = array ($sheet[]);

                $json = json_encode($sheet);

                $array = json_decode($json);

                $count = 0;

                $array = (array) $array;
                //dd($array);

                // dd($array['school.bin']);

                if(isset($array['school.bin'])){
                    $new_school = SchoolTest::where('bin',$array['school.bin'])->first();

                    $new_school = new SchoolTest();
                    $new_school->bin = $array['school.bin'];
                    $new_school->is_confirm = '-';

                    $school = School::where('bin',$array['school.bin'])->first();

                    if($school != null) {
                        $new_school->is_confirm = $school->is_confirm;
                    }

                    $new_school->save();
                    return;
                }

            });
        });

        $result['success'] = true;
        return response()->json($result);
    }
}

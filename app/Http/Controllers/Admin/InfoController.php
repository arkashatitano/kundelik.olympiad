<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers;
use App\Models\Actions;
use App\Models\Info;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use View;
use DB;
use Auth;

class InfoController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        View::share('menu', 'info');
    }

    public function index(Request $request)
    {
        $row = Info::select('*');

        if(isset($request->active))
            $row->where('info.is_show',$request->active);
        else $row->where('info.is_show','1');


        if(isset($request->info_name) && $request->info_name != ''){
            $row->where(function($query) use ($request){
                $query->where('info_name_ru','like','%' .$request->info_name .'%');
            });
        }
        
        $row = $row->paginate(20);

        return  view('admin.info.info',[
            'row' => $row,
            'request' => $request
        ]);
    }

    public function create()
    {
        $row = new Info();
        $row->info_image = '/static/img/content/volkswagen_PNG1781.png';

        return  view('admin.info.info-edit', [
            'title' => 'Добавить текст',
            'row' => $row
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'info_name_ru' => 'required'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            return  view('admin.info.info-edit', [
                'title' => 'Добавить текст',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }

        $info = new Info();
        $info->info_name_ru = $request->info_name_ru;
        $info->info_text_ru = $request->info_text_ru;
        $info->info_name_en = $request->info_name_en;
        $info->info_text_en = $request->info_text_en;
        $info->info_name_kz = $request->info_name_kz;
        $info->info_text_kz = $request->info_text_kz;
        $info->info_image = $request->info_image;
        $info->save();


        $action = new Actions();
        $action->action_code_id = 2;
        $action->action_comment = 'info';
        $action->action_text_ru = 'добавил(а) текст "' .$info->info_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $info->info_id;
        $action->save();

        Cache::flush();

        return redirect('/admin/info');
    }

    public function edit($id)
    {
        $row = Info::find($id);

        return  view('admin.info.info-edit', [
            'title' => 'Редактировать текст',
            'row' => $row
        ]);
    }

    public function show(Request $request,$id){

    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'info_name_ru' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            return  view('admin.info.info-edit', [
                'title' => 'Редактировать текст',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }

        $info = Info::find($id);
        $info->info_name_ru = $request->info_name_ru;
        $info->info_text_ru = $request->info_text_ru;
        $info->info_name_en = $request->info_name_en;
        $info->info_text_en = $request->info_text_en;
        $info->info_name_kz = $request->info_name_kz;
        $info->info_text_kz = $request->info_text_kz;
        $info->info_image = $request->info_image;
        $info->save();

        $action = new Actions();
        $action->action_code_id = 3;
        $action->action_comment = 'info';
        $action->action_text_ru = 'редактировал(а) текст "' .$info->info_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $info->info_id;
        $action->save();

        Cache::flush();

        return redirect('/admin/info');
    }

    public function destroy($id)
    {
        $info = Info::find($id);

        $old_name = $info->info_name_ru;

        $info->delete();

        $action = new Actions();
        $action->action_code_id = 1;
        $action->action_comment = 'info';
        $action->action_text_ru = 'удалил(а) текст "' .$info->info_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $id;
        $action->save();

        Cache::flush();

    }

    public function changeIsShow(Request $request){
        $info = Info::find($request->id);
        $info->is_show = $request->is_show;
        $info->save();

        $action = new Actions();
        $action->action_comment = 'info';

        if($request->is_show == 1){
            $action->action_text_ru = 'отметил(а) как активное - текст "' .$info->info_name_ru .'"';
            $action->action_code_id = 5;
        }
        else {
            $action->action_text_ru = 'отметил(а) как неактивное - текст "' .$info->info_name_ru .'"';
            $action->action_code_id = 4;
        }

        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $info->info_id;
        $action->save();

        Cache::flush();
    }

}

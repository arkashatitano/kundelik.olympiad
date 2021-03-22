<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers;
use App\Models\Actions;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use View;
use DB;
use Auth;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        View::share('menu', 'menu');
    }

    public function index(Request $request)
    {
        $row = Menu::orderBy('menu.sort_num','asc')
            ->select('*',
                DB::raw('DATE_FORMAT(menu.created_at,"%d.%m.%Y %H:%i") as date'));

        if(isset($request->active))
            $row->where('menu.is_show',$request->active);
        else $row->where('menu.is_show','1');


        if(isset($request->menu_name) && $request->menu_name != ''){
            $row->where(function($query) use ($request){
                $query->where('menu_name_ru','like','%' .$request->menu_name .'%');
            });
        }

        if(isset($request->parent_id)){
            $row->where('parent_id',$request->parent_id);
        }
        else {
            $row->where('parent_id',null);
        }
        
        $row = $row->paginate(20);

        return  view('admin.menu.menu',[
            'row' => $row,
            'request' => $request
        ]);
    }

    public function create()
    {
        $row = new Menu();
        $row->menu_image = '/static/img/content/p3.jpg';

        return  view('admin.menu.menu-edit', [
            'title' => 'Добавить страницы',
            'row' => $row
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'menu_name_ru' => 'required'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            return  view('admin.menu.menu-edit', [
                'title' => 'Добавить страницы',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }

        $menu = new Menu();
        $menu->menu_name_ru = $request->menu_name_ru;
        $menu->menu_text_ru = $request->menu_text_ru;
        $menu->menu_desc_ru = $request->menu_desc_ru;
        $menu->menu_meta_title_ru = $request->menu_meta_title_ru?:$request->menu_name_ru;
        $menu->menu_meta_description_ru = $request->menu_meta_description_ru;
        $menu->menu_meta_keywords_ru = $request->menu_meta_keywords_ru;

        $menu->menu_url_ru = Helpers::getTranslatedSlugRu($request->menu_name_ru);

        $menu->menu_name_en = $request->menu_name_en;
        $menu->menu_text_en = $request->menu_text_en;
        $menu->menu_desc_en = $request->menu_desc_en;
        $menu->menu_meta_title_en = $request->menu_meta_title_en;
        $menu->menu_meta_description_en = $request->menu_meta_description_en;
        $menu->menu_meta_keywords_en = $request->menu_meta_keywords_en;
        $menu->menu_url_en = Helpers::getTranslatedSlugRu($request->menu_name_en);

        $menu->menu_name_kz = $request->menu_name_kz;
        $menu->menu_text_kz = $request->menu_text_kz;
        $menu->menu_desc_kz = $request->menu_desc_kz;
        $menu->menu_meta_title_kz = $request->menu_meta_title_kz;
        $menu->menu_meta_description_kz = $request->menu_meta_description_kz;
        $menu->menu_meta_keywords_kz = $request->menu_meta_keywords_kz;
        $menu->menu_url_kz = Helpers::getTranslatedSlugRu($request->menu_name_kz);

        $url = '';
        if($request->parent_id != '') {
            $url = '?parent_id=' .$request->parent_id;
            $menu->parent_id = $request->parent_id;
        }
        
        $menu->menu_redirect = $request->menu_redirect;
        $menu->menu_image = $request->menu_image;
        $menu->is_show_header = $request->is_show_header;
        $menu->is_show_main = $request->is_show_main;
        $menu->is_show_footer = $request->is_show_footer;
        $menu->sort_num = $request->sort_num?$request->sort_num:100;
        $menu->save();


        $action = new Actions();
        $action->action_code_id = 2;
        $action->action_comment = 'menu';
        $action->action_text_ru = 'добавил(а) страницы "' .$menu->menu_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $menu->menu_id;
        $action->save();

        Cache::flush();

        return redirect('/admin/menu'.$url);
    }

    public function edit($id)
    {
        $row = Menu::find($id);

        return  view('admin.menu.menu-edit', [
            'title' => 'Редактировать данные страницы',
            'row' => $row
        ]);
    }

    public function show(Request $request,$id){

    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'menu_name_ru' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            return  view('admin.menu.menu-edit', [
                'title' => 'Редактировать данные страницы',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }

        $menu = Menu::find($id);
        $menu->menu_name_ru = $request->menu_name_ru;
        $menu->menu_text_ru = $request->menu_text_ru;
        $menu->menu_desc_ru = $request->menu_desc_ru;
        $menu->menu_meta_title_ru = $request->menu_meta_title_ru?:$request->menu_name_ru;
        $menu->menu_meta_description_ru = $request->menu_meta_description_ru;
        $menu->menu_meta_keywords_ru = $request->menu_meta_keywords_ru;
        $menu->menu_url_ru = Helpers::getTranslatedSlugRu($request->menu_name_ru);

        $menu->menu_name_en = $request->menu_name_en;
        $menu->menu_text_en = $request->menu_text_en;
        $menu->menu_desc_en = $request->menu_desc_en;
        $menu->menu_meta_title_en = $request->menu_meta_title_en;
        $menu->menu_meta_description_en = $request->menu_meta_description_en;
        $menu->menu_meta_keywords_en = $request->menu_meta_keywords_en;
        $menu->menu_url_en = Helpers::getTranslatedSlugRu($request->menu_name_en);

        $menu->menu_name_kz = $request->menu_name_kz;
        $menu->menu_text_kz = $request->menu_text_kz;
        $menu->menu_desc_kz = $request->menu_desc_kz;
        $menu->menu_meta_title_kz = $request->menu_meta_title_kz;
        $menu->menu_meta_description_kz = $request->menu_meta_description_kz;
        $menu->menu_meta_keywords_kz = $request->menu_meta_keywords_kz;
        $menu->menu_url_kz = Helpers::getTranslatedSlugRu($request->menu_name_kz);

        $url = '';
        if($request->parent_id != '') {
            $url = '?parent_id=' .$request->parent_id;
            $menu->parent_id = $request->parent_id;
        }

        $menu->menu_redirect = $request->menu_redirect;
        $menu->menu_image = $request->menu_image;
        $menu->is_show_header = $request->is_show_header;
        $menu->is_show_main = $request->is_show_main;
        $menu->is_show_footer = $request->is_show_footer;
        $menu->sort_num = $request->sort_num?$request->sort_num:100;
        $menu->save();

        $action = new Actions();
        $action->action_code_id = 3;
        $action->action_comment = 'menu';
        $action->action_text_ru = 'редактировал(а) данные страницы "' .$menu->menu_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $menu->menu_id;
        $action->save();

        Cache::flush();

        return redirect('/admin/menu'.$url);
    }

    public function destroy($id)
    {
        $menu = Menu::find($id);

        $old_name = $menu->menu_name_ru;

        $menu->delete();

        $action = new Actions();
        $action->action_code_id = 1;
        $action->action_comment = 'menu';
        $action->action_text_ru = 'удалил(а) страницы "' .$menu->menu_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $id;
        $action->save();

        Cache::flush();

    }

    public function changeIsShow(Request $request){
        $menu = Menu::find($request->id);
        $menu->is_show = $request->is_show;
        $menu->save();

        $action = new Actions();
        $action->action_comment = 'menu';

        if($request->is_show == 1){
            $action->action_text_ru = 'отметил(а) как активное - меню "' .$menu->menu_name_ru .'"';
            $action->action_code_id = 5;
        }
        else {
            $action->action_text_ru = 'отметил(а) как неактивное - меню "' .$menu->menu_name_ru .'"';
            $action->action_code_id = 4;
        }

        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $menu->menu_id;
        $action->save();

        Cache::flush();
    }

}

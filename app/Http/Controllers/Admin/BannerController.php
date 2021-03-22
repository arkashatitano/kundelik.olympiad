<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers;
use App\Models\Actions;
use App\Models\Menu;
use App\Models\Banner;
use App\Models\Category;
use App\Models\BannerSection;
use App\Models\Section;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use View;
use DB;
use Auth;

class BannerController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        View::share('menu', 'banner');

        $section_list = Section::orderBy('sort_num','asc')->get();
        View::share('sections', $section_list);
    }

    public function index(Request $request)
    {
        $row = Banner::leftJoin('section','section.section_id','=','banner.section_id')
                      ->orderBy('banner.banner_id','desc')
                       ->select('banner.*',
                                'section.section_name');

        if(isset($request->active))
            $row->where('banner.is_show',$request->active);
        else $row->where('banner.is_show','1');
        
        if(isset($request->banner_name) && $request->banner_name != ''){
            $row->where(function($query) use ($request){
                $query->where('banner_name_ru','like','%' .$request->banner_name .'%');
            });
        }
        
        if(isset($request->section_name) && $request->section_name != ''){
            $row->where(function($query) use ($request){
                $query->where('section_name','like','%' .$request->section_name .'%');
            });
        }

        $row = $row->paginate(20);

        return  view('admin.banner.banner',[
            'row' => $row,
            'request' => $request
        ]);
    }

    public function create()
    {
        $row = new Banner();
        
        return  view('admin.banner.banner-edit', [
            'title' => 'Добавить баннер',
            'row' => $row
        ]);
    }

    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
            'banner_name_ru' => 'required'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            return  view('admin.banner.banner-edit', [
                'title' => 'Добавить баннер',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }

        $banner = new Banner();
        $banner->banner_name_ru = $request->banner_name_ru;
        $banner->banner_website = $request->banner_website;
        $banner->banner_image = $request->banner_image;
        $banner->section_id = $request->section_id;
        $banner->save();
        
        $action = new Actions();
        $action->action_code_id = 2;
        $action->action_comment = 'banner';
        $action->action_text_ru = 'добавил(а) баннер "' .$banner->banner_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $banner->banner_id;
        $action->save();

        Cache::flush();

        return redirect('/admin/banner');
    }

    public function edit($id)
    {
        $row = Banner::where('banner_id',$id)
                    ->select('*')
                    ->first();

        return  view('admin.banner.banner-edit', [
            'title' => 'Редактировать данные баннера',
            'row' => $row
        ]);
    }

    public function show(Request $request,$id){

    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'banner_name_ru' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $error = $messages->all();
            
            
            return  view('admin.banner.banner-edit', [
                'title' => 'Редактировать данные баннера',
                'row' => (object) $request->all(),
                'error' => $error[0]
            ]);
        }

        $banner = Banner::find($id);
        $banner->banner_name_ru = $request->banner_name_ru;
        $banner->banner_website = $request->banner_website;
        $banner->banner_image = $request->banner_image;
        $banner->section_id = $request->section_id;
        $banner->save();

        $action = new Actions();
        $action->action_code_id = 3;
        $action->action_comment = 'banner';
        $action->action_text_ru = 'редактировал(а) данные баннера "' .$banner->banner_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $banner->banner_id;
        $action->save();

        Cache::flush();

        return redirect('/admin/banner');
    }

    public function destroy($id)
    {
        $banner = Banner::find($id);

        $old_name = $banner->banner_name_ru;

        $banner->delete();

        $action = new Actions();
        $action->action_code_id = 1;
        $action->action_comment = 'banner';
        $action->action_text_ru = 'удалил(а) баннер "' .$banner->banner_name_ru .'"';
        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $id;
        $action->save();

        Cache::flush();

    }

    public function changeIsShow(Request $request){
        $banner = Banner::find($request->id);
        $banner->is_show = $request->is_show;
        $banner->save();

        $action = new Actions();
        $action->action_comment = 'banner';

        if($request->is_show == 1){
            $action->action_text_ru = 'отметил(а) как активное - баннер "' .$banner->banner_name_ru .'"';
            $action->action_code_id = 5;
        }
        else {
            $action->action_text_ru = 'отметил(а) как неактивное - баннер "' .$banner->banner_name_ru .'"';
            $action->action_code_id = 4;
        }

        $action->user_id = Auth::user()->user_id;
        $action->universal_id = $banner->banner_id;
        $action->save();

        Cache::flush();
    }
}

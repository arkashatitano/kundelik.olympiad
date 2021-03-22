<?php

namespace App\Models;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Illuminate\Support\Facades\Cache;

class Menu extends Model
{
    protected $table = 'menu';
    protected $primaryKey = 'menu_id';

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public static function getHeaderMenu($lang){
        $main_menu_list = Cache::remember('main_menu_list_'.$lang, 1440, function () use ($lang) {
            return Menu::where('is_show_main', 1)
                ->where('is_show', 1)
                ->orderBy('sort_num', 'asc')
                ->select(
                    'menu_id',
                    'menu_redirect',
                    'menu_name_'.$lang,
                    'menu_url_'.$lang
                )
                ->get();
        });
        return $main_menu_list;
    }

    public static function getFooterMenu($lang){
        $main_menu_list = Cache::remember('footer_menu_list_'.$lang, 1440, function () use ($lang) {
            return Menu::where('is_show_footer', 1)
                ->where('is_show', 1)
                ->orderBy('sort_num', 'asc')
                ->select(
                    'menu_id',
                    'menu_redirect',
                    'menu_name_'.$lang,
                    'menu_url_'.$lang
                )
                ->get();
        });
        return $main_menu_list;
    }
}

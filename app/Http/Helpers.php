<?php

namespace App\Http;
use App\Models\Configure;
use App\Models\Contact;
use App\Models\Info;
use App\Models\Lesson;
use App\Models\Menu;

use App\Models\Operation;
use App\Models\Question;
use App\Models\Region;
use App\Models\School;
use App\Models\Speciality;
use App\Models\Status;
use App\Models\Subject;
use App\Models\SubjectProgram;
use App\Models\Subscription;
use App\Models\University;
use App\Models\UserAction;
use App\Models\UserRegion;
use App\Models\Users;
use Illuminate\Support\Facades\Cache;
use Faker\Provider\DateTime;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Mockery\Exception;
use Auth;
use URL;
use Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class Helpers {

    public static function getConvertToQazLatin($text)
    {
        $cyr2lat_replacements = array (
            "А" => "A","Ә" => "A'", "Б" => "B","В" => "V","Г" => "G","Ғ" => "G'","Д" => "D",
            "Е" => "E","Ё" => "E","Ж" => "J","З" => "Z","И" => "I'","І" => "I",
            "Й" => "I'","К" => "K","Қ" => "Q","Һ" => "H","Л" => "L","М" => "M","Н" => "N","Ң" => "N'",
            "О" => "O","Ө" => "O'","П" => "P","Р" => "R","С" => "S","Т" => "T",
            "У" => "Y'","Ұ" => "U","Ү" => "U'","Ф" => "F","Х" => "H","Ц" => "Ts","Ч" => "C'",
            "Ш" => "S'","Щ" => "S'","Ъ" => "","Ы" => "Y","Ь" => "",
            "Э" => "E","Ю" => "Yu","Я" => "Ya",
            "а" => "a","ә" => "a'","б" => "b","в" => "v","г" => "g","ғ" => "g'","д" => "d",
            "е" => "e","ё" => "e","ж" => "j","з" => "z","и" => "i'","і" => "i",
            "й" => "i'","к" => "k","қ" => "q","һ" => "h","л" => "l","м" => "m","н" => "n","ң" => "n'",
            "о" => "o","ө" => "o'","п" => "p","р" => "r","с" => "s","т" => "t",
            "у" => "y'","ұ" => "u","ү" => "u'","ф" => "f","х" => "h","ц" => "ts","ч" => "c'",
            "ш" => "s'","щ" => "s'","ъ" => "","ы" => "y","ь" => "",
            "э" => "e","ю" => "yu","я" => "ya",
        );

        $str = strtr($text,$cyr2lat_replacements);

        return $str;
    }

    public static function getTranslatedSlugRu($text)
    {
        $cyr2lat_replacements = array (
            "А" => "a","Ә" => "a", "Б" => "b","В" => "v","Г" => "g","Ғ" => "gh","Д" => "d",
            "Е" => "e","Ё" => "yo","Ж" => "zh","З" => "z","И" => "i","І" => "i",
            "Й" => "y","К" => "k","Қ" => "q","Һ" => "q","Л" => "l","М" => "m","Н" => "n","Ң" => "nh",
            "О" => "o","Ө" => "o","П" => "p","Р" => "r","С" => "s","Т" => "t",
            "У" => "u","Ұ" => "u","Ү" => "u","Ф" => "f","Х" => "kh","Ц" => "ts","Ч" => "ch",
            "Ш" => "sh","Щ" => "csh","Ъ" => "","Ы" => "y","Ь" => "",
            "Э" => "e","Ю" => "yu","Я" => "ya","?" => "",

            "Ґ" => "g","ґ" => "g","Ї" => "i","ї" => "i","і" => "i","I" => "i","є" => "e","Є" => "e",

            "а" => "a","ә" => "a","б" => "b","в" => "v","г" => "g","ғ" => "gh","д" => "d",
            "е" => "e","ё" => "yo","ж" => "dg","з" => "z","и" => "y","і" => "i",
            "й" => "y","й" => "y","к" => "k","қ" => "q","һ" => "q","л" => "l","м" => "m","н" => "n","ң" => "nh",
            "о" => "o","ө" => "o","п" => "p","р" => "r","с" => "s","т" => "t",
            "у" => "u","ұ" => "u","ү" => "u","ф" => "f","х" => "kh","ц" => "ts","ч" => "ch",
            "ш" => "sh","щ" => "sch","ъ" => "","ы" => "y","ь" => "",
            "э" => "e","ю" => "yu","я" => "ya",
            "(" => "", ")" => "", "," => "", "." => "", ":" => "-", "'" => "",

            "-" => "-","%" => "-"," " => "-", "+" => "", "®" => "", "«" => "", "»" => "", '"' => "", "`" => "", "&" => "","/" => "-"
        );

        $str = strtr (trim($text),$cyr2lat_replacements);
        $str  = strtolower($str);
        $str  = str_replace('--',"-",$str);
        $str  = str_replace('--',"-",$str);
        $str  = str_replace('-–-',"-",$str);
        $str  = str_replace('y̆',"y",$str);
        $str =  substr($str, 0, 80);

        return $str;
    }

    public static function getTranslatedImage($text)
    {
        $cyr2lat_replacements = array (
            "А" => "a","Ә" => "a", "Б" => "b","В" => "v","Г" => "g","Ғ" => "gh","Д" => "d",
            "Е" => "e","Ё" => "yo","Ж" => "zh","З" => "z","И" => "i","І" => "i",
            "Й" => "y","К" => "k","Қ" => "q","Һ" => "q","Л" => "l","М" => "m","Н" => "n","Ң" => "nh",
            "О" => "o","Ө" => "o","П" => "p","Р" => "r","С" => "s","Т" => "t",
            "У" => "u","Ұ" => "u","Ү" => "u","Ф" => "f","Х" => "kh","Ц" => "ts","Ч" => "ch",
            "Ш" => "sh","Щ" => "csh","Ъ" => "","Ы" => "y","Ь" => "",
            "Э" => "e","Ю" => "yu","Я" => "ya","?" => "",

            "Ґ" => "g","ґ" => "g","Ї" => "i","ї" => "i","і" => "i","I" => "i","є" => "e","Є" => "e",

            "а" => "a","ә" => "a","б" => "b","в" => "v","г" => "g","ғ" => "gh","д" => "d",
            "е" => "e","ё" => "yo","ж" => "dg","з" => "z","и" => "i","і" => "i",
            "й" => "y", "й" => "y", "к" => "k","қ" => "q","һ" => "q","л" => "l","м" => "m","н" => "n","ң" => "nh",
            "о" => "o","ө" => "o","п" => "p","р" => "r","с" => "s","т" => "t",
            "у" => "u","ұ" => "u","ү" => "u","ф" => "f","х" => "kh","ц" => "ts","ч" => "ch",
            "ш" => "sh","щ" => "sch","ъ" => "","ы" => "y","ь" => "",
            "э" => "e","ю" => "yu","я" => "ya",
            "(" => "", ")" => "", "," => "", ":" => "-", "'" => "",

            "-" => "-","%" => "-"," " => "-", "+" => "", "®" => "", "«" => "", "»" => "", '"' => "", "`" => "", "&" => "","/" => "-"
        );

        $str = strtr (trim($text),$cyr2lat_replacements);
        $str  = strtolower($str);
        $str  = str_replace('--',"-",$str);
        $str  = str_replace('--',"-",$str);
        $str  = str_replace('-–-',"-",$str);
        $str  = str_replace('y̆',"y",$str);
        $str =  substr($str, 0, 80);

        return $str;
    }

    public static function getSessionLang(){
        $lang = App::getLocale();
        if($lang == 'kk') $lang = 'kz';
        return $lang;
    }

    public static function getIdFromUrl($url){
        $id = strstr($url,'-',true);
        return $id;
    }

    public static function send_mime_mail($name_from, // имя отправителя
                            $email_from, // email отправителя
                            $name_to, // имя получателя
                            $email_to, // email получателя
                            $data_charset, // кодировка переданных данных
                            $send_charset, // кодировка письма
                            $subject, // тема письма
                            $body // текст письма
    )
    {
        $to = Helpers::mime_header_encode($name_to, $data_charset, $send_charset)
            . ' <' . $email_to . '>';
        $from = Helpers::mime_header_encode($name_from, $data_charset, $send_charset)
            .' <' . $email_from . '>';

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= "From: $from\r\n";

        return mail($to, $subject, $body, $headers);
    }

    public static function mime_header_encode($str, $data_charset, $send_charset) {
        if($data_charset != $send_charset) {
            $str = iconv($data_charset, $send_charset, $str);
        }
        return '=?' . $send_charset . '?B?' . base64_encode($str) . '?=';
    }


    public static function replaceGetUrl($param) {
        $parsed = parse_url("http://example?" .http_build_query($_GET));
        $query = '';
        if(isset($parsed['query'])){
            $query = $parsed['query'];
        }

        parse_str($query, $new_url);
        $param = explode(',', $param);
        $new_val = '';

        foreach($param as $key => $value){
            if($key % 2 == 0){
                unset($new_url[$value]);
                $new_val = $value;
            }
            else {
                $new_url[$new_val] = $value;
            }
        }

        $string = http_build_query($new_url);
        return $string;
    }

    public static function getMonthName($number) {
        $lang = App::getLocale();

        if($lang == 'ru'){
            $monthAr = array(
                1 => array('Қаңтар', 'Қаңтар'),
                2 => array('Ақпан', 'Ақпан'),
                3 => array('Наурыз', 'Наурыз'),
                4 => array('Сәуір', 'Сәуір'),
                5 => array('Мамыр', 'Мамыр'),
                6 => array('Маусым', 'Маусым'),
                7 => array('Шілде', 'Шілде'),
                8 => array('Тамыз', 'Тамыз'),
                9 => array('Қыркүйек', 'Қыркүйек'),
                10=> array('Қазан', 'Қазан'),
                11=> array('Қараша', 'Қараша'),
                12=> array('Желтоқсан', 'Желтоқсан')
            );
        }
        else if($lang == 'kz'){
            $monthAr = array(
                1 => array('Қаңтар', 'Қаңтар'),
                2 => array('Ақпан', 'Ақпан'),
                3 => array('Наурыз', 'Наурыз'),
                4 => array('Сәуір', 'Сәуір'),
                5 => array('Мамыр', 'Мамыр'),
                6 => array('Маусым', 'Маусым'),
                7 => array('Шілде', 'Шілде'),
                8 => array('Тамыз', 'Тамыз'),
                9 => array('Қыркүйек', 'Қыркүйек'),
                10=> array('Қазан', 'Қазан'),
                11=> array('Қараша', 'Қараша'),
                12=> array('Желтоқсан', 'Желтоқсан')
            );
        }
        else {
            $monthAr = array(
                1 => array('January', 'January'),
                2 => array('February', 'February'),
                3 => array('March', 'March'),
                4 => array('April', 'April'),
                5 => array('May', 'May'),
                6 => array('June', 'June'),
                7 => array('July', 'July'),
                8 => array('August', 'August'),
                9 => array('September', 'September'),
                10=> array('October', 'October'),
                11=> array('November', 'November'),
                12=> array('December', 'December')
            );
        }
        if(!isset($monthAr[(int)$number][1])){
            return '';
        }
        return $monthAr[(int)$number][1];
    }

    public static function getPhoneFormat($phone){
        $phone = substr($phone, -10);
        $phone = '+7' .$phone;
        $phone = substr_replace($phone, '(', 2, 0);
        $phone = substr_replace($phone, ')', 6, 0);
        $phone = substr_replace($phone, '-', 10, 0);
        $phone = substr_replace($phone, '-', 13, 0);
        return $phone;
    }

    public static function getPhoneFormat2($phone){
        $format = array("(", ")", "+7", " ", "-",);
        $phone = str_replace($format, "", $phone);

        $phone = substr($phone, -10);
        $phone = '+7' .$phone;
        $phone = substr_replace($phone, '(', 2, 0);
        $phone = substr_replace($phone, ')', 6, 0);
        $phone = substr_replace($phone, '-', 10, 0);
        $phone = substr_replace($phone, '-', 13, 0);
        return $phone;
    }

    public static function getPhoneFormat4($phone){
        $phone = substr($phone, -10);
        $phone = '+7' .$phone;
        $phone = substr_replace($phone, '(', 2, 0);
        $phone = substr_replace($phone, ')', 6, 0);
        $phone = substr_replace($phone, '-', 10, 0);
        $phone = substr_replace($phone, '-', 13, 0);
        return $phone;
    }

    public static function getParamByPosition($params,$param_name) {
        $params = explode('/',$params);
        foreach($params as $key => $value){
            if($key % 2 == 0 && $value == $param_name)
                return isset($params[$key + 1])?$params[$key + 1]:'';
        }
    }


    public static function getPageText($id){
        $page = Page::find($id);
        if($page == null) return '';
        return $page['page_text_'.App::getLocale()];
    }

    public static function getPageImage($id){
        $page = Page::find($id);
        if($page == null) return '';

        return $page->page_image;
    }

    public static function getPageUrl($id){
        $page = Page::find($id);
        if($page == null) return '';
        return $page['page_url'];
    }

    public static function getPageName($id){
        $page = Page::find($id);
        if($page == null) return '';
        return $page['page_name_'.App::getLocale()];
    }

    public static function getMenuUrl($id){
        $page = Menu::find($id);
        if($page == null) return '';
        return $page['menu_url_'.App::getLocale()];
    }

    public static function getMenuName($id){
        $page = Menu::find($id);
        if($page == null) return '';
        return $page['menu_name_'.App::getLocale()];
    }

    public static function getMoneyRates(){
        $money_rate = null;

        try {
            $url = "http://www.nationalbank.kz/rss/rates_all.xml";
            $dataObj = simplexml_load_file($url);
            $json = json_encode($dataObj);
            $array = json_decode($json,TRUE);

            $money_rate = array();
            if ($dataObj){
                foreach ($array['channel']['item'] as $item){
                    if($item['title'] == 'USD'){
                        $money_rate[0]['title'] = $item['title'];
                        $money_rate[0]['description'] = $item['description'];
                    }
                    else if($item['title'] == 'EUR'){
                        $money_rate[1]['title'] = $item['title'];
                        $money_rate[1]['description'] = $item['description'];
                    }
                    else if($item['title'] == 'RUB'){
                        $money_rate[2]['title'] = $item['title'];
                        $money_rate[2]['description'] = $item['description'];
                    }
                    else if($item['title'] == 'CNY'){
                        $money_rate[3]['title'] = $item['title'];
                        $money_rate[3]['description'] = $item['description'];
                    }
                }
            }
        }
        catch(Exception $e){

        }

        return $money_rate;
    }

    public static function getHourAndMinute($minute){
        $hour = (int) ($minute / 60);
        $minute = (int) ($minute % 60);

        $str = '';
        if($hour > 0) $str .= $hour .' сағат';
        if($hour > 0 && $minute > 0) $str .= ', ';
        if($minute > 0) $str .= $minute.' минут';
        if($str == '') $str .= '1 сағат';
        return $str;
    }

    public static function setSessionLang($lang,$request){
        return;

        $locale = $request->segment(1);
        $lang_list = ['ru','kk','en'];
        $url_path = $request->fullUrl();
        if (in_array($locale, $lang_list))
        {
            $url_path = str_replace(URL('/').'/'.$locale,URL('/'),$url_path);
        }
        $lang = str_replace(URL('/'),URL('/').'/'.$lang,$url_path);
        return $lang;
    }

    public static function getCurrentDay(){
        $timestamp = strtotime(date("Y-m-d"));
        $day = date("d", $timestamp);
        $month = date("m", $timestamp);
        return $day .' '.Helpers::getMonthName($month);
    }

    public static function getDateFormat($date_param){
        $current = strtotime(date("Y-m-d"));
        $date    = strtotime($date_param);
        $datediff = $date - $current;
        $difference = floor($datediff/(60*60*24));

        $timestamp = strtotime($date_param);
        $time_format = date("H:i", $timestamp);
        $date_format = date("d.m.Y", $timestamp);


        if($difference==0)
            return 'Сегодня, '.$time_format;
        else if($difference < -1){
            $month = date("m", $timestamp);
            $day = date("d", $timestamp);
            $year = date("Y", $timestamp);
            return $day .'.'.$month.'.'.$year.' '.$time_format;
        }
        else
            return "Вчера";
    }

    public static function getDateFormat3($date_param){
        $current = strtotime(date("Y-m-d"));
        $date    = strtotime($date_param);
        $datediff = $date - $current;
        $difference = floor($datediff/(60*60*24));

        $timestamp = strtotime($date_param);
        $time_format = date("H:i", $timestamp);
        $date_format = date("d.m.Y", $timestamp);

        $month = date("m", $timestamp);
        $day = date("d", $timestamp);
        $year = date("Y", $timestamp);
        return $day .' '.Helpers::getMonthName($month).', '.$year;

    }

    public static function getDateFormat2($date_param){
        $current = strtotime(date("Y-m-d"));
        $date    = strtotime($date_param);
        $datediff = $date - $current;
        $difference = floor($datediff/(60*60*24));

        $timestamp = strtotime($date_param);
        $time_format = date("H:i", $timestamp);
        $date_format = date("d.m.Y", $timestamp);


        $month = date("m", $timestamp);
        $day = date("d", $timestamp);
        $year = date("Y", $timestamp);
        return $day .' '.Helpers::getMonthName($month);
    }

    public static function getDateFormat4($date_param){
        if($date_param == '') return '-';

        $current = strtotime(date("Y-m-d"));
        $date    = strtotime($date_param);
        $datediff = $date - $current;
        $difference = floor($datediff/(60*60*24));

        $timestamp = strtotime($date_param);
        $time_format = date("H:i", $timestamp);
        $date_format = date("d.m.Y", $timestamp);


        $month = date("m", $timestamp);
        $day = date("d", $timestamp);
        $year = date("Y", $timestamp);
        return $day .'.'.$month.'.'.$year.', '.$time_format;
    }

    public static function getWhether($region_id){
        $whether = null;

        try {
            $url = "https://export.yandex.ru/bar/reginfo.xml?region=".$region_id;
            $dataObj = simplexml_load_file($url);
            $json = json_encode($dataObj);
            $array = json_decode($json,TRUE);


            if(isset($array['weather']['day']['day_part'][0])){
                if(isset($array['weather']['day']['day_part'][0]['temperature_to']))
                $whether['temperature'] = $array['weather']['day']['day_part'][0]['temperature_to'];
                elseif(isset($array['weather']['day']['day_part'][0]['temperature']))
                $whether['temperature'] = $array['weather']['day']['day_part'][0]['temperature'];
                if(isset($array['weather']['day']['day_part'][0]['image-v2']))
                $whether['image'] = $array['weather']['day']['day_part'][0]['image-v2'];
            }
        }
        catch(Exception $e){

        }

        return $whether;
    }

    public static function getInfoText($id){

        $page = Cache::remember('info_by_id_'.$id, 1440, function () use ($id) {
            return Info::where('info_id',$id)->first();
        });

        if($page == null) return '';
        $locale = App::getLocale();
        if($locale == 'kk') $locale = 'kz';
        return $page['info_text_'.$locale];
    }

    public static function getStatusName($id){
        $page = Cache::remember('status_by_id_'.$id, 1440, function () use ($id) {
            return Status::where('status_id',$id)->first();
        });

        if($page == null) return '';
        $locale = App::getLocale();
        if($locale == 'kk') $locale = 'kz';
        return $page['status_name_'.$locale];
    }

    public static function getInfoImage($id){
        $page = Cache::remember('info_by_id_'.$id, 1440, function () use ($id) {
            return Info::where('info_id',$id)->first();
        });

        if($page == null) return '';
        return $page['info_image'];
    }

    public static function getInfoName($id){
        $page = Cache::remember('info_by_id_'.$id, 1440, function () use ($id) {
            return Info::where('info_id',$id)->first();
        });

        if($page == null) return '';
        $locale = App::getLocale();
        return $page['info_name_'.$locale];
    }

    public static function getUserId(){
        $user_id = 0;
        if (Auth::check()) {
            $user_id = Auth::user()->user_id;
        }
        return $user_id;
    }

    public static function changePhoneFormat($phone){
        $format = array("(", ")", "+7", " ", "-",);
        $phone = str_replace($format, "", $phone);
        $phone = substr($phone, -10);
        if($phone != '') return $phone;
        return '';
    }

    public static function checkFinishedLesson($lesson_id,$user_id){
        $check_test = Operation::where('lesson_id',$lesson_id)->where('user_id',$user_id)->where('operation_type_id',9)->where('is_active',1)->first();
        $check_task = Operation::where('lesson_id',$lesson_id)->where('user_id',$user_id)->where('operation_type_id',11)->where('is_active',1)->first();

        if($check_task != null && $check_test != null){
            $user_action = UserAction::where('lesson_id',$lesson_id)->where('user_id',$user_id)->first();
            if($user_action == null){
                $user_action = new UserAction();
                $user_action->user_id = $user_id;
                $user_action->lesson_id = $lesson_id;
                $user_action->aiplus = $check_test->aiplus + $check_task->aiplus;
                $user_action->save();
            }
        }
    }

    public static function getTopUser(){
        $user = Cache::remember('top_user_', 1440, function ()  {
            return Users::where('is_ban',0)
                    ->where('role_id',3)
                    ->where('is_schoolchild',1)
                    ->orderBy('aiplus','desc')
                    ->select(
                             'name',
                             'avatar',
                             'aiplus'
                            )
                    ->first();
        });

        return $user;
    }

    public static function setInfoText(){
        return;

        $test_question_count = Question::where('is_show',1)->count();
        Info::where('info_id',37)->update(['info_text_ru' => $test_question_count]);

        $subject_count = Subject::where('is_show',1)->count();
        Info::where('info_id',27)->update(['info_text_ru' => $subject_count]);

        $subject_month_count = Subject::where('is_show',1)->where('created_at','>=',date("Y-m-d 00:00", strtotime('-30 day')))->count();
        Info::where('info_id',33)->update(['info_text_ru' => $subject_month_count]);


        $student_count = Users::where('role_id',3)->count();
        Info::where('info_id',30)->update(['info_text_ru' => $student_count]);

        $student_month_count = Users::where('role_id',3)->where('created_at','>=',date("Y-m-d 00:00", strtotime('-30 day')))->count();
        Info::where('info_id',35)->update(['info_text_ru' => $student_month_count]);


        $lesson_count = Lesson::where('is_show',1)->count();
        Info::where('info_id',29)->update(['info_text_ru' => $lesson_count]);


        $lesson_video_count = Lesson::where('lesson_video','!=','')->where('is_show',1)->count();
        Info::where('info_id',28)->update(['info_text_ru' => $lesson_video_count]);

        $lesson_video_month_count = Lesson::where('lesson_video','!=','')->where('lesson_video','!=','')->where('is_show',1)->count();
        Info::where('info_id',36)->update(['info_text_ru' => $lesson_video_month_count]);
    }

    public static function getRegionsByUser($user_id){
        $region_ids = UserRegion::where('user_id',$user_id)->select('region_id')->get();
        $ids = array();
        foreach($region_ids as $item) {
            $ids[] = $item['region_id'];

            $child_regions = Region::where('parent_id',$item->region_id)->select('region_id')->get();
            foreach($child_regions as $child_item) {
                $ids[] = $child_item['region_id'];
            }
        }

        if(!isset($ids[0]))
            $ids[] = 0;

        return $ids;
    }

    public static function updateStudentCount(){
        $student_count = Users::where('role_id',3)->count();
        Info::where('info_id',30)->update(['info_text_ru' => $student_count]);

        $student_month_count = Users::where('role_id',3)->where('created_at','>=',date("Y-m-d 00:00", strtotime('-30 day')))->count();
        Info::where('info_id',35)->update(['info_text_ru' => $student_month_count]);

        Cache::forget('info_by_id_30');
        Cache::forget('info_by_id_35');
    }

    public static function getConfigureValue($id){
        $configure = Cache::remember('configure_id_'.$id, 1440, function () use ($id) {
            return Configure::find($id);
        });

        if($configure == null) return 1;

        return $configure['configure_value'];
    }



    public static function getViewHtml($view,$data){
        return view($view,['param' => $data]);
    }

    public static function getSubscriptionStatus($subject_id){
        if(!Auth::check()){
            $result['error'] = '';
            $result['status'] = false;
            return $result;
        }

        /*if(Auth::user()->role_id == 1){
            $result['subject_id'] = $subject_id;
            $result['status'] = true;
            return $result;
        }*/

        $subscription = Subscription::where('user_id',Auth::user()->user_id)
            ->where('subject_id',$subject_id)
            ->orderBy('subscription_date','desc')
            ->select(
                'subscription_date',
                'subscription_date_start',
                'subject_id'
            )
            ->first();

        if($subscription == null){
            $result['error'] = "Чтобы посмотреть урок, Вам следует купить подписку";
            $result['status'] = false;
            return $result;
        }
        /*elseif(strtotime($subscription->subscription_date) < strtotime(date("Y-m-d"))){

            $result['error'] = "Срок действия подписки истек";
            $result['status'] = false;
            return $result;
        }
        elseif(strtotime($subscription->subscription_date_start) > strtotime(date("Y-m-d"))){
            $result['error'] = "Дата начала подписки еще не началась";
            $result['status'] = false;
            return $result;
        }*/

        $result['subject_id'] = $subscription->subject_id;
        $result['status'] = true;
        return $result;
    }



}

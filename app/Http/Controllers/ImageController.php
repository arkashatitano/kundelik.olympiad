<?php

namespace App\Http\Controllers;

use App\Models\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers;
use Auth;

use Illuminate\Support\Facades\Response;
use Image;
use View;
use URL;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class ImageController extends Controller
{
    public function getImage(Request $request, $fileName)
    {
        $path = storage_path('app/image/'). $fileName;

        $first_path = $path;

        if(!File::exists($path)){
            $path = storage_path('app/image/') .'default.jpg';
        }

        $second_path = strrev($path);
        $image_name = strstr($second_path,'/',true);
        $full_path = strstr(strrev($second_path),strrev($image_name),true);
        $image_name = strrev($image_name);

        $original_image = 'original_'.$image_name;
        $original_path = $full_path .$original_image;

        if(!File::exists($original_path)) {
            $image = Image::make($path);
            $image->save($original_path);
        }

        if(isset($request->height) && isset($request->width)){
            $image_name_resize = $request->height .'x'.$request->width .'_'.$image_name;
            $path_resize = $full_path .$image_name_resize;

            if((!File::exists($path_resize) && File::exists($original_path)) || isset($request->x)) {
                $image = Image::make($original_path);

                $image_width = $image->width();
                $image_height = $image->height();

                $v = min($image_width / $request->width, $image_height / $request->height);

                $needle_width = floor($v * $request->width);
                $needle_height = floor($v * $request->height);

                if(isset($request->x) & isset($request->y)) {
                    $original_image = $image_name;
                    $original_path = $full_path .$original_image;

                    if(!File::exists($original_path)) {
                        $image = Image::make($path);
                        $image->save($original_path);
                    }

                    $image->crop($request->width, $request->height, $request->x, $request->y)
                        ->resize($request->width, $request->height)
                        ->save($original_path);
                }
                else {
                    $image->crop($needle_width, $needle_height)
                        ->resize($request->width, $request->height)
                        ->save($path_resize);
                }

            }
            $image_name = $image_name_resize;
            $path = $path_resize;
        }

        if(!File::exists($path)){
            $path = $first_path;
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);

        $lifetime = 10000000;

        $filetime = filemtime($path);
        $etag = md5($filetime . $path);
        $time = gmdate('r', $filetime);
        $expires = gmdate('r', $filetime + $lifetime);

        $headers['Content-Type'] = $type;
        $headers['Content-Disposition'] = 'inline; filename="' . $fileName . '"';
        $headers['Last-Modified'] = $time;
        $headers['Cache-Control'] = 'must-revalidate';
        $headers['Expires'] = $expires;
        $headers['Pragma'] = 'public';
        $headers['Etag'] = $etag;

        return $response->withHeaders($headers);
    }

    public function uploadImage(Request $request){
        $file = $request->image;
        $file_name = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        if(substr($file->getClientMimeType(), 0, 5) != 'image') {
            $result['error'] = 'Загружайте только файлы форматов JPEG, PNG';
            $result['success'] = false;
            return $result;
        }
        /*else if($file->size() > 2097152){
            $result['error'] = 'Максимальный размер загружаемого файла ~ 2 МБ';
            $result['success'] = false;
            return $result;
        }*/
        $destinationPath = $request->disk. '/'.date('Y').'/'.date('m').'/'.date('d');

        $file_name = $destinationPath .'/' .\App\Http\Helpers::getTranslatedImage($file_name);

        if(Storage::disk('image')->exists($file_name)){
            $now = \DateTime::createFromFormat('U.u', microtime(true));
            $file_name = $destinationPath .'/' .$now->format("Hisu").'.'.$extension;
        }

        Storage::disk('image')->put($file_name,  File::get($file));
        $result['success'] = true;
        $result['file_name'] = '/media' .$file_name;
        return $result;
    }

    public function uploadFile(Request $request){
        $file = $request->image;
        $file_name = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        if($file->getClientSize() > 20097152){
            $result['error'] = 'Максимальный размер загружаемого файла ~ 20 МБ';
            $result['success'] = false;
            return $result;
        }

        $destinationPath = $request->disk. '/'.date('Y').'/'.date('m').'/'.date('d');

        $file_name = $destinationPath .'/' .\App\Http\Helpers::getTranslatedImage($file_name);

        if(Storage::disk('image')->exists($file_name)){
            $now = \DateTime::createFromFormat('U.u', microtime(true));
            $file_name = $destinationPath .'/' .$now->format("Hisu").'.'.$extension;
        }

        Storage::disk('image')->put($file_name,  File::get($file));

        $result['status'] = true;
        $result['file_url'] = '/file' .$file_name;
        $result['file_name'] = $file->getClientOriginalName();
        $result['file_size'] = round($file->getClientSize() / 1024 / 1024,1);

        return $result;
    }

    public function showFile($url){
        $path = storage_path('app/image/' . $url);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
}

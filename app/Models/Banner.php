<?php

namespace App\Models;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Banner extends Model
{
    protected $table = 'banner';
    protected $primaryKey = 'banner_id';

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}

<?php

namespace App\Models;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Illuminate\Support\Facades\Cache;

class Section extends Model
{
    protected $table = 'section';
    protected $primaryKey = 'section_id';

    use SoftDeletes;
    protected $dates = ['deleted_at'];


}

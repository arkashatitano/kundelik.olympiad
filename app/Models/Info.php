<?php

namespace App\Models;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Info extends Model
{
    protected $table = 'info';
    protected $primaryKey = 'info_id';

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}

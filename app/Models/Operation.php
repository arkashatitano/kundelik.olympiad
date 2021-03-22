<?php

namespace App\Models;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Operation extends Model
{
    protected $table = 'operation';
    protected $primaryKey = 'operation_id';

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}

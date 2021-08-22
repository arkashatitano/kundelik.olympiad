<?php

namespace App\Models;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Certificate extends Model
{
    protected $table = 'certificate';
    protected $primaryKey = 'certificate_id';

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}

<?php

namespace App\Models;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class OlympiadTest extends Model
{
    protected $table = 'olympiad_test';
    protected $primaryKey = 'olympiad_test_id';

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}

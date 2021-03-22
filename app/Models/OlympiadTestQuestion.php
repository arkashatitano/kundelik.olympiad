<?php

namespace App\Models;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class OlympiadTestQuestion extends Model
{
    protected $table = 'olympiad_test_question';
    protected $primaryKey = 'olympiad_test_question_id';

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}

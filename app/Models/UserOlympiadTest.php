<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserOlympiadTest extends Model
{
    protected $table = 'user_olympiad_test';
    protected $primaryKey = 'user_olympiad_test_id';

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}

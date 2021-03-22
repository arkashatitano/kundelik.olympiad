<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRequest extends Model
{
    protected $table = 'user_request';
    protected $primaryKey = 'user_request_id';

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}

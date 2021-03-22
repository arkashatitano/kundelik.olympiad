<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class Users extends Model implements  AuthenticatableContract
{
    use Authenticatable;

    protected $primaryKey = 'user_id';
    protected $fillable = ['email','password'];

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}

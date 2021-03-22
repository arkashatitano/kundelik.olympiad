<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;


abstract class BasicModel extends Model
{

    /**
     * @return \Illuminate\Database\Eloquent\Builder|$this|Builder
     */
    public static function query()
    {
        return parent::query(); 
    }


}
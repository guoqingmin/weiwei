<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $table = 'wei_goods';
    public $timestamps =false;
    protected  $primaryKey='goods_id';
}

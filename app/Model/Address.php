<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //
    protected $table = 'wei_address';
    public $timestamps =false;
    protected  $primaryKey='address_id';
}

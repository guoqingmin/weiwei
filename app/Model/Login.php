<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    protected $table = 'wei_email';
    public $timestamps =false;
    protected  $primaryKey='email_id';
}

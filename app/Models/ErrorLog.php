<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{

    public $table = 'ams_errorlog';
    public $incrementing = true;
    public $timestamps = false;
    protected $primaryKey ='log_no';

}
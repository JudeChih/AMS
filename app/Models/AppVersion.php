<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppVersion extends Model
{

    public $table = 'ams_appversion';
    public $incrementing = true;
    public $timestamps = false;
    protected $primaryKey ='ver_id';

}
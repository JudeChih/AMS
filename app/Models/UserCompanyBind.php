<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCompanyBind extends Model
{

    public $table = 'ams_usercompanybind';
    public $incrementing = true;
    public $timestamps = false;
    protected $primaryKey ='uc_id';

}
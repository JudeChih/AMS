<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SunwaiUserCompanyBind extends Model
{

    public $table = 'ams_sunwaiusercompanybind';
    public $incrementing = true;
    public $timestamps = false;
    protected $primaryKey ='uc_id';

}
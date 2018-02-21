<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SunwaiUserAuthority extends Model
{

    public $table = 'ams_sunwaiuserauthority';
    public $incrementing = true;
    public $timestamps = false;
    protected $primaryKey ='ua_id';

}
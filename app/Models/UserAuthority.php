<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAuthority extends Model
{

    public $table = 'ams_userauthority';
    public $incrementing = true;
    public $timestamps = false;
    protected $primaryKey ='ua_id';
}
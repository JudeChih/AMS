<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SunwaiTask extends Model
{

    public $table = 'ams_sunwaitask';
    public $incrementing = true;
    public $timestamps = false;
    protected $primaryKey ='task_id';

}
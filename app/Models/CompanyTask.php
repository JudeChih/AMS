<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyTask extends Model
{

    public $table = 'ams_companytask';
    public $incrementing = true;
    public $timestamps = false;
    protected $primaryKey ='task_id';

}
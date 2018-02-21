<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apiiolog extends Model
{

    public $table = 'ams_apiiolog';
    public $incrementing = true;
    public $timestamps = false;
    protected $primaryKey ='log_no';

}
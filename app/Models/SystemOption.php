<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemOption extends Model
{

    public $table = 'ams_systemoption';
    public $incrementing = true;
    public $timestamps = false;
    protected $primaryKey ='option_id';

}
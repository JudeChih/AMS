<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoftwareList extends Model
{

    public $table = 'ams_softwarelist';
    public $incrementing = true;
    public $timestamps = false;
    protected $primaryKey ='soft_id';

}
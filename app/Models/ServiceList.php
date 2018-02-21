<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceList extends Model
{

    public $table = 'ams_servicelist';
    public $incrementing = true;
    public $timestamps = false;
    protected $primaryKey ='service_id';

}
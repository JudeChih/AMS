<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pnpentity extends Model
{

    public $table = 'ams_pnpentity';
    public $incrementing = true;
    public $timestamps = false;
    protected $primaryKey ='pnp_id';

}
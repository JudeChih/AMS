<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hosttask extends Model
{

    public $table = 'hosttask';
    public $incrementing = true;
    public $timestamps = false;
    protected $primaryKey ='task_id';

}
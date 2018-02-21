<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServerTask extends Model
{

    public $table = 'servertask';
    public $incrementing = true;
    public $timestamps = false;
    protected $primaryKey ='task_id';

}
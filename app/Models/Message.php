<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    public $table = 'ams_message';
    public $incrementing = true;
    public $timestamps = false;
    protected $primaryKey ='msg_no';

}
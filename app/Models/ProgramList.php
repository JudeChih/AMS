<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramList extends Model
{

    public $table = 'ams_programlist';
    public $incrementing = true;
    public $timestamps = false;
    protected $primaryKey ='program_id';

}
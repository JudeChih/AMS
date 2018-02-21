<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileList extends Model
{

    public $table = 'ams_filelist';
    public $incrementing = true;
    public $timestamps = false;
    protected $primaryKey ='file_id';

}
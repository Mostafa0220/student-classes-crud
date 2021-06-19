<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'classes';
    protected $fillable = ['code', 'name', 'maximum_students', 'description','status'];
}

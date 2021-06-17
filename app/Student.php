<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table 	= 'students';
    protected $fillable = ['first_name', 'last_name', 'date_of_birth', 'class_id'];
}
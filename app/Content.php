<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [ ];

    protected $table = 'contents';
    

    public $timestamps = true;
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
   
	
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoachPitch extends Model
{
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	*/
	protected $fillable = ['coach_id','pitch_id','postcode','pitch_name','location','latitude','longitude','status'];
}

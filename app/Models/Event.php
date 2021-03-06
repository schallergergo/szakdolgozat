<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
	use HasFactory;
	protected $guarded =[];
	public function result(){
    	return $this->hasMany(Result::class);
   }
   public function program(){
    	return $this->belongsTo(Program::class);
   }
   
}

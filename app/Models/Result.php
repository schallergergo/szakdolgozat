<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;
    protected $guarded =[];
     public function event(){
    	return $this->belongsTo(Event::class);
    	
   }
   public function user(){
        return $this->belongsTo(User::class,'rider_id','username');
    }
   public function program(){
    	return $this->belongsTo(Program::class);
    }
    public function resultlog(){
    	return $this->hasMany(Resultlog::class);
    }
}

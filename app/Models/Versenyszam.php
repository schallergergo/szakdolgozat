<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Versenyszam extends Model
{
    use HasFactory;
        public function result(){
    	return $this->hasMany(Result::class);
   }
   public function program(){
    	return $this->belongsTo(Program::class);
   }
}

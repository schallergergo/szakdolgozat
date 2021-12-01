<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;
      protected $fillable = [

    ];

    public function block(){
    	return $this->hasMany(Block::class);
    }

    public function event(){
    	return $this->hasMany(Event::class);
    }
    public function result(){
    	return $this->hasMany(Result::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resultlog extends Model
{
    use HasFactory;
    protected $guarded =[];

     public function result(){
    	return $this->belongsTo(Result::class);
    }
}

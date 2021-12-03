<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;
    protected $guarded =[];
    public function program(){
    	return $this->belongsTo(Program::class);
    }
}

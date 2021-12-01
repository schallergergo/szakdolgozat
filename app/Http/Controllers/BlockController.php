<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Block;
use App\Models\Program;



class BlockController extends Controller
{
     public function __construct()
    {
        $this->authorizeResource(Block::class);
    }

    public function show(Program $program){
    	
    	$blocks=$program->block->where("programpart",1);
    	$collectivemarks=$program->block->where("programpart",2);
    	return view('program.show',[
    		"program"=>$program,
    		"blocks"=>$blocks,
    		"collectivemarks"=>$collectivemarks
    	]);
    }
    
    public function create(Program $program){
    	
    	$ordinal=count($program->block)+1;

    	return view('block.create',['program'=>$program,'ordinal'=>$ordinal]);
    }

    
    public function store(Program $program){

        $data = request();

        //validation rules

        $data=$data->validate([
            
            'ordinal' => ['required', 'integer'],
            'programpart' => ['required', 'integer'],
            'letters'=> ['required','string'],
            'criteria'=> ['required','string'],
            'maxmark' => ['required', 'integer'],
            'coefficient' => ['required', 'integer'],
            ]);


        


        $block=\App\Models\Block::create([
        	'program_id'=>$program->id,
            'ordinal' => $data['ordinal'],
            'programpart' => $data['programpart'],
            'letters'=> $data['letters'],
            'criteria'=> $data['criteria'],
            'maxmark' => $data['maxmark'],
            'coefficient' => $data['coefficient'],
        ]);

    	
    	return redirect("/block/create/{$program->id}");
    }


}

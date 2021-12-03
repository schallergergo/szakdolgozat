<?php

namespace App\Http\Controllers;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{
	 public function __construct()
    {
        $this->authorizeResource(Program::class);
    }

    //show all programs
    public function index(){
        $programs=Program::all();

        return view("program.index",["programs"=>$programs]);
    }

    //show a specific program
    public function show(Program $program){
    	
    	$blocks=$program->block->where("programpart",1);
    	$collectivemarks=$program->block->where("programpart",2);
    	return view('program.show',[
    		"program"=>$program,
    		"blocks"=>$blocks,
    		"collectivemarks"=>$collectivemarks
    	]);
    }
    
    //return the view to create a program
    public function create(){
    	
    	
    	return view('program.create');
    }

    //stores the new program
    public function store(){

        $data = request();

        //validation rules

        $data=$data->validate([
            'descipline' => ['required', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'numofblocks' => ['required', 'integer'],
            'maxMark' => ['required', 'integer'],
            'typeofevent' => ['required', 'string', 'max:255'],
            'doublesided' => ['required', 'boolean'],
            ]);


        


        $program=\App\Models\Program::create([
             'descipline' => $data['descipline'],
            'name' => $data['name'],
            'numofblocks' => $data['numofblocks'],
            'maxMark' => $data['maxMark'],
            'typeofevent' => $data['typeofevent'],
            'doublesided' => $data['doublesided'],
        ]);

    	
    	return redirect("/block/create/{$program->id}");
    }

    //returns the view to edit a program
    public function edit(Program $program){
        return view("program.edit",["program"=>$program]);
    }

    //updates a given program
    public function update(Program $program)
    {

        $data = request();
        $data=$data->validate([
            'name' => ['required', 'string', 'max:255'],
            'numofblocks' => ['required', 'integer'],
            'maxMark' => ['required', 'integer'],
            'typeofevent' => ['required', 'string', 'max:255'],
            'doublesided' => ['required', 'boolean'],
            ]);

        $program->update($data);
        return redirect("program/index");
    }
}

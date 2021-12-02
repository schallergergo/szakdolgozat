<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
         public function __construct()
    {
        $this->authorizeResource(Result::class);
    }

    //Shows a given result based on its id
    public function show(Result $result){

        $assassment=json_decode($result["assassment"]);

        //first part of the program, with the moves to be executed
        $blocks=$result->event->program->block->where("programpart",1); 

        //second part, with the criteria for the collective marks
        $collectivemarks=$result->event->program->block->where("programpart",2); 

        //errors made by the rider, aka deductions
        $error=$result->error; 

        // bool: is the rider eliminated?
        $eliminated=$result->eliminated; 



        return view("result.show",[ "result"=>$result, 
                                    "blocks"=>$blocks,
                                    "collectivemarks"=>$collectivemarks,
                                    "assassment"=>$assassment,
                                    "error"=>$error,
                                    "eliminated"=>$eliminated,
                                ]);
    }

    //creating an empty result for a new rider, based on the event_id
    public function create(Event $event){

        //id is generated randomly, !not sequential 
        $id=$this->generateID();

        $event_id=$event->id;

    	return view("result.create",["id"=> $id,"event_id"=>$event_id]);
    }
    //editing a result, this is method is used both for the first edit, and for the edits afterwards
    public function edit(Result $result){

        //first part of the program, with the moves to be executed
        $blocks=$result->event->program->block->where("programpart",1);

        //second part, with the criteria for the collective marks
        $collectivemarks=$result->event->program->block->where("programpart",2);

        //json: the remarks and points given by the judge, blank values, if it has not been  completed
        $assassment=json_decode($result->assassment);

        //errors made by the rider, aka deductions
        $error=$result->error;

        // bool: is the rider eliminated?
        $eliminated=$result->eliminated;

        return view("result.edit",[ "result"=>$result,
                                    "blocks"=>$blocks,
                                    "collectivemarks"=>$collectivemarks,
                                    "assassment"=>$assassment,
                                    "error"=>$error,
                                    "eliminated"=>$eliminated,
                                ]);
    }

    //result log: logs every modification, for every result, triggered by the update function
    public function ResultLog($result_id,$mark,$assassment){
        \App\Models\Resultlog::create([
            'result_id' => $result_id,
            'mark'=>$mark,
            'assassment'=>$assassment,
            'user'=>Auth::User()->name,

        ]);
    }

    // stores the empty result in the database
    public function store()
    {$data = request();

        //validation rules
    	$data=$data->validate([
            'id' => [],
            'event_id'=>['integer'],
    		'rider_id' => ['required', 'string', 'max:6'],
            'rider_name' => ['required', 'string', 'max:255'],
            'horse_id' => ['required', 'string', 'max:6'],
            'horse_name' => ['required', 'string', 'max:255'],
            'club' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string',  'max:255'],
			]);

        //number of blocks for a given program, 
        $numOfBlocks=Event::find($data['event_id'])->program->numofblocks;

        //the id of the given event
        $event_id=$data['event_id'];

        \App\Models\Result::create([
        	'id' => $data['id'],
 			'event_id' => $data['event_id'],
 			'rider_id'=> $data['rider_id'],
 			'rider_name'=> $data['rider_name'],
            'assassment'=>$this->generateEmptyJson($numOfBlocks),
 			'horse_id'=> $data['horse_id'],
 			'horse_name'=> $data['horse_name'],
 			'club' => $data['club'],
 			'category' => $data['category'],
        ]);
        return redirect("result/create/{$event_id}");
    }


    public function updateResult(Result $result)
    {
        $this->authorize('update', $result);
        // POST data
        $data = request();

        $resultID=$result->id;

        //array for the marks and remarks given by the judge
        $array=[];

        for($i=0;$i<count($data['mark']);$i++)
        {
                //given mark
                $mark=$data['mark'][$i];

                //remark: if null replaced with an empty string
                $remark=$data['remark'][$i]==null?"":$data['remark'][$i];

                //adding it to the array
                $array[]=['mark'=>$mark,'remark'=>$remark];
        }

        // if the rider is eliminated, set the mark to zero
        if ($data["eliminated"]==1) $mark = 0;

        //calcalate the result
        else $mark = $this->mark($result,$array,$data["error"]);

        //calculate the percentage
        $percent  = $this->percent($result,$mark);

        //calculcate, the collective marks, the second part of the program, used to break up ties
        $collectivemark=$this->collectiveMarkPoint($result,$array,$data["error"]);

        //encoding the marks and remarks to json
        $assassment = json_encode($array);

        //is the rider eliminated, 3 errors or for some other reason
        $eliminated = isset($data["eliminated"]) || $data["error"]==-1 ? 1 : 0;

        $dataOut=[  
                    "assassment"=>$assassment,
                    "completed"=>1,
                    "mark"=>$mark,
                    "percent"=>$percent,
                    "collectivemark"=>$collectivemark,
                    "eliminated"=>$eliminated,
                    "error"=>$data["error"],
                ];

        //creating a log record
        $this->ResultLog($resultID,$mark,$assassment);

        //updating the result record
        $result->update($dataOut);
        return redirect("result/show/{$resultID}");
        
    }
    public function editInfo (Result $result){
        $this->authorize('update', $result);
        return view("result.updateInfo",
            [
                "result_id"=>$result->id,
                "rider_id"=>$result->rider_id,
                "rider_name"=>$result->rider_name,
                "horse_id"=>$result->horse_id,
                "horse_name"=>$result->horse_name,
                "club"=>$result->club,
                "category"=>$result->category,
            ]);
    }

    public function updateInfo(Result $result){
        $this->authorize('update', $result);
        $data = request();
        $resultID=$result->id;;
        $dataOut=$data->validate([
            'id' => [],
            'event_id'=>['integer'],
            'rider_id' => ['required', 'string', 'max:6'],
            'rider_name' => ['required', 'string', 'max:255'],
            'horse_id' => ['required', 'string', 'max:6'],
            'horse_name' => ['required', 'string', 'max:255'],
            'club' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string',  'max:255'],
            ]);

              
        $result->update($dataOut);
        return redirect("/");
        
    }
       private function generateID(){

        //lower limit of the id
        $limit = 100000000000000000;

        //generating a random id
        $id = rand($limit,$limit*10);

        //checking if a record already exisits with the given id
        $result = Result::find($id);

        // iterating the last two steps until id is found
        while ($result!==null){
            $id = rand($limit,$limit*10);
            $result = Result::find($id);
        }

        return $id;
    }

    //calculating the result


    //generating an empty assassment json based on the number of blocks
    private function generateEmptyJson(int $numOfBlocks){
        $outputArray=array();
        for ($i=0;$i<$numOfBlocks;$i++){
            $temp=['mark'=>"",'remark'=>""];
            $outputArray[]=$temp;
        }
        return json_encode($outputArray);
    }

    //calculating the final point based on the given marks and errors
    private function mark(Result $result, array $markArray, int $error){
        //-1 means elimination: return 0
        if ($error==-1) return 0;
        $points=0;

        //the blocks of the program, contains the multiplication coefficient
        $blocks=$result->event->program->block;

        //sanity check: is the number of marks and block equal?
        if (count($blocks)!=count($markArray)) return 0;

        //calculating the result based on the mark given and the coefficient
        for ($i=0;$i<count($blocks);$i++){
            $points+=$markArray[$i]["mark"]*$blocks[$i]->coefficient;
        }

        return $points-$error;
    }

    //calculate the achived percentage 
    private function percent(Result $result, int $point){
        $total=0;
        $maxMark=$result->event->program->maxMark;
        
        return $point*100.0/$maxMark;
    }

    //calculating the collective marks
    private function collectiveMarkPoint(Result $result, array $pointArray, int $error){
        //-1 means elimination: return 0
    	if ($error==-1) return 0;

        $point=0;

        //the blocks of only the second part, contains the ordinal of the given block
        $blocks=$result->event->program->block->where("programpart","2");
        
        foreach ($blocks as $block){
            //the ordinal of the approriate block ZERO INDEX!
        	$ordinal=$block["ordinal"]-1;
        	$point+=$pointArray[$ordinal]["mark"]*$block["coefficient"];
        }
    
        return $point;
    }
}



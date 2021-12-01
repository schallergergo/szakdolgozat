<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Program;
use App\Models\Result;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class EventController extends Controller
{

        public function __construct()
    {
        $this->authorizeResource(Event::class);
    }

    public function show(Event $event){

    //riders in the event with no results
    $toStart=$event->result->where("completed",0)->sortBy("updated_at");

    //riders in the event with completed results
    $started=$event->result->where("completed",1)->sortByDesc("updated_at");

	return view("/event/show",  ["event"=>$event,
								 "started"=>$started,
								 "toStart"=>$toStart,
								]);
    }


    public function create(){
        $programs=Program::all()->where("active",1);
        $pencilers=User::all()->where("role","penciler");
        return view("/event/create",["programs"=>$programs,
                                    "pencilers"=>$pencilers,
                                ]);
    } public function edit(Event $event){
        $programs=Program::all()->where("active",1);
        $pencilers=User::all()->where("role","penciler");
        return view("/event/edit",["programs"=>$programs,
                                    "pencilers"=>$pencilers,
                                    "event"=>$event
                                ]);
    }
    public function store()
    {$data = request();

        //validation rules
        $data=$data->validate([
            'competitionname' => ['required', 'string', 'max:255'],
            'venue' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'eventname' => ['required', 'string', 'max:255'],
            'program_id' => ['required', 'integer', 'min:0'],
            'penciler' => ['required', 'integer', 'min:0'],
            'judge' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255']
            ]);

        //number of blocks for a given program, 
        $office=Auth::User()->id;

        //the id of the given event

        $newEvent=\App\Models\Event::create([
            'competitionname' => $data["competitionname"],
            'venue' => $data["venue"],
            'date' => $data["date"],
            'eventname' => $data["eventname"],
            'program_id' => $data["program_id"],
            'office' => $office,
            'penciler' => $data["penciler"],
            'judge' => $data["judge"],
            'position' => $data["position"]
        ]);

        return redirect("event/edit/{$newEvent->id}");
    }
  
    public function update(Event $event)
    {
        $this->authorize('update', $event);
        $data = request();
        $data=$data->validate([
            'competitionname' => ['required', 'string', 'max:255'],
            'venue' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'eventname' => ['required', 'string', 'max:255'],
            'penciler' => ['required', 'integer', 'min:0'],
            'judge' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255']
            ]);

        $event->update($data);
        return back();
    }


    public function uploadStart(Event $event){
        
        $this->authorize('update', $event);
        $data = request();
        $data=$data->validate([
            'upload' => ['required','file','mimes:csv,txt' ],
            ]);
        $lines = $this->openCSV($data["upload"]->path());
        $out=[];

        foreach ($lines as $line){
            $temp=$this->parseLine($line);
            if (isset($temp["message"])) {
                $message=$temp["message"];
                dd($message);
                return redirect("event/edit/{$event->id}",302,["message"=>$message]);
            }
            $out[]=$temp;

        }
        $message="Riders uploaded";
        return redirect("event/edit/{$event->id}",302,["message"=>$message]);
    }
    private function parseLine($line){

        if (sizeof($line)<7) return ["message"=>"Incorrect form"];
        if ($line[0]=="Number") return [];
        $outArray=[];
        $rider_id=str_replace(" ","",$line[1]);
        if (strlen($rider_id)!=5) return ["message"=>"Rider id is incorrect"];
        $outArray=array_merge($outArray,["rider_id"=>$rider_id]);


        $rider_name=$line[2];
        $outArray=array_merge($outArray,["rider_name"=>$rider_name]);

        $horse_id=str_replace(" ","",$line[3]);
        if (strlen($horse_id)!=5) return ["message"=>"Horse id is incorrect"];
        $outArray=array_merge($outArray,["horse_id"=>$horse_id]);

        $horse_name=$line[4];
        $outArray=array_merge($outArray,["horse_name"=>$horse_name]);

        $club=$line[5];
        $outArray=array_merge($outArray,["club"=>$club]);

        $category=$line[6];
        $outArray=array_merge($outArray,["category"=>$category]);
        return $outArray;
    }

    private function openCSV(string $csvFile)
    {
        $file_handle = fopen($csvFile, 'r');
        while (!feof($file_handle)) {
        $temp= fgetcsv($file_handle, 0, ";");
        if ($temp) $line_of_text[] = fgetcsv($file_handle, 0, ";");
        }
        fclose($file_handle);
    return $line_of_text;
}
    public function getLastResult(Event $event){
        $result = $event->result->sortByDesc("updated_at")->take(1);

        if (count($result)==0) return response()->json(["response"=>0]);
        $id=$result->first()->id;
        return response()->json(["response"=>$id]);
       
    }
    public function exportResult(Event $event)
{
    $this->authorize('update', $event);
    $fileName = $event->id.'_result.csv';

    $results=$event->result;

   
        $headers = array(
            "Content-Encoding" => "UTF-8",
            "Content-Type" => "text ; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

       
        $columns= $this->heading($event);
        //dd();
        $callback = function() use($results, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns,$delimiter = ";");
           
            foreach ($results as $result) {
                $csvOutput=[];
                $csvOutput[] = $result->rider_id;
                $csvOutput[] = $result->rider_name;
                $csvOutput[] = $result->horse_id;
                $csvOutput[] = $result->horse_name;
                $csvOutput[] = $result->club;
                
                $csvOutput[] = mb_convert_encoding($result->category, "utf-8");

                foreach (json_decode($result->assassment) as $assassment)
                {

                    $csvOutput[] =str_replace(".",",",strval($assassment->mark));
                }
                $csvOutput[] = str_replace(".",",",strval($result->mark));
                $csvOutput[] = str_replace(".",",",strval($result->percent));
                $csvOutput[] = str_replace(".",",",strval($result->collectivemark));
                $csvOutput[] = str_replace(".",",",strval($result->error));
                $line = array_map("utf8_encode", $csvOutput);
                
                fputcsv($file, $line,$delimiter = ";");
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function heading(Event $event){
         $columns = [
            'Rider licence number',
            'Rider name',
            'Horse licence number',
            'Horse name',
            'Club',
            'Category'
            ];
        for ($i=1;$i<=$event->program->numofblocks;$i++){ 

            $columns[]=$i;
        }
         $columns[] = 'Points';
         $columns[] = 'Percent';
         $columns[] = 'Colective marks';
         $columns[] = 'Error';

         return $columns;
    }
}

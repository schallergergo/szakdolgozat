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
        return redirect("event/show/{$event->id}");
    }
    public function changeStatus(Event $event)
    {
    $this->authorize('changeStatus', $event);
      $event->active=!$event->active;
      $event->save();
      return redirect()->back();
    }


}

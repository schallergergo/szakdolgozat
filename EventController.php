<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
class EventController extends Controller
{
    public function show(Event $event){
    $toStart=$event->result->where("kitoltve",0)->sortBy("updated_at");
    $started=$event->result->where("kitoltve",0)->sortBy("updated_at");
	return view("/event/show",  ["event"=>$event,
								 "started"=>$started,
								 "toStart"=>$toStart,
								]);
    }
}

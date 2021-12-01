<?php
namespace App\Exports;
use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromArray;
class ResultExport implements FromArray {
    private Event $event;

    public function __construct(Event $event) 
    {
        $this->event=$event;
    }
    
    public function array() :array
    {
    	 return $this->makeArray();
 

    }
    private function makeArray() {
    	$results= Result::where('event_id', $this->event->id)->get();
    	$output=[];
    	 foreach ($results as $result) {
                $temp=[];
                $temp[] = $result->rider_id;
                $temp[] = $result->rider_name;
                $temp[] = $result->horse_id;
                $temp[] = $result->horse_name;
                $temp[] = $result->club;
                $temp[] = $result->category;

                foreach (json_decode($result->assassment) as $assassment)
                {

                    $temp[] =$assassment->mark;
                }
                $temp[] = $result->mark;
                $temp[] = $result->percent;
                $temp[] = $result->collectivemark;
                $temp[] = $result->error;
        $output[]=$temp;
    }
    return $output;
}
}
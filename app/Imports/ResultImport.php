<?php 

namespace App\Imports;

use App\Models\Result;
use App\Models\Event;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class ResultImport implements ToModel, WithValidation, WithHeadingRow, SkipsOnError,SkipsEmptyRows
{
    use Importable, SkipsErrors;
	private Event $event;

	public function __construct(Event $event) 
    {
        $this->event=$event;
    }
    public function model(array $data)
    {	//dd($data);
    	$savedAlready=Result::where("rider_id",$data['rider_licence'])->
                            where("horse_id",$data['horse_licence'])->
                            where("event_id",$this->event->id)->get();
        if (count($savedAlready)!==0) return null;
        return new Result([
            'id' => $this->generateID(),
 			'event_id' => $this->event->id,
 			'rider_id'=> $data['rider_licence'],
 			'rider_name'=> $data['rider_name'],
            'assassment'=>$this->generateEmptyJson(50),
 			'horse_id'=> $data['horse_licence'],
 			'horse_name'=> $data['horse_name'],
 			'club' => $data['club'],
 			'category' => $data['category'],
        ]);
    }

    public function rules(): array
    {
        return [
            '0' => function($attribute, $value, $onFailure) {
                  if (str_len($value) !== 5) {
                       $onFailure('Rider licence number not correct!');
                  }
              },
              '2' => function($attribute, $value, $onFailure) {
                  if (str_len($value) !== 5) {
                       $onFailure('Horse licence number not correct!');
                  }
              }
            
        ];
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

    private function generateEmptyJson(int $numOfBlocks){
        $outputArray=array();
        for ($i=0;$i<$numOfBlocks;$i++){
            $temp=['mark'=>"",'remark'=>""];
            $outputArray[]=$temp;
        }
        return json_encode($outputArray);
    }
}
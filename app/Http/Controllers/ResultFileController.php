<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Event;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ResultExport;
use App\Imports\ResultImport;


class ResultFileController extends ResultController
{
   

    public function exportResultExcel(Event $event){
            $this->authorize('update', $event);
        return Excel::download(new ResultExport($event), 'result.xlsx');
    }

}
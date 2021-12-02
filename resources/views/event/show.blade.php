@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">


                
                <div class="card-header">{{$event->competitionname}} - {{$event->eventname}} </div>

                <div class="card-body">
                    @can ("create",[App\Models\Result::class,$event])
                    <a href="/result/create/{{$event->id}}" target="_blank">{{__("Add new rider")}}</a>
                    @endcan
                    @can('update',$event)
                    <a href="/event/export/{{$event->id}}" target="_blank">{{__("Export results")}}</a>

                    @endcan
                    @if (count($toStart)!=0)
                    
                   
                   
                    <div class="row mb-2 border">
                        <div class="col-md-2 p-1 border d-none d-md-block">
                            <span class="align-middle font-weight-bold">{{__("Date")}}</span>
                        </div>
                        
                        <div class="col-md-2 p-1 border d-none d-md-block">
                            <span class="align-middle font-weight-bold">{{__("Venue")}}</span>
                        </div>

                        <div class="col-md-2 p-1 border d-none d-md-block ">
                            <span class="align-middle font-weight-bold">{{__("Event")}}</span>
                        </div>

                        <div class="col-md-2 p-1 border d-none d-md-block">
                            <span class="align-middle font-weight-bold">{{__("Competitor")}}</span>
                        </div>
                        <div class="col-md-2 p-1 border d-none d-md-block">
                             <span class="align-middle font-weight-bold">{{__("Point")}}</span>
                            
                        </div>

                        <div class="col-md-2 p-1 border d-none d-md-block">
                             <span class="align-middle font-weight-bold">{{__("Options")}}</span>
                            
                        </div>
                    </div><!-- end of the row-->
                    
                    @endif
                    @foreach ($toStart as $result)
                    @can('update',$result)
                    

                    <div class="row mb-2 border">
                        <div class="col-md-2 p-1 border">
                            <span class="align-middle">{{$result->event->date}}</span>
                        </div>
                        
                        <div class="col-md-2 p-1 border">
                            <span class="align-middle">{{$result->event->venue}}</span>
                        </div>

                        <div class="col-md-2 p-1 border">
                            <span class="align-middle">{{$result->event->eventname}}</span>
                        </div>

                        <div class="col-md-2 p-1 border">
                            <span class="align-middle">{{$result->rider_name}} - {{$result->horse_name}}</span>
                        </div>
                        <div class="col-md-2 p-1 border">
                            @if ($result->eliminated)
                                <span class="aalign-middle">"Eliminated"</span>
                            @else
                                <span class="align-middle">{{$result->mark}} {{__("points")}} - {{number_format($result->percent,2)}}%</span>
                            @endif
                        </div>

                        <div class="col-md-2 p-1 border">
                            <span class="align-middle"><a href="/result/edit/{{$result->id}}" target="_blank">{{__("Fill in the test sheet")}}</a></span>
                            
                        </div>
                    </div><!-- end of the row-->
                    @endcan
                    @endforeach
                    
                  
                    </div><!-- end of the card-->
                   
                <div class="card-header">{{__("Results")}}</div>

                <div class="card-body">
                    @if (count($started)!=0)
                    <div class="row mb-2 border">
                        <div class="col-md-2 p-1 border d-none d-md-block">
                            <span class="align-middle font-weight-bold">{{__("Rider")}}</span>
                        </div>
                        
                        <div class="col-md-2 p-1 border d-none d-md-block">
                            <span class="align-middle font-weight-bold">{{__("Horse")}}</span>
                        </div>

                        <div class="col-md-2 p-1 border d-none d-md-block ">
                            <span class="align-middle font-weight-bold">{{__("Club")}}</span>
                        </div>

                        <div class="col-md-2 p-1 border d-none d-md-block">
                            <span class="align-middle font-weight-bold">{{__("Category")}}</span>
                        </div>
                        <div class="col-md-2 p-1 border d-none d-md-block">
                             <span class="align-middle font-weight-bold">{{__("Result")}}</span>
                            
                        </div>

                        <div class="col-md-2 p-1 border d-none d-md-block">
                             <span class="align-middle font-weight-bold">{{__("Options")}}</span>
                            
                        </div>
                    </div><!-- end of the row-->

                    @endif
                   
                    @foreach ($started as $result)
                    <div class="row mb-2 border">
                        <div class="col-md-2 p-1 border">
                            <span class="align-middle">{{$result->rider_name}}</span>
                        </div>
                        
                        <div class="col-md-2 p-1 border">
                            <span class="align-middle">{{$result->horse_name}}</span>
                        </div>

                        <div class="col-md-2 p-1 border">
                            <span class="align-middle">{{$result->club}}</span>
                        </div>

                        <div class="col-md-2 p-1 border">
                            <span class="align-middle">{{$result->category}}</span>
                        </div>
                        <div class="col-md-2 p-1 border">
                            @if ($result->eliminated)
                                <span class="aalign-middle">{{__("Eliminated")}}</span>
                            @else
                                <span class="align-middle">{{$result->mark}} {{__("points")}} - {{number_format($result->percent,2)}}%</span>
                            @endif
                        </div>
                        <div class="col-md-2 p-1 border">
                         @can('update',$result)
                            <span class="align-middle"><a href="/result/edit/{{$result->id}}" target="_blank">{{__("Edit the test sheet")}}</a></span><br>
                            <span class="align-middle"><a href="/result/editinfo/{{$result->id}}" target="_blank">{{__("Edit competitor info")}}</a></span><br>
                        @endcan

                        @can('checkAfter',$result)
                        
                            <span class="align-middle"><a href="/result/show/{{$result->id}}" target="_blank">{{__("View the test sheet")}}</a></span>

                        
                        @else
                            <span class="align-middle">{{__("Judge")}}: {{$event->judge}}</span>
                            
                        @endcan
                        </div>

                    </div><!-- end of the row-->
                    
                    @endforeach
                    
                  
                    </div><!-- end of the card-->                  
     </div>
    </div>
</div>
</div>
@endsection

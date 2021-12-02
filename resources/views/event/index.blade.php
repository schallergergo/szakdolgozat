@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Own events') }}
                    @can ("create",App\Models\Event::class)
                        <a href="/event/create">{{__("New event")}}</a>
                    @endcan
                    @can ("create",App\Models\User::class)
                        <a href="/user/create">{{__("New user")}}</a>
                    @endcan
                </div>

                <div class="card-body">

                    <div class="row mb-2 border">
                        <div class="col-md-1 p-1 border d-none d-md-block">
                            <span class="align-middle font-weight-bold">{{__("Date")}}</span>
                        </div>
                        
                        <div class="col-md-3 p-1 border d-none d-md-block">
                            <span class="align-middle font-weight-bold">{{__("Venue")}}</span>
                        </div>

                        <div class="col-md-3 p-1 border d-none d-md-block ">
                            <span class="align-middle font-weight-bold">{{__("Competition")}}</span>
                        </div>

                        <div class="col-md-3 p-1 border d-none d-md-block">
                            <span class="align-middle font-weight-bold">{{__("Event")}}</span>
                        </div>
                       
                        <div class="col-md-2 p-1 border d-none d-md-block">
                             <span class="align-middle font-weight-bold">{{__("Options")}}</span>
                            
                        </div>
                    </div><!-- end of the row-->
                    @foreach ($events as $event)
                    <div class="row mb-2 border">
                        <div class="col-md-1 p-1 border">
                            <span class="align-middle">{{$event->date}}</span>
                        </div>
                        
                        <div class="col-md-3 p-1 border">
                            <span class="align-middle">{{$event->venue}}</span>
                        </div>

                        <div class="col-md-3 p-1 border">
                            <span class="align-middle">{{$event->competitionname}}</span>
                        </div>

                        <div class="col-md-3 p-1 border">
                            <span class="align-middle">{{$event->eventname}}</span>
                        </div>
                      

                        <div class="col-md-2 p-1 border">
                            <span class="align-middle"><a href="/event/show/{{$event->id}}" target="_blank">  {{__("View event")}}</a></span>
                             @can ('update',$event)
                                <span class="align-middle"><a href="/event/edit/{{$event->id}}" target="_blank">  {{__("Edit event")}}</a></span>
                            @endcan
                        </div>
                    </div><!-- end of the row-->
                    
                    @endforeach
                    
                    <div class="row">
                        <div class="col-md-12 mt-2">
                       {{ $events->links() }}
                        </div>
                       
                    </div><!-- end of the row-->
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

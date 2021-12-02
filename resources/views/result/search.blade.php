@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Search results') }}</div>

                <div class="card-body">
                    <form method="GET" action="" enctype="multipart/form-data">
                        

                       <div class="form-group row">
                            <label for="search" class="col-md-4 col-form-label text-md-right">{{ __("Name or licence number") }}</label>
                            <div class="col-md-6">
                                <input id="search" type="text" class="form-control @error('search') is-invalid @enderror" name="search" value="{{ old('search') }}" required>

                                @error('search')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{__("Minimum 3 characters")}}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                  

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Search') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    @isset($results)
                    @if(count($results)==0)
                     
                     <span class="p-2">
                            <h2>{{ __("No results found")}}</h2>
                     </span>
                    	
                    @else
                    <div class="p-2">
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

                        <div class="col-md-3 p-1 border d-none d-md-block">
                            <span class="align-middle font-weight-bold">{{__("Competitor")}}</span>
                        </div>
                        <div class="col-md-3 p-1 border d-none d-md-block">
                            <span class="align-middle font-weight-bold">{{__("Result")}}</span>
                        </div>
                        
                    </div><!-- end of the row-->
                    @foreach ($results as $result)
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

                        <div class="col-md-3 p-1 border">
                            <span class="align-middle">{{$result->rider_name}} - {{$result->horse_name}}</span>
                        </div>
                        <div class="col-md-3 p-1 border">
                            @if ($result->eliminated)
                                <span class="align-middle">{{__("Eliminated")}}</span>
                            @else
                                <span class="align-middle">{{$result->mark}} {{__("points")}} - {{number_format($result->percent,2)}}%</span>
                            @endif
                        </div>

                        
                    </div><!-- end of the row-->
                     @endforeach

                     </div>
                    @endif
                    @endisset
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection

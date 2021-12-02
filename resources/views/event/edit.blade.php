@extends('layouts.app')
@section('title','Versenyszám hozzáadása')
@section('content')


<div class="container">
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modify event') }} <br>
                 <a href="/event/show/{{$event->id}}">{{__("View event details")}}</a></div>

                <div class="card-body">
                    <form method="POST" action="/event/update/{{$event->id}}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')


                       <div class="form-group row">
                            <label for="competitionname" class="col-md-4 col-form-label text-md-right">{{ __('Name of the competition') }}</label>
                            <div class="col-md-6">
                                <input id="competitionname" type="text" class="form-control @error('competitionname') is-invalid @enderror" name="competitionname" value="{{ $event->competitionname }}" required>

                                @error('competitionname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{__("Too long")}}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                         <div class="form-group row">
                            <label for="eventname" class="col-md-4 col-form-label text-md-right">{{ __('Name of the event') }}</label>
                            <div class="col-md-6">
                                <input id="eventname" type="text" class="form-control @error('eventname') is-invalid @enderror" name="eventname" value="{{ $event->eventname }}" required>

                                @error('eventname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{__("Too long")}}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="venue" class="col-md-4 col-form-label text-md-right">{{ __('Venue') }}</label>

                            <div class="col-md-6">
                                <input id="venue" type="text" class="form-control @error('venue') is-invalid @enderror" name="venue" value="{{ $event->venue }}" required>

                                @error('venue')
                                    <span class="invalid-feedback" role="alert">
                                          <strong>{{__("Too long")}}</strong>
                                    </span>
                                @enderror
                            </div> 
                        </div>



                        <div class="form-group row">
                            <label for="date" class="col-md-4 col-form-label text-md-right">{{ __('Date') }}</label>

                            <div class="col-md-6">
                                <input id="date" type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ $event->date }}" required>

                                @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{__("Date is invalid")}}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="program" class="col-md-4 col-form-label text-md-right">{{ __('Program') }}</label>

                            <div class="col-md-6">
                                <select id="program_id"  class="form-control @error('program') is-invalid @enderror" name="program_id"  disabled>

                                <option value=""> {{$event->program->name}} </option>
                            </select>

                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="penciler" class="col-md-4 col-form-label text-md-right">{{ __('Penciler') }}</label>

                            <div class="col-md-6">
                                <select id="penciler"  class="form-control @error('penciler') is-invalid @enderror" name="penciler"  required>
                                <option value=""> {{__("Select a penciler")}} </option>
                            @foreach ($pencilers as $penciler)
                                <option value="{{$penciler->id}}" 
                                    @if ($event->penciler==$penciler->id) 
                                {{"selected"}}
                                @endif >

                                     {{$penciler->name}} 
                                    
                                </option>
                            @endforeach
                            </select>

                            </div>
                        </div>




                        <div class="form-group row">
                            <label for="judge" class="col-md-4 col-form-label text-md-right">{{ __('Judge') }}</label>

                            <div class="col-md-6">
                                <input id="judge" type="text" class="form-control @error('judge') is-invalid @enderror" name="judge" value="{{ $event->judge }}" required>

                                @error('judge')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{__("Too long")}}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="position" class="col-md-4 col-form-label text-md-right">{{ __('Position') }}</label>

                            <div class="col-md-6">
                                <input id="position" type="text" class="form-control @error('position') is-invalid @enderror" name="position" value="{{ $event->position }}" required>

                                @error('position')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{__("Invalid position")}}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    </div>
               
                
            </div>
        </div>
    </div>
</div>

@endsection

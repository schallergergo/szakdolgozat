@extends('layouts.app')
@section('title','Versenyzők hozzáadása')
@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add new competitor') }}</div>

                <div class="card-body">
                    <form method="POST" action="/addStart2" enctype="multipart/form-data">
                        @csrf
                        <input name="id" value={{$id}} type="hidden"/>
                        <input name="event_id" value="{{$event_id}}" type="hidden"/>

                       <div class="form-group row">
                            <label for="rider_id" class="col-md-4 col-form-label text-md-right">{{ __('Rider licence number') }}</label>
                            <div class="col-md-6">
                                <input id="rider_id" type="text" class="form-control @error('lovasid') is-invalid @enderror" name="rider_id" value="{{ old('rider_id') }}" required>

                                @error('lovasid')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{__("Licence number is invalid")}}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                  

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('New rider') }}
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

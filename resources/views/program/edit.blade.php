@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modify') }}</div>

                <div class="card-body">
                    <form method="POST" action="/program/update/{{$program->id}}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        
                       <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Program name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$program->name}}" required>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{__("Name is invalid")}}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="numofblocks" class="col-md-4 col-form-label text-md-right">{{ __('Number of blocks') }}</label>

                            <div class="col-md-6">
                                <input id="numofblocks" type="number" class="form-control @error('numofblocks') is-invalid @enderror" name="numofblocks" value="{{$program->numofblocks }}" required>

                                @error('numofblocks')
                                    <span class="invalid-feedback" role="alert">
                                          <strong>{{__("Field is invalid")}}</strong>
                                    </span>
                                @enderror
                            </div> 
                        </div>

                         <div class="form-group row">
                            <label for="maxMark" class="col-md-4 col-form-label text-md-right">{{ __('Max mark') }}</label>

                            <div class="col-md-6">
                                <input id="maxMark" type="number" class="form-control @error('maxMark') is-invalid @enderror" name="maxMark" value="{{$program->maxMark }}" required>

                                @error('maxMark')
                                    <span class="invalid-feedback" role="alert">
                                          <strong>{{__("Field is invalid")}}</strong>
                                    </span>
                                @enderror
                            </div> 
                        </div>

                        <div class="form-group row">
                            <label for="typeofevent" class="col-md-4 col-form-label text-md-right">{{ __('Type of event') }}</label>

                            <div class="col-md-6">
                                <input id="typeofevent" type="text" class="form-control @error('typeofevent') is-invalid @enderror" name="typeofevent" value="{{$program->typeofevent}}" required>

                                @error('typeofevent')
                                    <span class="invalid-feedback" role="alert">
                                          <strong>{{__("Field is invalid")}}</strong>
                                    </span>
                                @enderror
                            </div> 
                        </div>

                        <div class="form-group row">
                            <label for="doublesided" class="col-md-4 col-form-label text-md-right">{{ __('Doublesided') }}</label>
                            <div class="col-md-6">
                               <select id="doublesided"  class="form-control @error('program') is-invalid @enderror" name="doublesided"  required>
                                <option value=""> {{__("Is it doublesided?")}} </option>
                                <option value="1"> {{__("Yes")}} </option>
                                <option value="0" selected> {{__("No")}} </option>
                            
                            </select required>

                                @error('doublesided')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{__("Field is invalid")}}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                       

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Modify') }}
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

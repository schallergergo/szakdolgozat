@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Programs') }}
                     @can("create",App\Models\Program::class)
                    <a href="/program/create">{{__("Add new program")}}</a>
                    @endcan
                </div>

                <div class="card-body">

                    <div class="row mb-2 border">
                        <div class="col-md-9 p-1 border d-none d-md-block">
                            <span class="align-middle font-weight-bold">{{__("Name")}}</span>
                        </div>
                        
                        <div class="col-md-3 p-1 border d-none d-md-block">
                            <span class="align-middle font-weight-bold">{{__("Options")}}</span>
                        </div>

                    </div><!-- end of the row-->
                    @foreach ($programs as $program)
                    <div class="row mb-2 border">
                        <div class="col-md-9 p-1 border">
                            <span class="align-middle">{{$program->name}}</span>
                        </div>


                        <div class="col-md-3 p-1 border">
                            <span class="align-middle"><a href="/program/show/{{$program->id}}" target="_blank">  {{__("View program")}}</a></span>
                             @can ("update",$program)
                            <span class="align-middle"><a href="/program/edit/{{$program->id}}" target="_blank">  {{__("Edit")}}</a></span>
                            @endcan
                        </div>

                    </div><!-- end of the row-->
                    
                    @endforeach
                  
                    </div><!-- end of the row-->
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

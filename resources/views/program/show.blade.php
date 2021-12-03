@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                     @can("create",App\Models\Block::class)
                    <a href="/block/create/{{$program->id}}">{{__("Add new block")}}</a>
                    @endcan
                </div>
                
                <div class="card-body">
                <div class="row">
                    <div class="col-md-7 p-2 border"><h5>{{$program['name']}}</h5></div>
                 <div class="col-md-1 p-2 border"><h5>Max</h5></div>
                <div class="col-md-1 p-2 border"><h5>{{__("Mark")}}</h5></div>
                <div class="col-md-3 p-2 border"><h5>{{__("Remark")}}</h5></div>
                   
                </div>

                    @foreach ($blocks as $block)
                    <div class="row">
                    
                        <div class="col-md-1 p-2 border">
                            <p>{{ $block['ordinal'] }}</p>
                        </div>
                        @if ($block["programpart"]===1)
                        <div class="col-md-2 p-2 border">
                            <pre>{{ $block['letters'] }}</pre>
                        </div>
                        @endif
                        @if ($block["programpart"]==1)
                        <div class="col-md-4 p-2 border">
                            <pre>{{ $block['criteria'] }}</pre>
                        </div>
                        @else
                        <div class="col-md-6 p-2 border">
                            <pre>{{ $block['criteria'] }}</pre>
                        </div>
                        @endif
                        
                        @if ($block['coefficient']===2)
                        <div class="col-md-1 p-2 border">
                            <center>
                                <p>{{ $block['maxmark'] }}X2</p>
                            </center>
                        </div>

                        @else
                        <div class="col-md-1 p-2 border">
                            <center>
                                <p>{{ $block['maxmark'] }}</p>
                            </center>
                        </div>
                        @endif
                        <div class="col-md-1 p-2 border">
                       
                    </div>
                        
                    <div class="col-md-3 p-2 border">
                        @can ("update",$block)
                        <a href="/block/edit/{{$block->id}}">{{__("Edit")}}</a>
                        @endcan
                    </div>
                            </div> <!--end of the row-->

                           @endforeach
                    @if ($program["typeofevent"]=="normal")
                    <div class="row">
                    
                        <div class="col-md-12 p-2 border">
                            <p>{{__("Leave arena at A in free walk")}}</p>
                        </div>
                    </div>
                    @endif
                     <div class="row">
                    
                        <div class="col-md-12 p-2 border">
                            <strong><p>{{__("Collective marks")}}</p></strong>
                        </div>
                    </div>
<!-- Összbenyomás-->
                    @foreach ($collectivemarks as $block)
                    <div class="row">
                    
                        <div class="col-md-1 p-2 border">
                            <p>{{ $block['ordinal'] }}</p>
                        </div>
                        @if ($block["programpart"]===1)
                        <div class="col-md-2 p-2 border">
                            <pre>{{ $block['letters'] }}</pre>
                        </div>
                        @endif
                        @if ($block["programpart"]==1)
                        <div class="col-md-4 p-2 border">
                            <pre>{{ $block['criteria'] }}</pre>
                        </div>
                        @else
                        <div class="col-md-6 p-2 border">
                            <pre>{{ $block['criteria'] }}</pre>
                        </div>
                        @endif
                        
                        @if ($block['coefficient']===2)
                        <div class="col-md-1 p-2 border">
                            <center>
                                <p>{{ $block['maxmark'] }}X2</p>
                            </center>
                        </div>

                        @else
                        <div class="col-md-1 p-2 border">
                            <center>
                                <p>{{ $block['maxmark'] }}</p>
                            </center>
                        </div>
                        @endif
                        <div class="col-md-1 p-2 border">

                    </div>
                    <div class="col-md-3 p-2 border">
                        @can ("update",$block)
                        <a href="/block/edit/{{$block->id}}">{{__("Edit")}}</a>
                        @endcan
                    </div>
                            </div> <!--end of the row-->

                           @endforeach
                    <div class="row">
                    
                        
                    <div class="col-md-4 p-2 border">
                 
                    </div>
                   </div>


                </div>
            </div>
        </div>
    </div>
</div>



@endsection
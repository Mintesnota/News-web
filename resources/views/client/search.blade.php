@extends('layouts.client')


@section('content')

  <div  class="align-center">
   

        
                <div class="row d-flex  justify-content-center text-align-center">
                  <div class="col-sm-8">
                    <h5 class="font-weight-600 mb-1">
                      {{$post->title}}
                    </h5>
                    <p class="fs-13 text-muted mb-0">
                      <span class="mr-2">Posted </span>{{$post->created_at->diffForHumans()}}
                    </p>
                  </div>
                       {{$post->long_desc}}
                  </div>
                </div>
              
            
        

   


@endsection
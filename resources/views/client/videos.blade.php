@extends('layouts.client')
@section('content')
     <div class="row">
            <div class="col-sm-12">
              <div class="border-bottom pb-4 pt-4">
                <div class="row">
                  <div class="col-sm-8">
                    <h5 class="font-weight-600 mb-1">
                      {{$videos->title}}
                    </h5>
                <iframe width="504" height="403" src=" {{$videos->url}}" allowfullscreen></iframe> 
                  
                </div>
              </div>
            </div>
          </div>
  @endsection
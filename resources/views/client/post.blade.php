@extends('layouts.client')
@section('content')

        <div class="row">
            <div class="col-sm-12">
              <div class="border-bottom pb-4 pt-4">
                <div class="row">
                  <div class="col-sm-8">
                    <h5 class="font-weight-600 mb-1">
                      {{$post->title}}
                    </h5>
                    <p class="fs-13 text-muted mb-0">
                      <span class="mr-2">Posted </span>{{$post->created_at->diffForHumans()}}
                    </p>
                      <p >
                       {!! $post->long_desc !!}</p>
                       <p >
                       {{-- {!! "<p>test</p><img src='https://res.cloudinary.com/demo/image/upload/v1312461204/sample.jpg'>" !!}</p> --}}

                  </div>
                  <div class="col-sm-4">
                    <div class="rotate-img">
          <img
            src="{{asset('storage/posts/'.$post->image )}}"
            alt="banner"
            class="img-fluid"
          />
        </div>
         </div>
                </div>
              </div>
            </div>
          </div>

  @endsection

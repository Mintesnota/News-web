@extends('layouts.client')
@section('content')
    <div  class="row">
        <div class="col-md-8 offset-md-2 ">
            
        <form method="POST" action="{{ route('become.writer') }}">
                        @csrf

        
                      

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Enter your phone') }}</label>

                            <div class="col-md-6">
                                <input type="text" value="" class="form-control" name="phone" value="{{old('phone')}}">
                            </div>

                        
                                <input type="number" value="{{auth()->id()}}" name="user_id"  hidden>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Become writer') }}
                                </button>
                            </div>
                        </div>
                    </form>
        
        
        </div>
    </div>



@endsection
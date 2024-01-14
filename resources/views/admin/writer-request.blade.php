@extends('layouts.master')

@section('content')
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{$page}}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/admin/homr">Home</a></li>
              <li class="breadcrumb-item active">{{$page}}</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class= "col-md-12 ">
                
          <table class="table table-striped tabel-responsive-sm">
            <thead>
                <tr>
                   <th>Name</th>
                   <th>phone</th>
                   <th>Email</th>
                   <th>Sent on</th>
                  

                </tr>
            </thead>
            <tbody>
        @if($writer_requests->count()>0)
        
        @foreach ($writer_requests as $writer_request)
           <tr>

            <td>{{$writer_request->title}}</td>
            <td>{!!$writer_request->desc!!}</td>
            <td>{{$writer_request->date}}</td>
           
         
        </tr>
         @endforeach
         
        @else
        <h2>No writer_requests found</h2>
        
        @endif
            </tbody>
        
        
        </table>

            
        </div>
      </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection
@section('additional_scripts')
  
@endsection




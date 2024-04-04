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
                   <th>Event Title</th>
                   <th>Description</th>
                   <th>Date</th>


                </tr>
            </thead>
            <tbody>
        @if($events->count()>0)

        @foreach ($events as $event)
           <tr>

            <td>{{$event->title}}</td>
            <td>{!!$event->desc!!}</td>
            <td>{{$event->date}}</td>
            <td><a href="{{route('admin.event.update.form',$event->id)}}}"><i class="fa fa-eye"></i>/<i class="fa fa-edit"></a></td>
            <td><a href="{{route('admin.event.destroy',$event->id)}}}"> <i class="fa fa-trash text-danger"></a></td>
           </tr>
         @endforeach

        @else
        <h2>No events found</h2>

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




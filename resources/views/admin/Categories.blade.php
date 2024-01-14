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
              <li class="breadcrumb-item"><a href="/admin/home">Home</a></li>
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
            <table class="table table-striped table-bordered table-hover table-responsive-sm ">
            
              <thead>
                <tr>
                   <th>Title</th>
                   <th>Description</th>
                   <th>Date Created</th>
                </tr>
              </thead>
            <tbody>
               
                      {{--   @if($categories->count()>0)
                         @foreach ($categories as $category)
                         <tr>
                         <td>{{$category->title}}</td>
                         <td>{{$category->desc}}</td>
                         <td>{{$category->created_at}}</td>
                         <td><a href="{{route('admin.category.update.form',$category->id)}}}"><i class="fa fa-eye"></i>/<i class="fa fa-edit"></a></td>
                          <td><a href="{{route('admin.category.destroy',$category->id)}}}"> <i class="fa fa-trash text-danger"></a></td>
                         
                       </tr>
                         @endforeach
                         @else

                         <h3>No categories found</h3>
                         @endif
                --}}
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
<script type="text/javascript">
  $(document).ready(function(){
   $('.categories-table').DataTables({
     processing:true,
     serverSide:true,
     ajax:{
       url:"{{route('admin.categories')}}",
     },
     columns:[
     
     {
       data:'title',
       name:'title'
      },
      {
       data:'desc',
       name:'desc'
       },
      
       {
       data:'created_at',
       name:'created_at'
        },
       {
         data:'action',
         name:'action',
         orderable:false
       }
        ]
   });
  });
 </script> 
@endsection 


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
            <table class="table table-striped table-bordered table-hover table-responsive-sm posts-table">
            
              <thead>
                <tr>
                  <th>Title</th>
                   <th>Description</th>
                   <th>Category</th>
                   <th>Views</th>
                   <th>Date Created</th>
                   <th>Action</th>  
                </tr>
              </thead>
            <tbody>
              @if($posts->count()>0)
              @foreach ($posts as $post)
              <tr>
              <td>{{$post->title}}</td>
              <td>{{$post->short_desc}}</td>
              <td>{{$post->category->title}}</td>
              <td>{{$post->views}}</td>
              <td>{{$post->created_at}}</td>
              <td><a href="{{route('admin.post.update.form',$post->id)}}}"><i class="fa fa-eye"></i>/<i class="fa fa-edit"></a></td>
               <td><a href="{{route('admin.post.destroy',$post->id)}}}"> <i class="fa fa-trash text-danger"></a></td>
              
            </tr>
              @endforeach
              @else

              <h3>No categories found</h3>
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

{{--@section('additional_scripts')
  <script type="text/javascript">
   $(document).ready(function(){
    $('.posts-table').DataTables({
      processing:true,
      serverSide:true,
      ajax:{
        url:"{{route('admin.posts')}}"
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
        data:'views',
        name:'views'
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
@endsection --}}


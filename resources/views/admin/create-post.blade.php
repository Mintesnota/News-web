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
              <li class="breadcrumb-item"><a href="#">Home</a></li>
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
            <div class="col-md-6 offset-md-3">
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">{{$page}}</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->

                  <form role="form" method="post" action="{{route('admin.post.create')}}"  enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="card-body">

                  <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="event_name">Post Title</label>
                            <input type="text" name="title"  class="form-control"  autocomplete="off" required>

                          </div>
                        </div>

                        <div class="col-md-6">

                        <div class="form-group">
                          <label for="event_name">Categories</label>
                         <select name="category_id" class="form-control" id="">
                            @if ($categories->count() >0)
                                   @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->title}}</option>
                                        @endforeach
                                        @else

                                        @endif
                               </select>
                        </div>

                      </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="event_name">Is the News Special? </label>
                             <select name="special " class="form-control" id="">

                                    <option value="0">No</option>
                                    <option value="1">Yes</option>


                                   </select>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="event_name">Is this a breaking news? </label>
                             <select name="breaking" class="form-control" id="">

                                    <option value="0">No</option>
                                    <option value="1">Yes</option>


                                   </select>
                            </div>
                          </div>
                        </div>



                    <div class="form-group">
                    <label for="image">Post cover Image</label>
                    <input type="file" name="image" class="form-control">

                  </div>
                        <div class="form-group">
                        <label for="short_desc">Short Description</label>
                        <textarea name="short_desc" class="ckeditor form-control" id="editor1" ></textarea>

                      </div>




                      <div class="form-group">
                        <label for="long_desc">Long Description</label>
                        <textarea  name="long_desc" class="ckeditor form-control" id="editor2" cols="30" rows="10"></textarea>

                      </div>



                    </div>


                      <input type="number" name="user_id" value="1" class="form-control" autocomplete="off" hidden >


                    <!-- /.card-body -->

                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                  </form>

                </div>

            </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

@endsection

@section('additional_scripts')

<script>

   class MyUploadAdapter {
    constructor( loader ) {
        // The file loader instance to use during the upload.
        this.loader = loader;
    }

    // Starts the upload process.
 upload() {
        return this.loader.file
            .then( file => new Promise( ( resolve, reject ) => {
                this._initRequest();
                this._initListeners( resolve, reject, file );
                this._sendRequest( file );
            } ) );
    }

    // Aborts the upload process.
    abort() {
        if ( this.xhr ) {
            this.xhr.abort();
        }
    }

    // Initializes the XMLHttpRequest object using the URL passed to the constructor.
    _initRequest() {
        const xhr = this.xhr = new XMLHttpRequest();

        // Note that your request may look different. It is up to you and your editor
        // integration to choose the right communication channel. This example uses
        // a POST request with JSON as a data structure but your configuration
        // could be different.
        xhr.open( 'POST', "{{route('upload',['_token'=>csrf_token()])}}", true );
        xhr.responseType = 'json';
    }

    // Initializes XMLHttpRequest listeners.
    _initListeners( resolve, reject, file ) {
        const xhr = this.xhr;
        const loader = this.loader;
        const genericErrorText = `Couldn't upload file: ${ file.name }.`;

        xhr.addEventListener( 'error', () => reject( genericErrorText ) );
        xhr.addEventListener( 'abort', () => reject() );
        xhr.addEventListener( 'load', () => {
            const response = xhr.response;

            // This example assumes the XHR server's "response" object will come with
            // an "error" which has its own "message" that can be passed to reject()
            // in the upload promise.
            //
            // Your integration may handle upload errors in a different way so make sure
            // it is done properly. The reject() function must be called when the upload fails.
            if ( !response || response.error ) {
                return reject( response && response.error ? response.error.message : genericErrorText );
            }

            // If the upload is successful, resolve the upload promise with an object containing
            // at least the "default" URL, pointing to the image on the server.
            // This URL will be used to display the image in the content. Learn more in the
            // UploadAdapter#upload documentation.
           resolve(response);
           // resolve({
             //   default:response.url
            //});
        } );

        // Upload progress when it is supported. The file loader has the #uploadTotal and #uploaded
        // properties which are used e.g. to display the upload progress bar in the editor
        // user interface.
        if ( xhr.upload ) {
            xhr.upload.addEventListener( 'progress', evt => {
                if ( evt.lengthComputable ) {
                    loader.uploadTotal = evt.total;
                    loader.uploaded = evt.loaded;
                }
            } );
        }
    }

    // Prepares the data and sends the request.
    _sendRequest( file ) {
        // Prepare the form data.
        const data = new FormData();

        data.append( 'upload', file );

        // Important note: This is the right place to implement security mechanisms
        // like authentication and CSRF protection. For instance, you can use
        // XMLHttpRequest.setRequestHeader() to set the request headers containing
        // the CSRF token generated earlier by your application.

        // Send the request.
        this.xhr.send( data );
    }
}

function MyCustomUploadAdapterPlugin( editor ) {
    editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
        // Configure the URL to the upload script in your back-end here!

        return new MyUploadAdapter( loader );
    };
}

ClassicEditor
    .create( document.querySelector( '#editor2' ), {
        extraPlugins: [ MyCustomUploadAdapterPlugin ],
        ckfinder:{
          uploadurl:"{{route('upload',['_token'=>csrf_token()])}}",
        }
        // More configuration options.
        // ...
    } )
    .catch( error => {
        console.log( error );
    } );
</script>




@endsection














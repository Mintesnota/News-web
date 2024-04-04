<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\setting;
use App\Models\Category;
use App\Models\Event;
use App\Models\Video;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use App\Mail\PostMail;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{

    public function uploadImage($image, $dir)
    {
        $image_name=$image->getClientOriginalName();
        $new_name = time().$image_name;
        $image->move($dir, $new_name);
         return $new_name;
    }

    public function home(){

        $categories =Category::all();
        $events =Event::all();
        $posts =Post::all();
        $latest_posts=Post::latest()->
          leftjoin('categories', 'categories.id', '=', 'posts.category_id' )
       ->select('posts.*','categories.title as category_title')->
        take(10)->get();
        $latest_users=User::latest()->take(10)->get();
        $admins=User::where('is_admin',1)->get();
        $users =User::all();
        $videos=Video::all();

        return view('admin.home',compact('categories','events','posts','users','videos','latest_posts','latest_users')

    );

    }




    public function settingsUpdateForm()   {

        $page="Update Settings";
        $settings = setting::latest()->first();
        return view('admin.update-setting', \compact('settings','page'));
    }

    public function settingsUpdate(Request $request){
             $logo=null;
             $settings = setting::latest()->first();
        if($settings !=null && $settings->site_logo){

        $logo = $settings->site_logo;
        }

        if($request->site_logo){
            $dir ="storage/setting/logo/";
        $logo= $this->uploadImage($request->site_logo, $dir);
        }

        if($settings != null){
            $input = $request->all();
            $settings ->fill($input)->save();
            $settings->site_logo =$logo;
            $settings->save();
            toastr()->success('settings updated successfully');
            return back();

        }
        else{
            setting::create($request->all());
           if($request->site_logo){
            $settings->site_logo =$logo;
            $settings->save();
           }
                        toastr()->success('settings created successfully');
            return back();
        }
    }
        //Categories CRUD Section
        public function categories(Request $request){
         $categories =Category::latest()->get();
            $page ="Categories";
       return view('admin.Categories',compact ('page','categories'));
        }
        public function categoryCreateForm(){
            $page ="Create Category";
            return view('admin.create-category',compact ('page'));
        }

        public function categoryCreate(Request $request){

              $image = null;
        if($request->image){
          $dir ="storage/Categories/";
        $image= $this->uploadImage($request->image, $dir);
        }
       $category = new Category;
       $category -> title =$request->title;
       $category -> desc =$request->desc;
       $category -> image =$image;
       $category -> user_id =$request->user_id;
       $category -> save();
       toastr()->success('category created successfully');
       return back();

        }

        public function categoryUpdateForm($id)
        {
                $category = Category::find($id);
                $page = "Update Category";
                return view('admin.update-category', compact('category','page'));

        }

        public function categoryUpdate(Request $request ,$id){

           $category = Category::find($id);
            $image = $category->image;
             $category->fill($request->all())->save();

             if($request->image){
                $dir ="storage/Categories/";
               $image= $this->uploadImage($request->image, $dir);
                $category->image =$image;
                $category->save();


            }

            toastr()->success('category updated successfully');
            return back();
}
        public function categoryDestroy($id){
           $category =Category ::find($id);
           $category->delete();
           toastr()->success('category deleted successfully');
           return back();

       }

       //POST CRUD section
       public function posts(Request $request){
        $posts =post::latest()->get();
        $page ="Posts";

        return view('admin.posts',compact ('page','posts'));
    }
    public function postCreateForm(){
        $page ="Create post";
        $categories =category::latest()->get();
        return view('admin.create-post',compact('page','categories'));
    }

    public function postCreate(Request $request){
           //  Post::create($request->all());
            // return back();


      $image = null;
      if($request->image){
        $dir ="storage/posts/";
      $image= $this->uploadImage($request->image, $dir);
      }
  $post=new Post;
  $post->title=$request->title;
  $post->category_id =$request->category_id;
  $post->user_id =$request->user_id;
  $post->short_desc=$request->short_desc;
  $post->image=$image;
  $post->long_desc=$request->long_desc;
 // $post->special=$request->special;
  $post->breaking=$request->breaking;
  $post->save();
    toastr()->success('Post created successfully');
     for ($id=1;$id<3;$id++){
        Mail::to($users=user::find($id))->send(new PostMail());
        }
    return back();

    }

    public function postUpdateForm($id)
    {


            $post = Post::find($id);
            $categories =category::latest()->get();
            $page = "Update post";
            return view('admin.update-post', compact('post','page','categories'));

    }

    public function postUpdate(Request $request ,$id){

       $post = Post::find($id);
       $image=$post->image;
       if($request->image){
           $dir ="storage/posts/";
           $image= $this->uploadImage($request->image, $dir);
           $post->image=$image;
           $post->save();
       }

       toastr()->success('post updated successfully');
         return back();


        }

    public function postDestroy($id){
       $post =Post ::find($id);
       $post->delete();
       toastr()->success('post deleted successfully');
       return back();

    }

//Event CRUD SECTION
    public function events(Request $request){

$page ="events";

$events =Event::latest()->get();
return view('admin.events',compact ('page','events'));
}
public function eventCreateForm(){
$page ="Create event";

return view('admin.create-event',compact('page'));
}

public function eventCreate(Request $request){

Event::create($request->all());
toastr()->success('Event created successfully');
return back();

}

public function eventUpdateForm($id)
{
    $event = Event::find($id);
    $page = "Update event";
    return view('admin.update-event', compact('event','page'));

}

public function eventUpdate(Request $request ,$id){

$event = Event::find($id);
$event->fill($request->all())->save();
toastr()->success('Event updated successfully');
 return back();


}

public function eventDestroy($id){
$event =Event::find($id);
$event->delete();
toastr()->success('Event deleted successfully');
return back();

}



 //Vidoe CRUD SECTION
public function videos(Request $request){

$page ="videos";

$videos =Video::latest()->get();
return view('admin.Videos',compact ('page','videos'));
}
public function videoCreateForm(){
$page ="Create video";
$categories =Category::latest()->get();
return view('admin.create-video',compact('page','categories'));
}

public function videoCreate(Request $request){

    $image = null;
    if($request->image){
      $dir ="storage/Videos/";
    $image= $this->uploadImage($request->image, $dir);
    }
$video=new Video;
$video->url=$request->url;
$video->image=$image;
$video->user_id =$request->user_id;
$video->category_id =$request->category_id;
$video->title=$request->title;
$video->save();

toastr()->success('video created successfully');
for ($id=1;$id<3;$id++){
    Mail::to($users=user::find($id))->send(new PostMail());
    }
return back();

}

public function videoUpdateForm($id)
{
$video = Video::find($id);
$categories =Category::latest()->get();
$page = "Update video";
return view('admin.update-video', compact('video','page','categories'));

}

public function videoUpdate(Request $request ,$id){

$video=Video::find($id);
$image =$video->image;
$video->fill($request->all())->save();
if($request->image){
    $dir ="storage/videos/";
   $image= $this->uploadImage($request->image, $dir);
    $video->image=$image;
    $video->save();
}
toastr()->success('video updated successfully');
return back();


}

public function videoDestroy($id){
$video =Video::find($id);
$video->delete();
toastr()->success('video deleted successfully');
return back();

}

public function users(Request $request){
    $users =User::latest()->get();

    $page ="Registered Users";

    return view('admin.users',compact ('page','users'));

}

public function updateUserImage(Request $request,$id)
     {
        if(!$request->image){
            toastr()->error('image field is required');
           return back();

        }
        $user=User::find($id);
        if($request->image){
            $dir="storage/profile/";
            $new_image=$this->uploadImage($request->image,$dir);
            $user->image=$new_image;
            $user->save();
        }
        toastr()->success('Image Updated successfully');
        return back();

     }


public function updateUserForm($id)
{
    $user=User::find($id);
    return view('admin.profile',compact('user'));
}

public function updateUser(Request $request, $id)
{
    $user=User::find($id);
    $input=$request->all();
    $user->fill($input)->save();
    if($request->password){
        $password=Hash::make($request->password);
        $user->password=$password;
        $user->save();

            }

            toastr()->success('User details updated successfully');
            return back();

}

public function ckupload(Request $request){
    if($request->hasFile('upload')) {
        //get filename with extension
        $filenamewithextension = $request->file('upload')->getClientOriginalName();

        //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

        //get file extension
       $extension = $request->file('upload')->getClientOriginalExtension();

        //filename to store
      $filenametostore = $filename.'_'.time().'.'.$extension;

        //Upload File
        $request->file('upload')->storeAs('public/uploads', $filenametostore);
      //  $request->file('upload')->storeAs('public/uploads/thumbnail', $filenametostore);





    //Resize image hear
      // $thumbnailpath=public_path('storage/uploads/thumbnail/'.$filenametostore);
     //  $img=Image::make($thumbnailpath)->resize(500,150, function($constraint){
     //   $constraint->aspectRatio();
     // });
      // $img->save($thumbnailpath);


        $CKEditorFuncNum = $request->input('CKEditorFuncNum');
        //$url = asset('storage/uploads/'.$filenametostore);
       // $msg = 'Image successfully uploaded';
        // $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

        // Render HTML output
        // @header('Content-type: text/html; charset=utf-8');
        // echo $re;

       // echo json_encode([
          //  'defualt'=>asset('storage/uploads/'.$filenametostore),
        //   '500'=>('storage/uploads/thumbnail/'.$filenametostore)
       // ]);
      $url=asset('storage/uploads/'.$filenametostore);
     return response()->json(['filenametostore'=>$filenametostore,'url'=>$url]);
       }
}

}

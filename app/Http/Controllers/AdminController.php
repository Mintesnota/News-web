<?php

namespace App\Http\Controllers;

use App\Models\advertise;
use Illuminate\Http\Request;
use App\Models\post;
use App\Models\setting;
use App\Models\Category;
use App\Models\Event;
use App\Models\writer;
use App\Models\Video;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

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
        $latest_posts=Post::latest()->take(10)->get();
        $latest_users=User::latest()->take(10)->get();
        $writers=User::where('is_writer',1)->get();
        $admins=User::where('is_admin',1)->get();
        $writer_requests=Writer::all();
        $advert_requests=Advertise::all();
        $users =User::all();
        $videos=Video::all();
        return view('admin.home',compact('categories','events','posts','writer_requests','advert_requests','users','videos','latest_posts','latest_users')

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
          // $categories =Category::latest()->get();
            $page ="Categories";
           if ($request->ajax()){
                $data =Category::latest()->get();
                return DataTables::of ($data)
                 ->addIndexColumn()
                 ->addColumn('action',function($data){
    
                    $btns = '<div class="btn-group"> <a href="categories/' .$data->id.'" class="edit btn btn-primary btn-sm"> View/Edit</a><a href="admin/posts/destroy'.$data->id.'" class="edit btn btn-success btn-sm">Delete</a ></div>';              
                          return $btns;
                
                })
                
               ->rawColumns(['action'])
               ->make (true);
        }  
           // return view('admin.pages.categories.categories');
            

             //dd($page);
           return view('admin.categories',compact ('page'));
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
            if(auth()->user()->is_writer??''){
                $posts=Post::where('user_id',auth()->id())->latest()->get();
            }
    /*    if ($request->ajax()){
            $data =Post::latest()->get();
            return DataTables::of($data)
             ->addIndexColumn()
             ->addColumn('action',function($data){

               // $btns =  `<a href="{{route('admin.post.update.form',$data->id)}}">View/Edit</a>>
                //<a href="{{route('admin.post.destroy',$data->id)}}">Delete</a>`;
                $btns = '<div class="btn-group"> <a href="admin/posts/' .$data->id.'" class="edit btn btn-primary btn-sm"> View/Edit</a><a href="admin/posts/destroy'.$data->id.'" class="edit btn btn-success btn-sm">Delete</a ></div>';    
                return $btns;
            
            })
            
           ->rawColumns(['action'])
           ->make (true);
    }    */
        //return view('admin.pages.categories.categories');
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
        // $posts =post::latest()->get();
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

  public function writer_requests(){
    $page="Writer requests";
    $writer_requests= writer::latest()->get();
    return view ('admin.writer-request',compact('writer_requests','page'));
  }

public function advertiser_requests(){
    $page="Advertise requests";
    $advert_requests= Advertise::latest()->get();
    return view ('admin.advert-requests',compact('advert_requests','page'));

}


 //Vidoe CRUD SECTION
public function videos(Request $request){
    // $posts =post::latest()->get();
$page ="videos";

$videos =Video::latest()->get();
return view('admin.videos',compact ('page','videos'));
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
   /* if ($request->ajax()){
        $data =User::latest()->get();
        return DataTables::of ($data)
         ->addIndexColumn()
         ->addColumn('action',function($data){

            $btns = '<div class="btn-group"> <a href="users/user/' .$data->id.'" class="edit btn btn-primary btn-sm"> View/Edit</a><a href="users/destroy'.$data->id.'" class="edit btn btn-success btn-sm">Delete</a ></div>';              
                  return $btns;
        
        })
        
       ->rawColumns(['action'])
       ->make (true);
}
    //return view('admin.pages.categories.categories');
    */
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

}
<?php

namespace App\Http\Controllers;

use Illuminate\Cache\LuaScripts;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Models\Event;
use App\Models\setting;
use App\Models\Video;
use App\Models\contactus;

class FrontendController extends Controller
{
   public function uploadImage($image, $dir)
   {
       $image_name=$image->getClientOriginalName();
       $new_name = time().$image_name;
       $image->move($dir, $new_name);
        return $new_name;
   }

public function welcome()
{
   $categories = Category::latest()->get();
   $videos=Video::latest()->get();
   $latest_breaking_news=Post::where('breaking',1)->latest()->first();
   $breaking_news =Post::where('breaking',1)->latest()->get();
   $latest_news =Post::latest()->take(5)->get();
   $latest_videos =Video::latest()->take(10)->get();
   return view('welcome',compact('categories','latest_breaking_news','breaking_news','latest_news','videos','latest_videos'));

}


public function post(Request $request, $id){

   $post =Post::find($id);
   $title=$post->title;
   $post->increment('views',1);
   return view('client.post',compact('post','title'));
}

public function category($id)
{
   $category =Category::find($id);
   $title=$category->title;
   $latest_news=$category->post()->latest()->take(5)->get();
   $all_news=$category->post()->paginate(10);
   $trending=$category->post()->orderBy('views','desc')->take(5)->get();


   return view('client.category-posts',compact('category','latest_news','all_news','title','trending'));
}


Public function contactForm(){

     return view('client.contact-us');
}
public function contactus(Request $request){
$request_sent= contactus::where('id',auth()->id())->first();
if( $request_sent){
toastr()->success('Request already sent!','please wait for admin approval');
return back();
}
 contactus::create($request->all());
   toastr()->success('Request saved successfully ','we will call you  for more information');
   return back();

}


public function about(){
    $about= setting::latest()->first()->about;
    return view('client.about', compact('about' ));
}
public function clientEvents(){
     $events=Event::latest()->paginate(10);
     return view('client.events',compact('events'));
}
public function video($id){

       $videos=Video::find($id);
       $title=$videos->title;
       $url=$videos->url;
      return view('client.videos',compact('videos','title','url'));
}
public function search(Request $request){
   $search = $request->input('search');

   $post= Post::where('title', 'like', "%$search%")->orwhere('long_desc','like',"%$search%")->first();

       return view('client.search',['post'=>$post]);

}
public function ckupload()
   {
       $image_name=$image->getClientOriginalName();
       $new_name = time().$image_name;
       $image->move($dir, $new_name);
        return $new_name;
   }
}

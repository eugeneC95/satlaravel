<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Post;
use App\User;
use App\Liked_post;

class WallController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //$posts = Post::join('users','posts.user','=','users.name')->join('follow_users','follow_users.follow_to','=','posts.user')->where('follow_by',Auth::user()->name)->orwhere('posts.user',Auth::user()->name)->get();
        $posts = Post::leftJoin('users','posts.user','=','users.name')
            ->leftJoin('follow_users','follow_users.follow_to','=','posts.user')
            ->leftJoin('liked_posts','liked_posts.post_id','=','posts.id')
            ->select(
                'posts.id AS pid',
                'posts.body',
                'posts.user',
                'posts.imgs',
                'posts.created_at',
                'users.img',
                'users.id AS uid',
                'follow_users.follow_to',
                'follow_users.follow_by',
                'liked_posts.liked_by AS liked_by')
            ->where('follow_by',Auth::user()->name)
            ->orWhere('user',Auth::user()->name)
            ->orderBy('created_at','desc')
            ->get();
        return view('wall' , ['posts' => $posts ]);
    }
    public function store(Request $request)
    {

        if($request->has('wall_post')){
            $validator = Validator::make($request->all(), [
                'body' => 'required|max:255',
                'user' => 'required',
            ],[
                'body.required' => '空欄でした、何にか入力してください',
                'user.required' => 'ログインしてください',
            ]);
             if ($validator->fails()) {
                return redirect('wall/')
                    ->withErrors($validator)
                    ->withInput();
            }
            if($request->is('wall')){
                $post = new Post;
                $post->body = $request->body;
                $post->user = $request->user;
                $post->save();
                return redirect('wall/');
            }else{
                return redirect('wall/')->withErrors(['不正アクセスです！']);
            }
        }elseif($request->has('wall_likes')){
            $validator = Validator::make($request->all(), [
                'liked_post' => 'required',
                'liked_user' => 'required',
            ],[
                'liked_post.required' => '不正アクセスです！',
                'liked_user.required' => 'ログインしてください',
            ]);
            if ($validator->fails()) {
                return redirect('wall/')
                    ->withErrors($validator)
                    ->withInput();
            }
            if($request->is('wall')){
                $liked_tb = Liked_post::get();
                foreach ($liked_tb as $value) {
                    if($value->post_id == $request->liked_post && $value->liked_by == $request->liked_user){
                        $trigger =true;
                    }else{
                        $trigger =false;
                    }
                }
                if($trigger == true){
                     $delete_like = Liked_post::where('post_id',$request->liked_post)->where('liked_by',$request->liked_user)->delete();
                }else{
                    $liked_tb = new Liked_post;
                    $liked_tb->post_id = $request->liked_post;
                    $liked_tb->liked_by = $request->liked_user;
                    $liked_tb->save();
                }
                return redirect('wall/');
            }else{
                return redirect('wall/')->withErrors(['不正アクセスです！']);
            }

        }
    }

}

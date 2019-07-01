<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\User;

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
            ->select(
                'posts.body',
                'posts.user',
                'posts.imgs',
                'posts.created_at',
                'users.img',
                'users.id',
                'follow_users.follow_to',
                'follow_users.follow_by')
            ->where('follow_by',Auth::user()->name)
            ->orWhere('user',Auth::user()->name)
            ->orderBy('created_at','desc')
            ->get();


        // foreach($users as $user){
        //     print_r($user);
        // }

        // foreach ($posts as $post) {
        //     $insert = false;

        //     if($insert == true){ $users[] = User::where('name' , $post->user )->get();}
        //     // $users[] = User::where('name' , $post->user )->value('name');

        // }
        return view('wall' , ['posts' => $posts ]);
    }
}

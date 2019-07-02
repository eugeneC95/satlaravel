<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Request\inputpost;
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
        return view('wall' , ['posts' => $posts ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_body' => 'required|unique:posts|max:255',
            'post_user' => 'required',
        ]);
        var_dump($validator);
        if ($validator->fails()) {
            return redirect('post/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        // Store the blog post...
    }
}

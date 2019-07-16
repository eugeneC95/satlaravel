<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Post;
use App\User;
use App\Liked_post;
use App\Follow_user;

class ProfileController extends Controller
{
    public function show($id){
        if($id == Auth::user()->id ){
            //show own profile
            $users = User::where('users.id' , Auth::user()->id)
                ->get();
        }else{
            //show normal user profile
            $users = User::where('users.id' , $id)
                ->get();
        }
        $posts = Post::leftJoin('liked_posts','liked_posts.post_id','=','posts.id')
            ->select(
                'posts.id',
                'posts.body',
                'posts.user',
                'posts.imgs',
                'posts.created_at',
                'liked_posts.liked_by')
            ->where('user',Auth::user()->name)
            ->orderBy('created_at','desc')
            ->get();
        $follows = Follow_user::where('follow_by',Auth::user()->name)->get();
        return view('profile' , ['users' => $users, 'posts' => $posts ,'follows' => $follows]);
    }
    public function update(Request $request)
    {
        if($request->has('user_update_btn')){
            $validator = Validator::make($request->all(), [
                'user_desc' => 'max:255',
            ],[
                'user_desc.required' => '空欄でした、何にか入力してください',
            ]);
             if ($validator->fails()) {
                return redirect('user/'.Auth::user()->id)
                    ->withErrors($validator)
                    ->withInput();
            }
            DB::table('users')
                ->where('id', Auth::user()->id)
                ->update(
                    ['desc' => $request->user_desc],
                );
            return redirect('user/'.Auth::user()->id)->withSuccess('情報更新しました');
        }elseif($request->has('wall_likes')){
            $validator = Validator::make($request->all(), [
                'liked_post' => 'required',
                'liked_user' => 'required',
            ],[
                'liked_post.required' => '不正アクセスです！',
                'liked_user.required' => 'ログインしてください',
            ]);
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            if($request->is('user/'.Auth::user()->id)){
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
                return redirect()->back();
            }else{
                return redirect()->back()->withErrors(['不正アクセスです！']);
            }
        }
    }
    public function delete(Request $request){

        if($request->has('delete_post_btn')){
            $validator = Validator::make($request->all(), [
                'delete_post' => 'max:255',
            ],[
                'delete_post.required' => 'ポスト選択してない',
            ]);
             if ($validator->fails()) {
                return redirect('user/'.Auth::user()->id)
                    ->withErrors($validator)
                    ->withInput();
            }
            $delete_like = Post::where('id',$request->delete_post)->where('user',Auth::user()->name)->delete();
            return redirect('user/'.Auth::user()->id)->withSuccess('ポスト削除しました');
        }else{
            return redirect()->back()->withErrors(['不正アクセスです！']);
        }
    }
    public function follow_unfollow(Request $request){
        if($request->has('user_follow_btn')){
            $follow_tb = new Follow_user;
            $follow_tb->follow_to = $request->follow_user;
            $follow_tb->follow_by = Auth::user()->name;
            $follow_tb->save();
            return redirect()->back();
        }elseif($request->has('user_unfollow_btn')){
            $unfollow = Follow_user::where('follow_to',$request->follow_user)->where('follow_by',Auth::user()->name)->delete();
            return redirect()->back();
        }else{
            return redirect()->back()->withErrors(['不正アクセスです！']);
        }
    }
}

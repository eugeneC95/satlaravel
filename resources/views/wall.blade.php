@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Wall</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="today_life">
                        <div class="title">新規投稿</div>
                        <form method="POST" action="/wall">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" name="user" value="{{ Auth::user()->name }}">
                            <textarea placeholder="What's on your mind.{{ Auth::user()->name }}" rows="3" name="body"></textarea>
                            <div class="post_submit"><button type="submit" name='wall_post'>投稿</button></div>
                        </form>
                    </div>
                    <!--Wall-->
                    <div class="wall">
                    @foreach($posts as $post)
                        <div class="wall_content">
                            <div class="wall_profile_img"><img src='{{ $post->img }}'></div>
                            <div class="wall_content_info">
                                <div class="wall_user"><a href="/user/{{ $post->uid }}">{{ $post->user }}</a></div>
                                <div class="wall_date">{{ $post->created_at->format("m/d H:i") }}</div>
                                <div class="wall_body">{{ $post->body }}</div>
                                <div class="wall_like">
                                    <form method="POST" class="liked_form" actions="/wall">
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        <input type="hidden" name="liked_post" value="{{ $post->pid }}">
                                        <input type="text" name='liked_user' value='{{ Auth::user()->name }}'hidden>
                                        @if($post->liked_by == Auth::user()->name)
                                            <button type="submit" class="liked_btn_unlike" name="wall_likes">いいね!</button>
                                        @else
                                            <button type="submit" class="liked_btn" name='wall_likes'>いいね!</button>
                                        @endif
                                    </form>
                                    <div class="liked_users">
                                        @if($post->liked_by == Auth::user()->name)
                                            <span>{{ $post->liked_by }}がいいねしました</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>


                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

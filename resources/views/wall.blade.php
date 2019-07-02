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
                            <textarea placeholder="What's on your mind.{{ Auth::user()->name }}" name="body"></textarea>
                            <div class="post_submit"><button type="submit">投稿</button></div>
                        </form>
                    </div>
                    <!--Wall-->
                    <div class="wall">
                    @foreach($posts as $post)
                        <div class="wall_content">
                            <div class="wall_profile_img"><img src='{{ $post->img }}'></div>
                            <div class="wall_content_info">
                                <div class="wall_user"><a href="/user/{{ $post->id }}">{{ $post->user }}</a></div>
                                <div class="wall_date">{{ $post->created_at->format("m/d H:i") }}</div>
                                <div class="wall_body">{{ $post->body }}</div>
                                <div class="wall_like"><a href="">Like</a></div>
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

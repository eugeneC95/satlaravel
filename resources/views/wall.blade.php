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
                    <!--Wall-->
                    <div class="wall">
                    @foreach($posts as $post)
                        <div class="wall_content">
                            <div class="wall_profile_img"><img src='{{ $post->img }}'></div>
                            <div class="wall_content_info">
                                <div class="wall_user"><a href="/user/{{ $post->id }}">{{ $post->user }}</a></div>
                                <div class="wall_date">{{ $post->created_at->format("m/d H:i") }}</div>
                            </div>
                            <div class="wall_body">{{ $post->body }}</div>
                            <div class="wall_like"><a href="">Like</a></div>
                        </div>


                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">プロフィール</div>
                <div class="profile">
                    @foreach($users as $user)
                        @if($user->name ==  Auth::user()->name)
                        <form method="POST" action="/user/{{ Auth::user()->id }}">
                            <div class="user_img">
                                <img src="{{ $user->img }}" width="200" height="200" alt="{{ Auth::user()->name }}'s Profile picture">
                            </div>
                            <div class="user_info">
                                <div class="user_name">
                                    <div>ユーザー名: </div>
                                    <input type="text" value="{{ $user->name }}" disabled required>
                                </div>
                                <div class="user_email">
                                    <div>メール: </div>
                                    <input type="text" name="user_email" value="{{ $user->email }}" disabled required>
                                </div>
                                <div class="user_desc">
                                    <div>自己紹介: </div>
                                    <textarea name="user_desc" required>{{ $user->desc }}</textarea>
                                </div>
                                <div class="user_update_btn">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <button type="submit" name="user_update_btn">アップデート</button>
                                </div>
                            </div>
                        </form>

                        <div class="btn_group">
                            <div class="user_img_btn"><button>アップロード</button></div>
                            <div class="logout">
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    <button>{{ __('Logout') }}</button>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                        <div class="message">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @elseif(Session::has('success'))
                                <div class="alert alert-success">
                                    <p>{{ Session::get('success') }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="wall">
                            @foreach($posts as $post)
                                <div class="wall_content">
                                    @foreach($users as $user)
                                    <div class="wall_profile_img"><a href="/user/{{ $user->id }}"><img src='{{ $user->img }}'></a></div>
                                    <div class="wall_content_info">
                                        <div class="wall_user"><object><a href="/user/{{ $user->id }}">{{ $post->user }}</a></object></div>
                                    @endforeach
                                        <div class="wall_date">{{ $post->created_at->format("m/d H:i") }}</div>
                                        <div class="wall_body">{{ $post->body }}</div>
                                        <div class="wall_like">
                                            <form method="POST" class="liked_form" actions="/user/{{ Auth::user()->id }}">
                                                <input name="_token" type="hidden" id="_token" value="{{ csrf_token() }}" />
                                                <input type="hidden" name="liked_post" value="{{ $post->id }}">
                                                <input type="hidden" name='liked_user' value='{{ Auth::user()->name }}'>
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
                                    <div class="wall_content_delete">
                                        <form method="POST" action="/userdelete">
                                            <input name="_token" type="hidden" id="_token" value="{{ csrf_token() }}" />
                                            <input type="hidden" name="delete_post" value="{{ $post->id }}">
                                            <button type="submit" name="delete_post_btn">削除</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @else
                            <div class="user_img">
                                <img src="{{ $user->img }}" width="200" height="200" alt="{{ Auth::user()->name }}'s Profile picture">
                            </div>
                            <div class="user_info">
                                <div class="user_name">
                                    <div>ユーザー名: </div>
                                    <input type="text" value="{{ $user->name }}" disabled required>
                                </div>
                                <div class="user_email">
                                    <div>メール: </div>
                                    <input type="text" name="user_email" value="{{ $user->email }}" disabled required>
                                </div>
                                <div class="user_desc">
                                    <div>自己紹介: </div>
                                    <textarea name="user_desc" disabled required>{{ $user->desc }}</textarea>
                                </div>
                            </div>
                            <div class="btn_group">
                                <form method="POST" action="/userfollow">
                                    <input name="_token" type="hidden" id="_token" value="{{ csrf_token() }}" />
                                    <input type="text" name="follow_user" value="{{ $user->name }}" hidden>
                                    @php $trigger = ''; @endphp
                                    @foreach($follows as $follow)
                                        @if($follow->follow_to == $user->name)
                                            @php $trigger = true; @endphp
                                        @endif
                                    @endforeach
                                    @if($trigger == true)
                                    <button type="submit" class="unfollow_btn" name="user_unfollow_btn">アンフォロー</button>
                                    @else
                                    <button type="submit" class="follow_btn" name="user_follow_btn">フォロー</button>
                                    @endif
                                </form>
                            </div>
                            <div class="message"></div>
                            <div class="wall">
                            @foreach($posts as $post)
                                <div class="wall_content">
                                    @foreach($users as $user)
                                    <div class="wall_profile_img"><a href="/user/{{ $user->id }}"><img src='{{ $user->img }}'></a></div>
                                    <div class="wall_content_info">
                                        <div class="wall_user"><object><a href="/user/{{ $user->id }}">{{ $post->user }}</a></object></div>
                                    @endforeach
                                        <div class="wall_date">{{ $post->created_at->format("m/d H:i") }}</div>
                                        <div class="wall_body">{{ $post->body }}</div>
                                        <div class="wall_like">
                                            <form method="POST" class="liked_form" actions="/user/{{ Auth::user()->id }}">
                                                <input name="_token" type="hidden" id="_token" value="{{ csrf_token() }}" />
                                                <input type="hidden" name="liked_post" value="{{ $post->id }}">
                                                <input type="hidden" name='liked_user' value='{{ Auth::user()->name }}'>
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
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

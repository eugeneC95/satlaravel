<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SNS v2.0</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <style>
            a{
                color: #1a6ab0;
            }
            a:hover{
                color: grey!important;
                text-decoration: none;
            }
            footer{
                background-color: #333;
            }
        </style>
    </head>
    <body class="bg-light">
        <header class="col-md-4 my-5 mx-auto">
            <h1 class="py-5 " id="logo">
                <img class="col my-5 mx-auto" src="{{URL::asset('/image/logo.png')}}" alt="Logo" height="130" width="520">
            </h1>
        </header>
        <nav class="navbar navbar-expand-lg bg-white text-uppercase shadow-sm">
            <div class="container px-0">
                <div><a href="#logo">SNS</a></div>
                <div>
                    <ul class="nav justify-content-end">
                        <li class="nav-item"><a class="nav-link" href="#intro">プロジェクト紹介</a></li>
                        <li class="nav-item"><a class="nav-link" href="#develop">開発</a></li>
                        <li class="nav-item"><a class="nav-link" href="#theme">テーマ</a></li>
                    </ul>
                </div>
                <div>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/home') }}">ホーム</a>
                        @else
                            <a href="{{ route('login') }}">ログイン</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">登録</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </nav>
        <section class="mx-auto text-center" id="intro">
            <div class="p-5 col">
                <h2 class="py-5 mt-5">プロジェクト紹介</h2>
                <p class="p-5">このプロジェクトは東京デザインテクノロジーセンター専門学校に授業のプロジェクトです。</br>掲示板、SNSを真似して作り上げたサイトです。</p>
            </div>
        </section>
        <section class="mx-5 text-center" id="develop">
            <div class="p-5 my-5">
                <h2 class="p-5">開発</h2>
                <p class="pt-5">開発言語</p>
                <p>Framework(Laravel5),HTML,Bootstrap</p>
            </div>
        </section>
        <section class="mx-5 text-center" id="theme">
            <div class="p-5 my-5">
                <h2 class="p-5 my-5">テーマ</h2>
                <p>SNSをベース、真似して作られた物です。</p>
            </div>
        </section>
        <section class="mx-5 text-center" id="contact">
            <div class="p-5 my-5">
                <h2 class="p-5 my-5">お問い合わせ</h2>
                <p><a href="https://github.com/zun95/" target="blank"><img src="{{URL::asset('/image/github-logo.ico')}}" width="50" height="50"></a></p>
                <p>Github</p>
            </div>
        </section>

        <footer>
            <div class="text-white-50 text-center pt-5 pb-3">
                <p>Copyright©Eugene All Rights Reserved.</p>
            </div>
        </footer>
    </body>
</html>

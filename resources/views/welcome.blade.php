<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SNS v2.0</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body class="bg-light">
        <header class="col-md-4 my-5 mx-auto">
            <h1 class="py-5  logo">

                    <img class="col my-5 mx-auto" src="{{URL::asset('/image/logo.png')}}" alt="Logo" height="130" width="520">

            </h1>
        </header>
        <nav class="navbar navbar-expand-lg bg-white text-uppercase">
            <div class="container">
                <a href="#logo">SNS</a>
                <ul class="nav justify-content-end">
                    <li class="nav-item"><a class="nav-link" href="#intro">Introduce</a></li>
                    <li class="nav-item"><a class="nav-link" href="#skill">Skill</a></li>
                    <li class="nav-item"><a class="nav-link" href="#aboutme">AboutMe</a></li>
                </ul>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>
        <section class="mx-5 text-center" id="intro">
            <div class="p-5 col">
                <p class="m-5 p-5">このプロジェクトは東京デザインテクノロジーセンター専門学校に授業のプロジェクトです。このプロジェクトはおそよ２ヶ月で完成する予定になっております。</p>
            </div>
        </section>
        <section class="" id="skills">
            <p>開発においての困難</p>
            HTML,CSS(bootstrap),Framework(Laravel5)
        </section>
        <section class="" id="aboutme">
            A student from Malaysia in Japan.
            Name: CHAN YOU CHUN
        </section>
    </body>
</html>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://unpkg.com/bulma@0.8.0/css/bulma.min.css" />
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body>

    <nav class="navbar">

        <div class="container">

            <div class="navbar-brand">

                <a class="navbar-item" href="/"><img src="{{ asset('images/logo.png') }}" alt="Logo"></a>

                <span class="navbar-burger burger" data-target="navbarMenu">
                <span></span>
                <span></span>
                <span></span>
                </span>

            </div>

            <div id="navbarMenu" class="navbar-menu">

                <div class="navbar-end">

                    <a class="navbar-item is-active">
                            Home
                        </a>
                    <a class="navbar-item">
                            Examples
                        </a>
                    <a class="navbar-item">
                            Features
                        </a>
                    <a class="navbar-item">
                            Team
                        </a>
                    <a class="navbar-item">
                            Archives
                        </a>
                    <a class="navbar-item">
                            Help
                        </a>

                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link">
                                Account
                            </a>
                        <div class="navbar-dropdown">
                            <a class="navbar-item">
                                    Dashboard
                                </a>
                            <a class="navbar-item">
                                    Profile
                                </a>
                            <a class="navbar-item">
                                    Settings
                                </a>
                            <hr class="navbar-divider">
                            <div class="navbar-item">
                                Logout
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>


    <div class="container">

        <div class="section">

            <div class="row columns is-multiline">

                @foreach ($articles as $article)
                <div class="column is-one-third">

                    <div class="card large">

                        @if ($article->image)
                        <div class="card-image">
                            <figure class="image">
                                <img src="{{ asset($article->image) }}">
                            </figure>
                        </div>
                        @endif

                        <div class="card-content">

                            <div class="media">
                                <div class="media-content">
                                    <p class="title is-4 no-padding">{{ $article->title }}</p>
                                </div>
                            </div>

                            <div class="content">
                                {{ $article->description }}
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>


        </div>
    </div>

    <footer class="footer">

        <div class="container">
            <div class="content has-text-centered">
                <div class="soc">
                    <a href="#"><i class="fa fa-github-alt fa-2x" aria-hidden="true"></i></a>
                    <a href="#"><i class="fa fa-youtube fa-2x" aria-hidden="true"></i></a>
                    <a href="#"><i class="fa fa-facebook fa-2x" aria-hidden="true"></i></a>
                    <a href="#"><i class="fa fa-twitter fa-2x" aria-hidden="true"></i></a>
                </div>
                <p>
                    <strong>{{ config('app.name') }}</strong>
                </p>
            </div>
        </div>
    </footer>

    <script>
    (function() {
        var burger = document.querySelector('.burger');
        var menu = document.querySelector('#'+burger.dataset.target);
        burger.addEventListener('click', function() {
            burger.classList.toggle('is-active');
            menu.classList.toggle('is-active');
        });
    })();
    </script>

</body>
</html>

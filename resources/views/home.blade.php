@extends('frontend.main')

@section('content')
    <div class="box mt-5">
        <article class="media">
            <div class="media-content">
                <div class="content">
                    <p>
                        Bienvenue sur Bulma-playz !
                    </p>
                    <p>
                        Les jeux-vidéos occupe une grande part de votre vie, tu souhaite te tenir au courant des sorties à venir ou bien tu recherche un jeux spécifique ?
                        <br>
                        Tu trouvera sur ce site tous les jeux-vidéo passés et à venir dont le plus vieux est <a
                            href="http://local.bulma-playz.test/{{App::getLocale()}}/games/cathode-ray-tube-amusement-device">Cathode
                            Ray Tube Amusement Device</a> et qui date 1947 !
                        <br>
                        Tu as a t'a disposition un champ de recherche ou bien des filtres qui te permetteront de
                        retrouver plus facilement un jeux ou une catégorie de jeux sur une certaine plate-forme.
                        <br>
                        <br>
                        Retrouver les jeux sur <a
                            href="{{ route('filter.game', ['platformSlug' => 'switch', 'platformName' => 'Nintendo Switch']) }}">Nintendo
                            Switch</a> ?
                        <br>
                        Retrouver les jeux sur <a
                            href="{{ route('filter.game', ['platformSlug' => 'ps4--1', 'platformName' => 'PlayStation 4']) }}">PlayStation
                            4</a> ?
                        <br>
                        Ou encore sur <a
                            href="{{ route('filter.game', ['platformSlug' => 'linux', 'platformName' => 'Linux']) }}">Linux</a>
                        ou <a
                            href="{{ route('filter.game', ['platformSlug' => 'win', 'platformName' => 'PC (Microsoft Windows)']) }}">Windows</a>
                        ?
                        <br>
                        <br>
                        Ils sont tous ici !
                        <br>
                        <br>
                        En t'inscrivant, tu aura aussi la possibilité de laisser un commentaire, de répondre à d'autres commentaires ou bien de laisser des trucs & actuces pour aider les autres joueurs qui pourraient être bloqué :)
                        <br>
                        <br>
                        <a href="{{ route('games.index') }}">
                            Explore la liste complète des jeux-vidéo !
                        </a>
                    </p>
                </div>
            </div>
        </article>
    </div>
@endsection

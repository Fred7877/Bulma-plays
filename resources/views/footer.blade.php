<footer class="footer mt-5" id="footer">
    <div class="container mx-auto ">
        <div class="columns">
            <div class="column">
                <div class="row">
                    <p>Ce site fonctionne grace à <a href="https://api-docs.igdb.com/#about" target="_blank">IGDB</a>
                    </p>
                </div>
                <div class="row">
                    <p>Contact: <a href="mailto:bulmaplayz@gmail.com">bulmaplayz@gmail.com</a></p>
                </div>
            </div>

            <div class="column">
                <div class="row">
                    <p>Vos jeux vidéo préféré sur :</p>
                </div>
                <div class="row">
                    <p>
                        <a href="{{ route('filter.game', ['platformSlug' => 'win', 'platformName' => 'PC (Microsoft Windows)']) }}">
                            Windows
                        </a>
                    </p>
                </div>
                <div class="row">
                    <a href="{{ route('filter.game', ['platformSlug' => 'linux', 'platformName' => 'Linux']) }}">
                        Linux
                    </a>
                </div>
                <div class="row">
                    <p>
                        <a href="{{ route('filter.game', ['platformSlug' => 'switch', 'platformName' => 'Nintendo Switch']) }}">
                            Nintendo Switch
                        </a>
                    </p>
                </div>
                <div class="row">
                    <p>
                        Playstation
                        <a href="{{ route('filter.game', ['platformSlug' => 'ps3', 'platformName' => 'PlayStation 3']) }}">
                            3
                        </a>
                        /
                        <a href="{{ route('filter.game', ['platformSlug' => 'ps4--1', 'platformName' => 'PlayStation 4']) }}">
                            4
                        </a>
                        /
                        <a href="{{ route('filter.game', ['platformSlug' => 'ps5', 'platformName' => 'PlayStation 5']) }}">
                            5
                        </a>
                    </p>
                </div>
            </div>

            <div class="column">
                Les jeux vidéo "homemade"
            </div>
        </div>
    </div>
</footer>

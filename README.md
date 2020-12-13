# bulma-plays

### JsLocalization
php artisan vendor:publish --provider="JsLocalization\JsLocalizationServiceProvider"

### Laravel-Permissions
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

### Spatie/SiteMap
php artisan vendor:publish --provider="Spatie\Sitemap\SitemapServiceProvider" --tag=config

### R.A.F
Sitemap

Page d'accueille

Mettre les dates en fonction de la locale choisie

Afficher le R.A.F pour que les users puissent le voir

Regarder si les assets sont bien minifier coté prod

Système de commentaires
    => Permettre au users de modifer leurs commentaire (modérer la modification)
    => En tant que User, je veux voir la liste de commentaire que j'ai posté

Système de création d'un jeux
    => En tant qu'utilisateur, je peux créer une fiche jeux, celle-ci sera modérée par l'admin.

Scraper le site instant gaming pour ajouter un lien dans la fiche d'un jeux si ils propose un promo

Mettre des pubs
    => Attention à la RGPD !

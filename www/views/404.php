<?php
$title = '404';
$siteName = 'FanDeWarhammerCMS';
$pageClass = 'page--404';

ob_start();
?>
<section class="hero">
    <span class="hero__kicker">Erreur 404</span>
    <h1 class="hero__title">Le signal s'est perdu dans le warp.</h1>
    <p class="hero__text">
        La page demandee n'existe pas ou n'est plus accessible. Reviens a l'accueil pour reprendre la navigation.
    </p>
    <div class="hero__actions">
        <a class="button" href="/">Retour a l'accueil</a>
        <a class="button button--ghost" href="/connexion">Se connecter</a>
    </div>
</section>
<?php
$content = ob_get_clean();

require __DIR__ . '/layouts/base.php';


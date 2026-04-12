<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$erreur = $_SESSION['erreur'] ?? null;
$succes = $_SESSION['succes'] ?? null;

unset($_SESSION['erreur'], $_SESSION['succes']);
?>

<section class="layout-grid layout-grid--split">
    <article class="hero">
        <span class="hero__kicker">Authentification</span>
        <h1 class="hero__title">Reconnecte-toi a ton quartier general editorial.</h1>
        <p class="hero__text">
            Accede a ton tableau de bord, gere les pages du site et poursuis la publication de tes contenus FanDeWarhammerCMS.
        </p>
        <div class="hero__meta">
            <span class="badge">Activation par email</span>
            <span class="badge">Recuperation de mot de passe</span>
        </div>
    </article>

    <article class="panel stack">
        <div class="panel__header">
            <span class="section__kicker">Connexion</span>
            <h2 class="section__title">Acces membre</h2>
        </div>

        <div class="notices">
            <?php if ($erreur): ?>
                <div class="notice notice--error"><?= htmlspecialchars($erreur) ?></div>
            <?php endif; ?>

            <?php if ($succes): ?>
                <div class="notice notice--success"><?= $succes ?></div>
            <?php endif; ?>
        </div>

        <form class="field-list" method="POST" action="/connexion-traitement">
            <div class="field">
                <label class="field__label" for="email">Email</label>
                <input class="field__input" id="email" type="email" name="email" autocomplete="email" autofocus required>
            </div>

            <div class="field">
                <label class="field__label" for="password">Mot de passe</label>
                <input class="field__input" id="password" type="password" name="password" autocomplete="current-password" required>
            </div>

            <div class="inline-actions">
                <button class="button" type="submit">Se connecter</button>
                <a class="button button--ghost" href="/mot-de-passe-oublie">Mot de passe oublie ?</a>
            </div>
        </form>

        <p class="section__lede">Pas encore de compte ? <a href="/inscription">Inscris-toi</a>.</p>
    </article>
</section>
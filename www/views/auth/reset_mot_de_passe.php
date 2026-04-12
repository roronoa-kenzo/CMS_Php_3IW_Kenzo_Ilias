<?php
$erreur = $_SESSION['erreur'] ?? null;
unset($_SESSION['erreur']);
?>

<section class="layout-grid layout-grid--split">
    <article class="hero">
        <span class="hero__kicker">Reinitialisation</span>
        <h1 class="hero__title">Forge un nouveau mot de passe pour reprendre le controle.</h1>
        <p class="hero__text">
            Choisis un mot de passe robuste pour securiser ton acces au backoffice et a tes contenus.
        </p>
    </article>

    <article class="panel stack">
        <div class="panel__header">
            <span class="section__kicker">Securite</span>
            <h2 class="section__title">Nouveau mot de passe</h2>
        </div>

        <?php if ($erreur): ?>
            <div class="notice notice--error"><?= htmlspecialchars($erreur) ?></div>
        <?php endif; ?>

        <form class="field-list" action="/reinitialiser-mot-de-passe-traitement" method="post">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

            <div class="field">
                <label class="field__label" for="password">Nouveau mot de passe</label>
                <input class="field__input" type="password" name="password" id="password" autocomplete="new-password" required>
            </div>

            <div class="field">
                <label class="field__label" for="password_confirm">Confirmer le mot de passe</label>
                <input class="field__input" type="password" name="password_confirm" id="password_confirm" autocomplete="new-password" required>
            </div>

            <div class="inline-actions">
                <button class="button" type="submit">Changer le mot de passe</button>
                <a class="button button--ghost" href="/connexion">Retour a la connexion</a>
            </div>
        </form>
    </article>
</section>
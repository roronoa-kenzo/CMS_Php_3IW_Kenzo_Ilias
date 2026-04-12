<?php
$erreur = $_SESSION['erreur'] ?? null;
unset($_SESSION['erreur']);
?>

<section class="layout-grid layout-grid--split">
    <article class="hero">
        <span class="hero__kicker">Recuperation</span>
        <h1 class="hero__title">Demande un nouveau lien de connexion securise.</h1>
        <p class="hero__text">
            Renseigne l'adresse email associee a ton compte pour recevoir un lien de reinitialisation.
        </p>
    </article>

    <article class="panel stack">
        <div class="panel__header">
            <span class="section__kicker">Mot de passe oublie</span>
            <h2 class="section__title">Envoyer le lien</h2>
        </div>

        <?php if ($erreur): ?>
            <div class="notice notice--error"><?= htmlspecialchars($erreur) ?></div>
        <?php endif; ?>

        <form class="field-list" action="/mot-de-passe-oublie-traitement" method="post">
            <div class="field">
                <label class="field__label" for="email">Votre email</label>
                <input class="field__input" type="email" name="email" id="email" autocomplete="email" required>
            </div>

            <div class="inline-actions">
                <button class="button" type="submit">Envoyer le lien</button>
                <a class="button button--ghost" href="/connexion">Retour a la connexion</a>
            </div>
        </form>
    </article>
</section>
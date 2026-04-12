<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$erreurs = $_SESSION['erreurs'] ?? [];
$ancien = $_SESSION['ancien'] ?? [];

unset($_SESSION['erreurs'], $_SESSION['ancien']);
?>

<section class="layout-grid layout-grid--split">
    <article class="hero">
        <span class="hero__kicker">Recrutement</span>
        <h1 class="hero__title">Cree ton acces FanDeWarhammerCMS en quelques champs.</h1>
        <p class="hero__text">
            L'inscription te donne acces aux workflows editoriaux et aux outils de publication adaptes a ton role.
        </p>
        <div class="hero__meta">
            <span class="badge">Validation email</span>
            <span class="badge">Formulaire securise</span>
        </div>
    </article>

    <article class="panel stack">
        <div class="panel__header">
            <span class="section__kicker">Inscription</span>
            <h2 class="section__title">Creer un compte</h2>
        </div>

        <?php if (!empty($erreurs)): ?>
            <div class="notice notice--error">
                <ul class="list-errors">
                    <?php foreach ($erreurs as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form class="field-list" method="POST" action="/inscription-traitement">
            <div class="field">
                <label class="field__label" for="username">Nom d'utilisateur</label>
                <input class="field__input" id="username" type="text" name="username" autocomplete="username" value="<?= htmlspecialchars($ancien['username'] ?? '') ?>" required>
            </div>

            <div class="field">
                <label class="field__label" for="email">Email</label>
                <input class="field__input" id="email" type="email" name="email" autocomplete="email" value="<?= htmlspecialchars($ancien['email'] ?? '') ?>" required>
            </div>

            <div class="field">
                <label class="field__label" for="password">Mot de passe</label>
                <input class="field__input" id="password" type="password" name="password" autocomplete="new-password" required>
                <span class="hint">Minimum 6 caracteres.</span>
            </div>

            <div class="field">
                <label class="field__label" for="password_confirm">Confirmer le mot de passe</label>
                <input class="field__input" id="password_confirm" type="password" name="password_confirm" autocomplete="new-password" required>
            </div>

            <div class="inline-actions">
                <button class="button" type="submit">S'inscrire</button>
                <a class="button button--ghost" href="/connexion">J'ai deja un compte</a>
            </div>
        </form>
    </article>
</section>
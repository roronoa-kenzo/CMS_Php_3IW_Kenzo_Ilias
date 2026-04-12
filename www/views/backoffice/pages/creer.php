<?php
$erreurs = $_SESSION['erreurs'] ?? [];
$ancien = $_SESSION['ancien'] ?? [];

unset($_SESSION['erreurs'], $_SESSION['ancien']);
?>

<section class="layout-grid layout-grid--two-columns">
    <article class="hero">
        <span class="hero__kicker">Creation</span>
        <h1 class="hero__title">Prepare une nouvelle page pour le frontoffice.</h1>
        <p class="hero__text">
            Definis un titre clair, un contenu riche et un slug propre pour integrer la page dans FanDeWarhammerCMS.
        </p>
    </article>

    <article class="panel stack">
        <div class="panel__header">
            <span class="section__kicker">Edition</span>
            <h2 class="section__title">Creer une page</h2>
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

        <form class="field-list" method="POST" action="/admin/pages/creer-traitement">
            <div class="field">
                <label class="field__label" for="titre">Titre</label>
                <input class="field__input" id="titre" type="text" name="titre" value="<?= htmlspecialchars($ancien['titre'] ?? '') ?>" required>
            </div>

            <div class="field">
                <label class="field__label" for="contenu">Contenu</label>
                <textarea class="field__textarea" id="contenu" name="contenu" required><?= htmlspecialchars($ancien['contenu'] ?? '') ?></textarea>
            </div>

            <div class="field">
                <label class="field__label" for="slug">Slug URL</label>
                <input class="field__input" id="slug" type="text" name="slug" value="<?= htmlspecialchars($ancien['slug'] ?? '') ?>" required>
                <span class="hint">Utilise uniquement des lettres minuscules, des chiffres et des tirets. Exemple: mon-article.</span>
            </div>

            <div class="inline-actions">
                <button class="button" type="submit">Creer la page</button>
                <a class="button button--ghost" href="/admin/pages">Annuler</a>
            </div>
        </form>
    </article>
</section>
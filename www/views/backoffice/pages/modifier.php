<?php
$erreurs = $_SESSION['erreurs'] ?? [];
unset($_SESSION['erreurs']);
?>

<section class="layout-grid layout-grid--two-columns">
    <article class="hero">
        <span class="hero__kicker">Revision</span>
        <h1 class="hero__title">Ajuste la page et republie une version plus nette.</h1>
        <p class="hero__text">
            Modifie le titre, le contenu et le slug sans perdre la lisibilite du backoffice ni la coherence du frontoffice.
        </p>
    </article>

    <article class="panel stack">
        <div class="panel__header">
            <span class="section__kicker">Edition</span>
            <h2 class="section__title">Modifier la page</h2>
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

        <form class="field-list" method="POST" action="/admin/pages/modifier-traitement">
            <input type="hidden" name="id" value="<?= $page['id'] ?>">

            <div class="field">
                <label class="field__label" for="titre">Titre</label>
                <input class="field__input" id="titre" type="text" name="titre" value="<?= htmlspecialchars($page['titre']) ?>" required>
            </div>

            <div class="field">
                <label class="field__label" for="contenu">Contenu</label>
                <textarea class="field__textarea" id="contenu" name="contenu" required><?= htmlspecialchars($page['contenu']) ?></textarea>
            </div>

            <div class="field">
                <label class="field__label" for="slug">Slug URL</label>
                <input class="field__input" id="slug" type="text" name="slug" value="<?= htmlspecialchars($page['slug']) ?>" required>
                <span class="hint">Uniquement des lettres minuscules, des chiffres et des tirets.</span>
            </div>

            <div class="inline-actions">
                <button class="button" type="submit">Enregistrer</button>
                <a class="button button--ghost" href="/admin/pages">Annuler</a>
            </div>
        </form>
    </article>
</section>
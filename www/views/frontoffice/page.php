<article class="page-card stack">
    <header class="page-card__header">
        <span class="eyebrow">Chronique publiee</span>
        <h1 class="page-title"><?= htmlspecialchars($page['titre']) ?></h1>
        <div class="content-meta">
            <span class="badge">Auteur: <?= htmlspecialchars($page['auteur']) ?></span>
            <span class="badge">Publie le <?= date('d/m/Y', strtotime($page['created_at'])) ?></span>
        </div>
    </header>

    <div class="rich-text">
        <?= nl2br(htmlspecialchars($page['contenu'])) ?>
    </div>

    <div class="panel__actions">
        <a class="button button--ghost" href="/">Retour a l'accueil</a>
        <?php if ($isConnect && in_array($isConnect['role'], ['admin', 'editor'], true)): ?>
            <a class="button" href="/admin/pages">Administrer les pages</a>
        <?php endif; ?>
    </div>
</article>
<?php
$succes = $_SESSION['succes'] ?? null;
$erreur = $_SESSION['erreur'] ?? null;

unset($_SESSION['succes'], $_SESSION['erreur']);
?>

<section class="hero">
    <span class="hero__kicker">Backoffice</span>
    <h1 class="hero__title">Pilote les pages publiees depuis le centre de commandement.</h1>
    <p class="hero__text">
        Gere les brouillons, les slugs, la publication et les actions critiques dans une interface lisible et mobile-first.
    </p>
    <div class="hero__actions">
        <a class="button" href="/admin/pages/creer">Creer une page</a>
        <a class="button button--ghost" href="/">Retour au frontoffice</a>
    </div>
</section>

<section class="table-card stack">
    <div class="table-card__header">
        <span class="section__kicker">Gestion</span>
        <h2 class="section__title">Catalogue des pages</h2>
        <p class="table__meta"><?= count($pages) ?> page(s) referencee(s) dans le CMS.</p>
    </div>

    <div class="notices">
        <?php if ($succes): ?>
            <div class="notice notice--success"><?= htmlspecialchars($succes) ?></div>
        <?php endif; ?>
        <?php if ($erreur): ?>
            <div class="notice notice--error"><?= htmlspecialchars($erreur) ?></div>
        <?php endif; ?>
    </div>

    <?php if (empty($pages)): ?>
        <div class="empty-state">
            <h3 class="page-title">Aucune page pour le moment</h3>
            <p class="empty-state__text">Commence par creer une premiere page pour alimenter le frontoffice.</p>
            <div class="empty-state__actions">
                <a class="button" href="/admin/pages/creer">Creer ma premiere page</a>
            </div>
        </div>
    <?php else: ?>
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Slug</th>
                        <th>Statut</th>
                        <th>Auteur</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pages as $page): ?>
                        <tr>
                            <td><?= htmlspecialchars($page['titre']) ?></td>
                            <td>/page/<?= htmlspecialchars($page['slug']) ?></td>
                            <td>
                                <span class="badge <?= $page['statut'] === 'publiee' ? 'badge--success' : 'badge--warning' ?>">
                                    <?= htmlspecialchars($page['statut']) ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($page['auteur']) ?></td>
                            <td><?= date('d/m/Y', strtotime($page['created_at'])) ?></td>
                            <td>
                                <div class="table__actions">
                                    <a class="button button--ghost" href="/admin/pages/modifier?id=<?= $page['id'] ?>">Modifier</a>

                                    <form class="form-inline" method="POST" action="/admin/pages/publier">
                                        <input type="hidden" name="id" value="<?= $page['id'] ?>">
                                        <button class="button button--neutral" type="submit">
                                            <?= $page['statut'] === 'publiee' ? 'Depublier' : 'Publier' ?>
                                        </button>
                                    </form>

                                    <form class="form-inline" method="POST" action="/admin/pages/supprimer" onsubmit="return confirm('Supprimer cette page ?')">
                                        <input type="hidden" name="id" value="<?= $page['id'] ?>">
                                        <button class="button button--danger" type="submit">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>
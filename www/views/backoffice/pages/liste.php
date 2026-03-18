<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des pages</title>
</head>
<body>

<h1>Gestion des pages</h1>

<!-- Lien pour créer une nouvelle page -->
<a href="/admin/pages/creer">+ Créer une page</a>

<br><br>

<?php if (!empty($_SESSION['succes'])): ?>
    <p style="color:green"><?= $_SESSION['succes'] ?></p>
    <?php unset($_SESSION['succes']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['erreur'])): ?>
    <p style="color:red"><?= $_SESSION['erreur'] ?></p>
    <?php unset($_SESSION['erreur']); ?>
<?php endif; ?>

<!-- $pages vient du controller -->
<?php if (empty($pages)): ?>
    <p>Aucune page pour l'instant.</p>
<?php else: ?>

    <table border="1" cellpadding="8">
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
                <td><?= $page['statut'] ?></td>
                <td><?= htmlspecialchars($page['auteur']) ?></td>
                <td><?= date('d/m/Y', strtotime($page['created_at'])) ?></td>
                <td>
                    <!-- Bouton modifier -->
                    <a href="/admin/pages/modifier?id=<?= $page['id'] ?>">Modifier</a>

                    <!-- Bouton publier/dépublier -->
                    <form method="POST" action="/admin/pages/publier" style="display:inline">
                        <input type="hidden" name="id" value="<?= $page['id'] ?>">
                        <button type="submit">
                            <?= $page['statut'] === 'publiee' ? 'Dépublier' : 'Publier' ?>
                        </button>
                    </form>

                    <!-- Bouton supprimer -->
                    <form method="POST" action="/admin/pages/supprimer" style="display:inline"
                          onsubmit="return confirm('Supprimer cette page ?')">
                        <input type="hidden" name="id" value="<?= $page['id'] ?>">
                        <button type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php endif; ?>

<br>
<a href="/">← Retour à l'accueil</a>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une page</title>
</head>
<body>

<h1>Modifier la page</h1>

<?php if (!empty($_SESSION['erreurs'])): ?>
    <div style="color:red">
        <ul>
            <?php foreach ($_SESSION['erreurs'] as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php unset($_SESSION['erreurs']); ?>
<?php endif; ?>

<!-- $page vient du controller avec les données actuelles de la page -->
<form method="POST" action="/admin/pages/modifier-traitement">

    <!-- ID caché pour savoir quelle page modifier -->
    <input type="hidden" name="id" value="<?= $page['id'] ?>">

    <label>Titre</label><br>
    <input type="text" name="titre" value="<?= htmlspecialchars($page['titre']) ?>">
    <br><br>

    <label>Contenu</label><br>
    <textarea name="contenu" rows="10" cols="50"><?= htmlspecialchars($page['contenu']) ?></textarea>
    <br><br>

    <label>Slug (URL)</label><br>
    <input type="text" name="slug" value="<?= htmlspecialchars($page['slug']) ?>">
    <small>Uniquement des lettres minuscules, chiffres et tirets</small>
    <br><br>

    <button type="submit">Enregistrer</button>
    <a href="/admin/pages">Annuler</a>

</form>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer une page</title>
</head>
<body>

<h1>Créer une page</h1>

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

<!--
    Les valeurs $_SESSION['ancien'] servent à re-remplir le formulaire
    si l'utilisateur a fait une erreur
-->
<?php $ancien = $_SESSION['ancien'] ?? []; unset($_SESSION['ancien']); ?>

<form method="POST" action="/admin/pages/creer-traitement">

    <label>Titre</label><br>
    <input type="text" name="titre" value="<?= htmlspecialchars($ancien['titre'] ?? '') ?>">
    <br><br>

    <label>Contenu</label><br>
    <textarea name="contenu" rows="10" cols="50"><?= htmlspecialchars($ancien['contenu'] ?? '') ?></textarea>
    <br><br>

    <label>Slug (URL) — ex: mon-article</label><br>
    <input type="text" name="slug" value="<?= htmlspecialchars($ancien['slug'] ?? '') ?>">
    <small>Uniquement des lettres minuscules, chiffres et tirets</small>
    <br><br>

    <button type="submit">Créer la page</button>
    <a href="/admin/pages">Annuler</a>

</form>

</body>
</html>
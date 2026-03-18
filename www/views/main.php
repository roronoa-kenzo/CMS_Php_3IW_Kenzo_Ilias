<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
</head>
<body>

<h1>Bienvenue sur le CMS</h1>

<?php if ($isConnect): ?>

    <!-- $isConnect contient les infos de l'utilisateur connecté -->
    <p>Connecté en tant que <strong><?= htmlspecialchars($isConnect['username']) ?></strong>
    — rôle : <?= htmlspecialchars($isConnect['role']) ?></p>
    <a href="/deconnexion">Se déconnecter</a>
    <a href="/creer">Créer une page</a>

<?php else: ?>

    <!-- $isConnect = false donc personne n'est connecté -->
    <a href="/connexion">Se connecter</a> |
    <a href="/inscription">S'inscrire</a>

<?php endif; ?>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($page['titre']) ?></title>
</head>
<body>
<!-- Barre de navigation simple -->
<nav>
    <a href="/">Accueil</a>
    <?php if ($isConnect): ?>
        
        <?php if ($isConnect['role'] === 'admin'): ?>
            | <a href="/admin/pages">Backoffice</a>
        <?php endif; ?>
        
        | <a href="/deconnexion">Déconnexion</a>
        
    <?php else: ?>
        | <a href="/connexion">Connexion</a>
    <?php endif; ?>
</nav>
<hr>

<!-- $page vient du controller avec toutes les infos de la page -->
<h1><?= htmlspecialchars($page['titre']) ?></h1>

<p>
    <small>
        Par <strong><?= htmlspecialchars($page['auteur']) ?></strong>
        — le <?= date('d/m/Y', strtotime($page['created_at'])) ?>
    </small>
</p>

<hr>

<!-- Le contenu de la page -->
<!-- On utilise nl2br() pour afficher les retours à la ligne -->
<div>
    <?= nl2br(htmlspecialchars($page['contenu'])) ?>
</div>

<hr>

<a href="/">← Retour à l'accueil</a>

</body>
</html>
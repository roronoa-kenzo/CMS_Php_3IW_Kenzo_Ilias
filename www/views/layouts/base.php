<?php
$isAuthenticated = isset($isConnect) && is_array($isConnect);
$currentUser = $isAuthenticated ? $isConnect : null;
$pageTitle = $title . ' | ' . $siteName;
?>
<!DOCTYPE html>
<html lang="fr" data-mode="auto" data-theme="verdant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <meta name="description" content="FanDeWarhammerCMS, un CMS PHP moderne inspire de l'univers Warhammer.">
    <link rel="stylesheet" href="/css/output.css">
</head>
<body class="site-body <?= htmlspecialchars($pageClass) ?>">
    <div class="site-shell">
        <header class="topbar">
            <div class="topbar__brand">
                <a class="brand" href="/">
                    <span class="brand__orb" aria-hidden="true"></span>
                    <span class="brand__text">
                        <span class="brand__eyebrow">Fan portal</span>
                        <span class="brand__name"><?= htmlspecialchars($siteName) ?></span>
                    </span>
                </a>
                <p class="topbar__tagline">Un sanctuaire editorial pour les pages, campagnes et chroniques Warhammer.</p>
            </div>

            <div class="topbar__controls">
                <label class="control">
                    <span class="control__label">Mode</span>
                    <select class="control__select" data-mode-select aria-label="Choisir le mode d'affichage">
                        <option value="auto">Auto</option>
                        <option value="light">Clair</option>
                        <option value="dark">Sombre</option>
                    </select>
                </label>

                <label class="control">
                    <span class="control__label">Theme</span>
                    <select class="control__select" data-theme-select aria-label="Choisir le theme visuel">
                        <option value="verdant">Verdant Forge</option>
                        <option value="cathedral">Relic Grove</option>
                    </select>
                </label>
            </div>
        </header>

        <nav class="menu" aria-label="Navigation principale">
            <a class="menu__link" href="/">Accueil</a>
            <a class="menu__link" href="/design-guide">Design guide</a>

            <?php if ($isAuthenticated): ?>
                <?php if (in_array($currentUser['role'], ['admin', 'editor'], true)): ?>
                    <a class="menu__link" href="/admin/pages">Backoffice</a>
                    <a class="menu__link" href="/admin/pages/creer">Nouvelle page</a>
                <?php endif; ?>

                <?php if ($currentUser['role'] === 'admin'): ?>
                    <a class="menu__link" href="/admin/users">Utilisateurs</a>
                <?php endif; ?>

                <a class="menu__link" href="/deconnexion">Deconnexion</a>
            <?php else: ?>
                <a class="menu__link" href="/connexion">Connexion</a>
                <a class="menu__link" href="/inscription">Inscription</a>
            <?php endif; ?>
        </nav>

        <main class="content">
            <?= $content ?>
        </main>

        <footer class="footer">
            <p class="footer__title"><?= htmlspecialchars($siteName) ?></p>
            <p class="footer__text">Design system editorial, mobile-first, themeable et pense pour l'univers FanDeWarhammerCMS.</p>
        </footer>
    </div>

    <script src="/js/theme-switcher.js" defer></script>
</body>
</html>

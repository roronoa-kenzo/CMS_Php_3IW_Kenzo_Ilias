<section class="hero">
    <span class="hero__kicker">FanDeWarhammerCMS</span>
    <h1 class="hero__title">Publie, archive et administre tes pages dans un cockpit Frutiger Aero inspire de Warhammer.</h1>
    <p class="hero__text">
        Ce CMS met en scene le frontoffice, les formulaires et le backoffice dans une interface lumineuse, vitree et moderne,
        avec une ambiance de command bridge pour tes chroniques, factions et recits.
    </p>

    <div class="hero__meta">
        <?php if ($isConnect): ?>
            <span class="badge badge--success">
                Connecte: <?= htmlspecialchars($isConnect['username']) ?>
            </span>
            <span class="badge">
                Role: <?= htmlspecialchars($isConnect['role']) ?>
            </span>
        <?php else: ?>
            <span class="badge badge--warning">Mode visiteur</span>
            <span class="badge">Connexion requise pour le backoffice</span>
        <?php endif; ?>
    </div>

    <div class="hero__actions">
        <a class="button button--ghost" href="/design-guide">Voir le design guide</a>

        <?php if ($isConnect): ?>

            <?php if ($isConnect['role'] === 'admin'): ?>
                <a class="button" href="/admin/pages">Ouvrir le backoffice</a>
            <?php endif; ?>

            <?php if (in_array($isConnect['role'], ['admin', 'editor'], true)): ?>
                <a class="button button--ghost" href="/admin/pages/creer">Creer une page</a>
            <?php endif; ?>

        <?php else: ?>
            <a class="button" href="/connexion">Se connecter</a>
            <a class="button button--ghost" href="/inscription">Creer un compte</a>
        <?php endif; ?>
    </div>
</section>

<section class="layout-grid layout-grid--two-columns">
    <article class="panel stack">
        <div class="panel__header">
            <span class="section__kicker">Experience</span>
            <h2 class="section__title">Une identite visuelle pensee pour FanDeWarhammerCMS</h2>
            <p class="section__lede">
                L'interface reste claire et respirante, mais conserve des accents de science-fiction gothique avec ses halos,
                ses surfaces vitrees et ses teintes ceremonielles.
            </p>
        </div>

        <div class="stats">
            <article class="stat-card">
                <span class="stat-card__label">Pages front</span>
                <strong class="stat-card__value">Narration</strong>
            </article>
            <article class="stat-card">
                <span class="stat-card__label">Backoffice</span>
                <strong class="stat-card__value">Pilotage</strong>
            </article>
            <article class="stat-card">
                <span class="stat-card__label">Themes</span>
                <strong class="stat-card__value">2 variations</strong>
            </article>
        </div>
    </article>

    <aside class="utility-card stack">
        <div class="utility-card__header">
            <span class="section__kicker">Acces rapide</span>
            <h2 class="section__title">Que peux-tu faire ici ?</h2>
        </div>

        <div class="stack">
            <div>
                <strong>Frontoffice</strong>
                <p class="section__lede">Afficher les pages publiees, presenter leurs auteurs et garder une lecture confortable.</p>
            </div>
            <div>
                <strong>Authentification</strong>
                <p class="section__lede">Gerer inscription, connexion, activation et reinitialisation dans la meme grammaire visuelle.</p>
            </div>
            <div>
                <strong>Administration</strong>
                <p class="section__lede">Creer, modifier, publier ou supprimer des pages depuis une interface lisible.</p>
            </div>
        </div>
    </aside>
</section>
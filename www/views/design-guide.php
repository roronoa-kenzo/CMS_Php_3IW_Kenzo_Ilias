<section class="hero">
    <span class="hero__kicker">Design system</span>
    <h1 class="hero__title">Bibliotheque de composants FanDeWarhammerCMS</h1>
    <p class="hero__text">
        Cette page centralise les composants reutilisables du projet et montre comment le langage visuel Frutiger Aero
        moderne s'applique au frontoffice, a l'authentification et au backoffice.
    </p>
    <div class="hero__meta">
        <span class="badge">BEM-friendly</span>
        <span class="badge">SCSS factorise</span>
        <span class="badge">Themeable</span>
    </div>
</section>

<div class="guide">
    <section class="guide__section">
        <div class="guide__header">
            <span class="section__kicker">Typographie</span>
            <h2 class="section__title">Hierarchie de texte</h2>
            <p class="section__lede">Une echelle lisible pour les ecrans publics, les formulaires et les interfaces d'administration.</p>
        </div>

        <div class="guide__grid">
            <article class="component-card">
                <div class="component-card__header">
                    <h3 class="component-card__title">Titres</h3>
                    <p class="guide__code">Blocks: <code>.hero__title</code>, <code>.section__title</code>, <code>.page-title</code></p>
                </div>
                <div class="component-card__body type-scale">
                    <span class="type-scale__caption">Hero title</span>
                    <h1 class="hero__title">The Emperor Protects</h1>
                    <span class="type-scale__caption">Section title</span>
                    <h2 class="section__title">Controle des composants</h2>
                    <span class="type-scale__caption">Page title</span>
                    <h3 class="page-title">Section d'edition</h3>
                </div>
            </article>

            <article class="component-card">
                <div class="component-card__header">
                    <h3 class="component-card__title">Texte courant</h3>
                    <p class="guide__code">Helpers: <code>.section__lede</code>, <code>.hint</code>, <code>.badge</code></p>
                </div>
                <div class="component-card__body">
                    <p class="section__lede">Le design guide met en avant une interface claire, respirante et liee a l'univers Warhammer sans devenir surchargee.</p>
                    <p class="hint">Les indices visuels secondaires utilisent une couleur plus douce pour garder une bonne lecture.</p>
                    <div class="inline-actions">
                        <span class="badge">Badge neutre</span>
                        <span class="badge badge--success">Badge succes</span>
                        <span class="badge badge--warning">Badge warning</span>
                    </div>
                </div>
            </article>
        </div>
    </section>

    <section class="guide__section">
        <div class="guide__header">
            <span class="section__kicker">Form elements</span>
            <h2 class="section__title">Boutons, champs et alertes</h2>
            <p class="section__lede">Les composants de formulaire servent autant aux pages d'authentification qu'au backoffice.</p>
        </div>

        <div class="guide__grid">
            <article class="component-card">
                <div class="component-card__header">
                    <h3 class="component-card__title">Actions</h3>
                </div>
                <div class="component-card__body">
                    <div class="inline-actions">
                        <button class="button" type="button">Action primaire</button>
                        <button class="button button--ghost" type="button">Action secondaire</button>
                        <button class="button button--neutral" type="button">Action neutre</button>
                        <button class="button button--danger" type="button">Action danger</button>
                    </div>
                    <div class="notices">
                        <div class="notice notice--success">Une operation a ete traitee avec succes.</div>
                        <div class="notice notice--error">Une erreur de validation ou de permission doit etre signalee clairement.</div>
                    </div>
                </div>
            </article>

            <article class="component-card">
                <div class="component-card__header">
                    <h3 class="component-card__title">Formulaire type</h3>
                </div>
                <form class="component-card__body field-list">
                    <div class="field">
                        <label class="field__label" for="guide-title">Titre de page</label>
                        <input class="field__input" id="guide-title" type="text" value="chroniques-de-terra">
                    </div>
                    <div class="field">
                        <label class="field__label" for="guide-category">Faction</label>
                        <select class="field__select" id="guide-category">
                            <option>Adeptus Mechanicus</option>
                            <option>Astra Militarum</option>
                            <option>Ultramarines</option>
                        </select>
                    </div>
                    <div class="field">
                        <label class="field__label" for="guide-content">Contenu</label>
                        <textarea class="field__textarea" id="guide-content">Un extrait de contenu editorial pour montrer le traitement des zones de texte.</textarea>
                    </div>
                    <label class="field__check">
                        <input type="checkbox" checked>
                        <span>Publier immediatement</span>
                    </label>
                </form>
            </article>
        </div>
    </section>

    <section class="guide__section">
        <div class="guide__header">
            <span class="section__kicker">Containers</span>
            <h2 class="section__title">Banners, cards et surfaces</h2>
        </div>

        <div class="banner">
            <span class="section__kicker">Featured banner</span>
            <h3 class="banner__title">Lance une nouvelle campagne editoriale</h3>
            <p class="banner__text">Cette banniere sert a presenter un point d'attention fort, une action cle ou une information strategique.</p>
            <div class="inline-actions">
                <a class="button" href="/admin/pages/creer">Nouvelle page</a>
                <a class="button button--ghost" href="/">Retour accueil</a>
            </div>
        </div>

        <div class="card-grid">
            <article class="content-card">
                <span class="content-card__eyebrow">Card</span>
                <h3 class="content-card__title">Lecture confortable</h3>
                <p class="content-card__text">Les cartes servent a contenir du contenu, des stats ou des blocs de navigation rapides.</p>
            </article>
            <article class="content-card">
                <span class="content-card__eyebrow">Card</span>
                <h3 class="content-card__title">Composant reutilisable</h3>
                <p class="content-card__text">Chaque carte repose sur les memes variables, rayons, surfaces et ombres.</p>
            </article>
        </div>
    </section>

    <section class="guide__section">
        <div class="guide__header">
            <span class="section__kicker">Navigation</span>
            <h2 class="section__title">Breadcrumbs, menubar et pagination</h2>
        </div>

        <div class="guide__grid">
            <article class="component-card">
                <div class="component-card__header">
                    <h3 class="component-card__title">Breadcrumbs</h3>
                </div>
                <div class="component-card__body">
                    <nav aria-label="Breadcrumb">
                        <ol class="breadcrumbs">
                            <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="/">Accueil</a></li>
                            <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="/admin/pages">Backoffice</a></li>
                            <li class="breadcrumbs__item">Modifier une page</li>
                        </ol>
                    </nav>
                </div>
            </article>

            <article class="component-card">
                <div class="component-card__header">
                    <h3 class="component-card__title">Menubar</h3>
                </div>
                <div class="component-card__body">
                    <nav class="menubar" aria-label="Menu d'edition" role="menubar">
                        <a class="menubar__item" href="#" role="menuitem">Fichier</a>
                        <a class="menubar__item" href="#" role="menuitem">Edition</a>
                        <a class="menubar__item" href="#" role="menuitem">Publication</a>
                        <a class="menubar__item" href="#" role="menuitem">Aide</a>
                    </nav>
                </div>
            </article>

            <article class="component-card">
                <div class="component-card__header">
                    <h3 class="component-card__title">Pagination</h3>
                </div>
                <div class="component-card__body">
                    <nav class="pagination" aria-label="Pagination">
                        <a class="pagination__link" href="#">1</a>
                        <a class="pagination__link pagination__link--current" href="#" aria-current="page">2</a>
                        <a class="pagination__link" href="#">3</a>
                        <a class="pagination__link" href="#">4</a>
                    </nav>
                </div>
            </article>

            <article class="component-card">
                <div class="component-card__header">
                    <h3 class="component-card__title">Tableau</h3>
                </div>
                <div class="component-card__body">
                    <table class="showcase-table">
                        <thead>
                            <tr>
                                <th>Composant</th>
                                <th>Etat</th>
                                <th>Usage</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Table</td>
                                <td>Stable</td>
                                <td>Backoffice pages</td>
                            </tr>
                            <tr>
                                <td>Pagination</td>
                                <td>Demo</td>
                                <td>Navigation longue liste</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </article>
        </div>
    </section>

    <section class="guide__section">
        <div class="guide__header">
            <span class="section__kicker">Composants interactifs</span>
            <h2 class="section__title">Accordeon et modale</h2>
        </div>

        <div class="guide__grid">
            <article class="component-card">
                <div class="component-card__header">
                    <h3 class="component-card__title">Accordeon</h3>
                </div>
                <div class="component-card__body accordion">
                    <details class="accordion__item" open>
                        <summary class="accordion__title">Pourquoi utiliser des variables CSS ?</summary>
                        <div class="accordion__panel">Elles simplifient les themes, la maintenance et la coherence visuelle entre frontoffice et backoffice.</div>
                    </details>
                    <details class="accordion__item">
                        <summary class="accordion__title">Pourquoi garder des classes BEM ?</summary>
                        <div class="accordion__panel">La structure bloc, element, modificateur aide a nommer les composants et a les faire evoluer proprement.</div>
                    </details>
                </div>
            </article>

            <article class="component-card">
                <div class="component-card__header">
                    <h3 class="component-card__title">Modale</h3>
                    <p class="guide__code">JS natif: <code>data-modal-open</code> et <code>data-modal-close</code></p>
                </div>
                <div class="component-card__body">
                    <p class="section__lede">Une modale permet de confirmer une action importante ou de presenter une information sans quitter la page.</p>
                    <div class="inline-actions">
                        <button class="button" type="button" data-modal-open="guide-modal">Ouvrir la modale</button>
                    </div>
                </div>
            </article>
        </div>
    </section>
</div>

<dialog id="guide-modal">
    <article class="dialog-modal">
        <div class="dialog-modal__header">
            <div>
                <span class="section__kicker">Modale</span>
                <h2 class="dialog-modal__title">Exemple de confirmation</h2>
            </div>
            <button class="button button--ghost" type="button" data-modal-close>Fermer</button>
        </div>
        <div class="dialog-modal__body">
            Cette fenetre modale montre comment afficher un contenu prioritaire sans rompre la coherence visuelle du design system.
        </div>
        <div class="dialog-modal__actions">
            <button class="button" type="button" data-modal-close>Confirmer</button>
            <button class="button button--ghost" type="button" data-modal-close>Annuler</button>
        </div>
    </article>
</dialog>

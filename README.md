# FanDeWarhammerCMS

Refonte visuelle et structurelle du CMS PHP pour repondre au sujet de soutenance "Integration 3IW Janvier 2026".

## Ce qui a ete mis en place

- suppression complete de Tailwind
- mise en place d'un design system CSS/SCSS maison
- direction visuelle moderne adaptee a l'univers `FanDeWarhammerCMS`
- dark mode + theme alternatif pilotables dans l'interface
- layout partage pour factoriser `head`, navigation, footer et chargement des assets
- bibliotheque de composants visible dans une page dediee `design guide`

## Conformite avec le sujet

Le projet couvre maintenant les attentes principales du PDF :

- pages front end et pages d'administration stylisees
- design guide dedie avec composants de base
- typographie
- elements de formulaire
- containers, cards et banner
- navigation avec menu, breadcrumbs et pagination
- alertes
- modale
- accordeon
- mobile first
- dark mode
- theme alternatif
- influence metier visible sur le rendu
- SCSS factorise avec partials et mixins

## Structure CSS / SCSS

Source SCSS :

- `www/scss/main.scss`
- `www/scss/partials/_tokens.scss`
- `www/scss/partials/_mixins.scss`
- `www/scss/partials/_base.scss`
- `www/scss/partials/_layout.scss`
- `www/scss/partials/_components.scss`
- `www/scss/partials/_guide.scss`

Fichier compile servi par l'application :

- `www/css/output.css`

## Pages et fichiers ajoutes ou modifies

Pages / vues :

- `www/views/layouts/base.php`
- `www/views/design-guide.php`
- `www/views/main.php`
- `www/views/frontoffice/page.php`
- `www/views/auth/connexion.php`
- `www/views/auth/inscription.php`
- `www/views/auth/mot_de_passe_oublie.php`
- `www/views/auth/reset_mot_de_passe.php`
- `www/views/backoffice/pages/liste.php`
- `www/views/backoffice/pages/creer.php`
- `www/views/backoffice/pages/modifier.php`
- `www/views/404.php`

Controleurs / routage :

- `www/controllers/Controller.php`
- `www/controllers/home.php`
- `www/controllers/auth.php`
- `www/controllers/frontoffice/front.php`
- `www/controllers/backoffice/page.php`
- `www/routes.yml`

Scripts :

- `www/js/theme-switcher.js`

## Build CSS

Installer les dependances :

```bash
npm install
```

Compiler le CSS :

```bash
npm run build:css
```

Lancer le watch SCSS :

```bash
npm run watch:css
```

## Docker

Le projet peut etre lance avec Docker Compose.

Application :

- `http://localhost:8080`

phpMyAdmin :

- `http://localhost:8081`

Mailpit :

- `http://localhost:8025`

## Notes

- le design guide est accessible via `http://localhost:8080/design-guide`
- la persistance du mode et du theme est geree dans `localStorage`
- un point hors scope CSS subsiste dans l'application : la route front dynamique `/page/<slug>` depend encore d'un acces BDD valide pour fonctionner pleinement

<?php
// www/controllers/frontoffice/front.php

require_once __DIR__ . '/../Controller.php';

class Front extends Controller
{
    // Pas de __construct → tout le monde peut voir le frontoffice
    // isConnect() est hérité de Controller, on s'en sert juste pour savoir
    // si l'utilisateur est connecté ou non (pour afficher un menu par exemple)

    // Affiche une page publiée via son slug
    // URL : /page/mon-slug
    public function afficher(): void
    {
        $isConnect = $this->isConnect();

        // On récupère le slug depuis l'URL
        $uri  = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $slug = str_replace('/page/', '', $uri);

        // TODO : chercher la page en BDD avec ce slug
        // TODO : si introuvable ou pas publiée → 404

        $this->render('frontoffice/page', [
            'isConnect' => $isConnect,
            'slug'      => $slug,
        ]);
    }
}
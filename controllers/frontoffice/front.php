<?php
// www/controllers/frontoffice/front.php

require_once __DIR__ . '/../Controller.php';
require_once __DIR__ . '/../../model/PageModel.php';

use Application\Lib\Database\DatabaseConnection;

class Front extends Controller
{
    private PageModel $pageModel;

    public function __construct()
    {
        $this->pageModel = new PageModel();
    }

    // On affiche une page publiée via son slug
        // URL : /page/mon-slug
    public function afficher(): void
    {
        $isConnect = $this->isConnect();

        // On récupère le slug depuis l'URL
            // ex: /page/mon-article → on enlève le "/page/" pour garder "mon-article"
        $uri  = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $slug = str_replace('/page/', '', $uri);

        // On cherche la page dans la BDD avec ce slug
        $page = $this->pageModel->trouverParSlug($slug);

        // Si la page n'existe pas ou n'est pas publiée → 404
        if (!$page) {
            http_response_code(404);
            require __DIR__ . '/../../views/404.php';
            exit;
        }

        // On envoie la page à la vue
        $this->render('frontoffice/page', [
            'isConnect' => $isConnect,
            'page'      => $page,
        ]);
    }
}
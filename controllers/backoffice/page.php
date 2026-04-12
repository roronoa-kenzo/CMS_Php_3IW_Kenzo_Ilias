<?php
// www/controllers/backoffice/page.php
require_once __DIR__ . '/../Controller.php';
require __DIR__ . '/../../model/PageModel.php';
class Page extends Controller
{
    private PageModel $pageModel;

    public function __construct()
    {
        $this->pageModel = new PageModel();
    }

    // On liste — affiche toutes les pages
    // URL : /admin/pages
    public function liste(): void
    {
        // On vérifie que l'utilisateur est connecté
        $isConnect = $this->isConnect();
        if (!$isConnect) {
            header('Location: /connexion');
            exit;
        }

        // On récupère toutes les pages depuis la BDD
        $pages = $this->pageModel->toutesLesPages();

        $this->render('backoffice/pages/liste', [
            'isConnect' => $isConnect,
            'pages'     => $pages,
        ]);
    }

    // On créer — affiche le formulaire
    // URL : /admin/pages/creer
    public function creerForm(): void
    {
        // Seuls admin et editor peuvent créer
        $this->requireRole(['admin', 'editor']);

        // Si on arrive ici, c'est que le rôle est OK
        $this->render('backoffice/pages/creer');
    }

    // On crée la page en traitant le formulaire (POST)
        // URL : /admin/pages/creer-traitement
    public function creer(): void
    {   
        // Seuls admin et editor peuvent créer
        $this->requireRole(['admin', 'editor']);
        $isConnect = $this->isConnect();
        if (!$isConnect) {
            header('Location: /connexion');
            exit;
        }

        // On récupère ce que l'utilisateur a tapé
        $titre   = trim($_POST['titre']   ?? '');
        $contenu = trim($_POST['contenu'] ?? '');
        $slug    = trim($_POST['slug']    ?? '');

        // Validation simple
        $erreurs = [];

        if (empty($titre)) {
            $erreurs[] = "Le titre est obligatoire.";
        }
        if (empty($contenu)) {
            $erreurs[] = "Le contenu est obligatoire.";
        }
        if (empty($slug)) {
            $erreurs[] = "Le slug est obligatoire.";
        }
        // Le slug ne doit contenir que des lettres, chiffres et tirets
        if (!preg_match('/^[a-z0-9-]+$/', $slug)) {
            $erreurs[] = "Le slug ne peut contenir que des lettres minuscules, chiffres et tirets.";
        }
        if ($this->pageModel->slugExiste($slug)) {
            $erreurs[] = "Ce slug est déjà utilisé.";
        }

        if (!empty($erreurs)) {
            $_SESSION['erreurs'] = $erreurs;
            $_SESSION['ancien']  = compact('titre', 'contenu', 'slug');
            header('Location: /admin/pages/creer');
            exit;
        }

        // On crée la page avec l'ID de l'utilisateur connecté comme auteur
        $this->pageModel->creer($titre, $contenu, $slug, $isConnect['id']);

        $_SESSION['succes'] = "Page « $titre » créée avec succès.";
        header('Location: /admin/pages');
        exit;
    }

    // On modifie la page en affichant le formulaire
     // URL : /admin/pages/modifier?id=1
    public function modifierForm(): void
    {
        $isConnect = $this->isConnect();
        if (!$isConnect) {
            header('Location: /connexion');
            exit;
        }

        $id   = (int)($_GET['id'] ?? 0);
        $page = $this->pageModel->trouverParId($id);

        // Si la page n'existe pas → on redirige
        if (!$page) {
            $_SESSION['erreur'] = "Page introuvable.";
            header('Location: /admin/pages');
            exit;
        }

        $this->render('backoffice/pages/modifier', [
            'isConnect' => $isConnect,
            'page'      => $page,
        ]);
    }

    // On modifie la page en traitant le formulaire (POST)
    // URL : /admin/pages/modifier-traitement
    public function modifier(): void
    {
        $isConnect = $this->isConnect();
        if (!$isConnect) {
            header('Location: /connexion');
            exit;
        }

        $id      = (int)($_POST['id']      ?? 0);
        $titre   = trim($_POST['titre']    ?? '');
        $contenu = trim($_POST['contenu']  ?? '');
        $slug    = trim($_POST['slug']     ?? '');

        $erreurs = [];

        if (empty($titre))   $erreurs[] = "Le titre est obligatoire.";
        if (empty($contenu)) $erreurs[] = "Le contenu est obligatoire.";
        if (empty($slug))    $erreurs[] = "Le slug est obligatoire.";

        if (!preg_match('/^[a-z0-9-]+$/', $slug)) {
            $erreurs[] = "Le slug ne peut contenir que des lettres minuscules, chiffres et tirets.";
        }
        // On exclut la page actuelle pour vérifier les doublons de slug
        if ($this->pageModel->slugExiste($slug, $id)) {
            $erreurs[] = "Ce slug est déjà utilisé.";
        }

        if (!empty($erreurs)) {
            $_SESSION['erreurs'] = $erreurs;
            header('Location: /admin/pages/modifier?id=' . $id);
            exit;
        }

        $this->pageModel->modifier($id, $titre, $contenu, $slug);

        $_SESSION['succes'] = "Page modifiée avec succès.";
        header('Location: /admin/pages');
        exit;
    }

    // SUPPRIMER — (POST)
    // URL : /admin/pages/supprimer
    public function supprimer(): void
    {
        $isConnect = $this->isConnect();
        if (!$isConnect) {
            header('Location: /connexion');
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);

        $this->pageModel->supprimer($id);

        $_SESSION['succes'] = "Page supprimée.";
        header('Location: /admin/pages');
        exit;
    }

    // PUBLIER / DÉPUBLIER — (POST)
    // URL : /admin/pages/publier
    public function publier(): void
    {
        $isConnect = $this->isConnect();
        if (!$isConnect) {
            header('Location: /connexion');
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);

        // On change le statut de la page : publiee → brouillon ou brouillon → publiee
        $this->pageModel->changerStatut($id);

        $_SESSION['succes'] = "Statut de la page mis à jour.";
        header('Location: /admin/pages');
        exit;
    }
}
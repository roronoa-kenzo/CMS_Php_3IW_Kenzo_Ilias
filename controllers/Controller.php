<?php
class Controller
{
    // Affiche une vue et lui passe des données
    protected function render(string $view, array $data = []): void
    {
        extract($data);
        $viewPath = __DIR__ . '/../views/' . $view . '.php';
        if (!file_exists($viewPath)) {
            http_response_code(500);
            echo "Vue introuvable : " . htmlspecialchars($view);
            exit;
        }
        require $viewPath;
    }

    // Retourne les infos de l'utilisateur connecté, ou false sinon
    protected function isConnect(): array|false
    {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }
        return false;
    }

    // On traduit un role_id en nom de rôle
    protected function getRoleName(int $roleId): string
    { 
        switch ($roleId) {
            case 1:
                return 'admin';
            case 2:
                return 'editor';
            case 3:
            default:
                return 'visitor';
        }
    }

    protected function requireRole(array $allowedRoles): void
    {
        // 1) Est-ce qu'il y a un utilisateur connecté ?
        if (!isset($_SESSION['user'])) {
            $_SESSION['erreur'] = "Vous devez être connecté.";
            header('Location: /connexion');
            exit;
        }

        // 2) On récupère le rôle de l'utilisateur depuis la session
        $userRole = $_SESSION['user']['role'] ?? null;

        // 3) Est-ce que ce rôle fait partie des rôles autorisés ?
        if ($userRole === null || !in_array($userRole, $allowedRoles, true)) {
            $_SESSION['erreur'] = "Vous n'avez pas les droits pour accéder à cette page.";
            header('Location: /');
            exit;
        }
    }
}
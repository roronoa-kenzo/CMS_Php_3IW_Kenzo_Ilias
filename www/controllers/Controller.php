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
}
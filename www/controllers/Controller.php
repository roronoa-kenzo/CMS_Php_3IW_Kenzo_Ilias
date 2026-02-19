<?php

class Controller
{
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
}


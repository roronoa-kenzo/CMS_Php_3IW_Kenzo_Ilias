<?php
define('VIEW_PATH', __DIR__ . '/view');

function getRoute(): string
{
    if (!empty($_GET['route'])) {
        return trim($_GET['route'], '/');
    }
    
    if (!empty($_SERVER['PATH_INFO'])) {
        return trim($_SERVER['PATH_INFO'], '/');
    }
    
    return 'main';
}

function url(string $route = ''): string
{
    return $route ? '/' . $route : '/';
}

function loadView(string $viewName): void
{
    $viewFile = VIEW_PATH . '/' . $viewName . '.php';
    
    if (!file_exists($viewFile)) {
        http_response_code(404);
        require_once VIEW_PATH . '/404.php';
        return;
    }
    
    require_once $viewFile;
}

loadView(getRoute());

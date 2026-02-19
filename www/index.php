<?php

// 1. Récupérer l'URI, exemple : /admin/page
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// 2. Charger les routes depuis routes.yml
$routes = [];
$currentRoute = null;
foreach (file(__DIR__ . '/routes.yml') as $line) {
    $line = rtrim($line);
    if (preg_match('/^(\/.+):$/', $line, $m)) {
        $currentRoute = $m[1];
    } elseif ($currentRoute && preg_match('/^\s+(controller|action):\s*(\S+)$/', $line, $m)) {
        $routes[$currentRoute][$m[1]] = $m[2];
    }
}

if ($uri === '/') {
    require __DIR__ . '/views/main.php';
    exit;
}

if (!isset($routes[$uri])) {
    http_response_code(404);
    require __DIR__ . '/views/404.php';
    exit;
}

// 3. /admin/page → controller: admin, action: page
//    Appeler la classe Admin et la méthode page()
$controllerName = ucfirst($routes[$uri]['controller']);
$action = $routes[$uri]['action'];

require_once __DIR__ . '/controllers/' . strtolower($controllerName) . '.php';

$controller = new $controllerName();
$controller->$action();

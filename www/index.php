<?php
 
// Démarre la session UNE SEULE FOIS ici pour toute l'appli
session_start();
 
// créer les constante a partir du fichier .env
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    foreach (file($envFile) as $line) {
        $line = trim($line);
        if (empty($line) || str_starts_with($line, '#')) continue;
        [$cle, $valeur] = explode('=', $line, 2);
        define(trim($cle), trim($valeur));
    }
}   
else {
    die("Le fichier .env est introuvable. Veuillez le créer à partir de .env.example");
}

// 1. Récupère l'URL demandée, exemple : /connexion
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
 
// 2. Récupère la méthode HTTP : GET (afficher) ou POST (envoyer un formulaire)
$methode = $_SERVER['REQUEST_METHOD'];
 
// 3. Charge les routes depuis routes.yml
$routes = [];
$currentRoute = null;
 
foreach (file(__DIR__ . '/routes.yml') as $line) {
    $line = rtrim($line);
 
    // Ligne qui commence par une route ex: /connexion:
    if (preg_match('/^(\/.*):\s*$/', $line, $m)) {
        $currentRoute = $m[1];
 
    // Ligne avec controller, action ou method
    } elseif ($currentRoute && preg_match('/^\s+(controller|action|method):\s*(\S+)$/', $line, $m)) {
        $routes[$currentRoute][$m[1]] = $m[2];
    }
}
 
// 5. Route introuvable → 404
if (!isset($routes[$uri])) {
    http_response_code(404);
    require __DIR__ . '/views/404.php';
    exit;
}
 
// 6. Vérifie la méthode HTTP si elle est précisée dans routes.yml
//    Ex: method: POST → seul un formulaire peut accéder à cette route
if (isset($routes[$uri]['method'])) {
    $methodAttendue = strtoupper($routes[$uri]['method']);
 
    if ($methode !== $methodAttendue) {
        http_response_code(405); // 405 = Méthode non autorisée
        echo "Méthode non autorisée.";
        exit;
    }
}
 
// 7. Appelle le bon controller et la bonne méthode
//    Ex: controller: auth + action: connexionForm
//    → charge controllers/auth.php → new Auth() → $controller->connexionForm()
$controllerName = ucfirst($routes[$uri]['controller']);
$action         = $routes[$uri]['action'];
 
require_once __DIR__ . '/controllers/' . strtolower($controllerName) . '.php';
 
$controller = new $controllerName();
$controller->$action();
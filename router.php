<?php
session_start();

// Récupération et nettoyage de l'URI demandée
$request_uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// Forcer la suppression des éventuels espaces et nettoyer les buffers de sortie
ob_start();

// Si aucune route n'est spécifiée ou si c'est "index", rediriger vers la page principale
if ($request_uri === '' || $request_uri === 'index') {
    header("Location: /views/index.php");
    ob_end_flush();
    exit();
}

// Vérification si c'est un fichier statique (CSS, JS, images)
$file_path = __DIR__ . '/' . $request_uri;
if (file_exists($file_path) && is_file($file_path)) {
    return false; // Laisser PHP gérer les fichiers statiques
}

// Définition des routes accessibles
$routes = [
    'login' => '../views/login.php',
    'logout' => '../views/logout.php',
    'dashboard-user' => '../views/dashboard_user.php',
    'dashboard-admin' => '../views/dashboard_admin.php',
    'about' => '../views/about.php',
    'help' => '../views/help.php',
    'faq' => '../views/faq.php',
    'contact' => '../views/contact.php',
    'terms' => '../views/terms.php',
    'privacy' => '../views/privacy.php',
];

// Vérification et inclusion des fichiers de vue
if (array_key_exists($request_uri, $routes)) {
    require_once __DIR__ . '/' . $routes[$request_uri];
    ob_end_flush();
    exit();
}

// Si la route est invalide, rediriger vers la page principale **avec arrêt immédiat**
header("Location: /views/index.php", true, 302);
ob_end_flush();
exit();
?>

<?php

use Managers\View;

require_once 'config/config.php';
require_once 'config/autoload.php';

$action = Helpers::request('action', 'home', 'get');

try {
    $routes = [
        'home' => [HomeController::class, 'showHome'],
        'connectionForm' => [UserController::class, 'showConnectionForm'],
        'login' => [UserController::class, 'loginUser'],
        'logout' => [UserController::class, 'logoutUser'],
        'register' => [UserController::class, 'showRegistrationForm'],
        'account' => [UserController::class, 'showAccount'],
        'addUser' => [UserController::class, 'registerUser'],
    ];

    if (!array_key_exists($action, $routes)) {
        throw new Exception("Il semblerait que la page demandée n'existe pas.");
    }

    [$controllerClass, $method] = $routes[$action];

    $controller = new $controllerClass();

    if (!method_exists($controller, $method)) {
        throw new Exception("Méthode introuvable dans le controller." . get_class($controller) . "::" . $method);
    }

    $controller->$method();

} catch (Exception $e) {
    http_response_code(404);
    $errorView = new View('Erreur');
    $errorView->render('error', ['errorMessage' => $e->getMessage()]);
}

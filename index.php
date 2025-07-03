<?php
require_once 'config/config.php';
require_once 'config/autoload.php';

$route = Helpers::request('route', 'home', 'get');

try {
    switch ($route)
    {
        case 'home':
            $HomeController = new HomeController();
            $HomeController->showHome();
            break;

        default :
            throw new Exception("Cette page n'existe pas.");
    }
} catch (Exception $e) {
    $errorView = new View('Erreur');
    $errorView->render('error', ['errorMessage' => $e->getMessage()]);
}
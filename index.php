<?php
require_once 'config/config.php';
require_once 'config/autoload.php';

$route = Helpers::request('route', 'home', 'get');

try {
    switch ($route)
    {
        case 'home':
        default :
            throw new Exception("Cette page n'existe pas.");
    }
} catch (Exception $e) {
    $errorView = new View('Erreur');
    $errorView->render('error404', ['errorMessage' => $e->getMessage()]);
}
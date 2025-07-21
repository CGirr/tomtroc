<?php
require_once 'config/config.php';
require_once 'config/autoload.php';

$action = Helpers::request('action', 'home');

try {
    switch ($action)
    {
        case 'home':
            $homeController = new HomeController();
            $homeController->showHome();
            break;
        case 'connectionForm':
            $userController = new UserController();
            $userController->showConnexionForm();
            break;
        case 'login' :
            $userController = new UserController();
            $userController->loginUser();
            break;
        case 'register':
            $userController = new UserController();
            $userController->showRegistrationForm();
            break;
        case 'addUser':
            $userController = new UserController();
            $userController->registerUser();
            break;
        default :
            throw new Exception("Cette page n'existe pas.");
    }
} catch (Exception $e) {
    $errorView = new View('Erreur');
    $errorView->render('error', ['errorMessage' => $e->getMessage()]);
}
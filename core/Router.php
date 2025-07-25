<?php

class Router
{
    private array $routes = [];

    public function __construct()
    {
        $this->routes = [
            'home' => [HomeController::class, 'showHome'],
            'connectionForm' => [UserController::class, 'showConnectionForm'],
            'login' => [UserController::class, 'loginUser'],
            'logout' => [UserController::class, 'logoutUser'],
            'register' => [UserController::class, 'showRegistrationForm'],
            'account' => [UserController::class, 'showAccount'],
            'addUser' => [UserController::class, 'registerUser'],
        ];
    }

    public function handleRequest(): void
    {
        $action = Helpers::request('action', 'home', 'get');

        try {
            if (!array_key_exists($action, $this->routes)) {
                throw new Exception("Il semblerait que la page demandée n'existe pas.");
            }

            [$controllerClass, $method] = $this->routes[$action];

            $controller = new $controllerClass();

            if (!method_exists($controller, $method)) {
                throw new Exception("Méthode introuvable dans le controller : " . get_class($controller) . "::" . $method);
            }

            $controller->$method();

        } catch (Exception $exception) {
            http_response_code(400);
            $errorView = new View('Erreur 404');
            $errorView->render('error', ['errorMessage' => $exception->getMessage()]);
        }
    }
}


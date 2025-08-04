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
            'singleBook' => [BookController::class, 'showSingleBook'],
            'allBooks' => [BookController::class, 'showAllBooks'],
            'deleteBook' => [BookController::class, 'deleteBook'],
            'editBook' => [BookController::class, 'showEditBookForm'],
            'vendor' => [UserController::class, 'showVendor'],
        ];
    }

    /**
     * @throws Exception
     */
    public function handleRequest(): void
    {
        $action = Helpers::request('action', 'home');

        try {
            if (!array_key_exists($action, $this->routes)) {
                throw new Exception("Il semblerait que la page demandée n'existe pas.", 404);
            }

            [$controllerClass, $method] = $this->routes[$action];
            $controller = new $controllerClass();

            if (!method_exists($controller, $method)) {
                throw new Exception(
                    "Méthode introuvable dans le controller : "
                    . get_class($controller)
                    . "::"
                    . $method,
                    500);
            }

            $controller->$method();

        } catch (Exception $exception) {
            $code = ($exception->getMessage() === "Il semblerait que la page demandée n'existe pas.") ? 404 : 500;
            http_response_code($code);

            $errorView = new View("Erreur $code");
            $errorView->render('error', [
                'errorMessage' => $exception->getMessage(),
                'errorCode'    => $code
            ]);
        }
    }
}


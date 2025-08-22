<?php

class Router
{
    /**
     * @var array[] $routes
     */
    private array $routes;

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
            'messaging' => [MessagingController::class, 'showMessagingPage'],
            'sendMessage' => [MessagingController::class, 'sendMessage'],
            'startConversation' => [MessagingController::class, 'startConversation'],
            'addBook' => [BookController::class, 'renderAddBookForm'],
            'insertBook' => [BookController::class, 'addBook'],
        ];
    }

    /**
     * Handles the HTTP request and sends it to the correct controller and method
     * @return void
     * @throws Exception
     */
    public function handleRequest(): void
    {
        $action = Helpers::getParameter('action', 'home');

        try {
            // Check if the action exists in the route list
            if (!array_key_exists($action, $this->routes)) {
                throw new Exception(
                    "Il semblerait que la page demandée n'existe pas.",
                    404
                );
            }

            // Extract the controller class and method name from the route
            [$controllerClass, $method] = $this->routes[$action];

            $controller = new $controllerClass();

            // Check if the method exists in the controller class
            if (!method_exists($controller, $method)) {
                throw new Exception(
                    "Erreur serveur",
                    500
                );
            }

            $controller->$method();

        } catch (Exception $exception) {
            // Set the HTTP response code based on the error type
            $code = $exception->getCode();
            http_response_code($code);

            // Render an error view with the message and error code
            $errorView = new View("Erreur $code");
            $errorView->render(
                'error',
                [
                    'errorMessage' => $exception->getMessage(),
                    'errorCode'    => $code
                ]
            );
        }
    }
}

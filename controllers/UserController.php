<?php

/**
 *
 */
class UserController
{
    /**
     * Displays the connection form
     * @throws Exception
     */
    public function showConnectionForm() : void
    {
        $action = Helpers::request('action', 'connectionForm', 'get');
        $view = new View('Connexion');
        $view->render("connectionForm", ["action" => $action]);
    }

    /**
     * Displays the registration form
     * @throws Exception
     */
    public function showRegistrationForm() : void
    {
        $view = new View('Inscription');
        $view->render("registrationForm");
    }

    public function showVendor() : void
    {
        $id = Helpers::request('id', null, 'get');
        $accountData = UserService::getAccountData($id);
        $availableBooks = UserService::getUserAvailableBooks($id);

        $view = new View('Page du vendeur');
        $view->render("vendor", [
            "accountData" => $accountData,
            "availableBooks" => $availableBooks["availableBooks"],
        ]);
    }

    /**
     * Displays personal account view
     * @throws Exception
     */
    public function showAccount(): void
    {
        Helpers::checkIfUserIsConnected();

        $userId = $_SESSION['user']['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleAccountUpdate($userId);
            exit;
        }

        $this->renderAccountView($userId);
    }

    /**
     * @param int $userId
     * @return void
     * @throws Exception
     * @throws Exception
     * @throws Exception
     */
    private function handleAccountUpdate(int $userId) : void
    {
        $formData = [
            'login' => Helpers::request('login', 'account', 'post'),
            'email' => Helpers::request('email', 'account', 'post'),
            'password' => Helpers::request('password', 'account', 'post'),
        ];

        try {
            UserService::updateProfile($formData);
            Helpers::redirect('account');
            exit;
        } catch (Exception $e) {
            $this->renderAccountView($userId, $e->getMessage(), $formData);
        }
    }

    /**
     * @throws Exception
     */
    private function renderAccountView(int $userId, string $error = null, array $formData = null) : void
    {
        $accountData = UserService::getAccountData($userId);

        if ($formData === null) {
            $formData = [
                'login' => $_SESSION['user']['login'],
                'email' => $_SESSION['user']['email'],
                'password' => ''
            ];
        }

        $viewData = array_merge($accountData, [
            'error' => $error,
            'formData' => $formData,
            'action' => Helpers::request('action', 'account', 'post')
        ]);

        $view = new View('Mon compte');
        $view->render('myAccount', $viewData);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function registerUser() : void
    {
        $error = null;

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            try {
                $login = Helpers::request("login");
                $email = Helpers::request("email");
                $password = Helpers::request("password");

                UserService::register($login, $email, $password);

                Helpers::redirect('login');
                exit;

            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }

        $view = new View("Inscription");
        $view->render('registrationForm', [
            'error' => $error,
            'formData' => [
                'login' => $_POST['login'] ?? '',
                'email' => $_POST['email'] ?? '',
            ]
        ]);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function loginUser(): void
    {
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $email = Helpers::request('email', null, 'post');
                $password = Helpers::request('password', null, 'post');

                UserService::login($email, $password);

                Helpers::redirect('account');
                exit;
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }

        $view = new View("Connexion");
        $view->render("connectionForm", [
            'error' => $error,
            'formData' => ['email' => $email ?? '', 'password' => '']
        ]);
    }

    /**
     * @return void
     */
    public function logoutUser() : void
    {
        UserService::logout();
        Helpers::redirect("home");
    }
}
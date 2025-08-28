<?php

/**
 * Controller responsible for user-related actions (authentication, registration...)
 */
class UserController extends BaseController
{
    /**
     * Displays the login form
     * @throws Exception
     */
    public function showConnectionForm() : void
    {
        $action = Helpers::getParameter('action', 'connectionForm', 'get');
        $this->render('connectionForm', ['action' => $action], 'Connexion');
    }

    /**
     * Displays the registration form
     * @return void
     * @throws Exception
     */
    public function showRegistrationForm() : void
    {
        $this->render('registrationForm', [], 'Inscription');
    }

    /**
     * Displays a user's public profile with their available books
     * @return void
     * @throws Exception
     */
    public function showVendor() : void
    {
        Helpers::checkIfUserIsConnected();

        $id = Helpers::getParameter('id', null, 'get');
        $accountData = UserService::getAccountData($id);
        $availableBooks = UserService::getUserAvailableBooks($id);

        $this->render(
            'vendor',
            [
                'accountData' => $accountData,
                'availableBooks' => $availableBooks['availableBooks']
            ],
            'Page du vendeur'
        );
    }

    /**
     * Displays the current user's account page
     * @return void
     * @throws Exception
     */
    public function showAccount(): void
    {
        Helpers::checkIfUserIsConnected();

        $userId = Helpers::getCurrentUserId();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleAccountUpdate($userId);
            return;
        }

        $this->renderAccountView($userId);
    }

    /**
     * Handles account update form submission
     * @param int $userId
     * @return void
     * @throws Exception
     */
    private function handleAccountUpdate(int $userId) : void
    {
        $formData = UserService::extractAccountFormData();

        try {
            UserService::updateProfile($formData);
            Helpers::redirect('account');
        } catch (Exception $e) {
            $this->renderAccountView($userId, $e->getMessage(), $formData);
        }
    }

    /**
     * Renders the account view with user data, form data and optional errors
     * @param int $userId
     * @param string|null $error
     * @param array|null $formData
     * @return void
     * @throws Exception
     */
    private function renderAccountView(int $userId, string $error = null, array $formData = null) : void
    {
        $viewData = UserService::prepareAccountViewData($userId, $error, $formData);
        $this->render('myAccount', $viewData, 'Mon compte');
    }

    /**
     * Handles user registration (form submission + display)
     * @return void
     * @throws Exception
     */
    public function registerUser() : void
    {
        $error = null;

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            try {
                $login = Helpers::getParameter("login", null, 'post');
                $email = Helpers::getParameter("email", null, 'post');
                $password = Helpers::getParameter("password", null, 'post');

                UserService::register($login, $email, $password);

                Helpers::redirect('login');
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }

        $this->render(
            'registrationForm',
            [
                'error' => $error,
                'formData' => [
                    'login' => $_POST['login'] ?? '',
                    'email' => $_POST['email'] ?? '',
                ],
            ],
            'Inscription'
        );
    }

    /**
     * Handles user login (form submission + display)
     * @return void
     * @throws Exception
     */
    public function loginUser(): void
    {
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $email = Helpers::getParameter('email', null, 'post');
                $password = Helpers::getParameter('password', null, 'post');

                UserService::login($email, $password);

                Helpers::redirect('account');
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }

        $this->render(
            "connectionForm",
            [
                'error' => $error,
                'formData' => ['email' => $email ?? '', 'password' => '']
            ],
            'Connexion',
        );
    }

    /**
     * Logs out the current user
     * @return void
     */
    public function logoutUser() : void
    {
        UserService::logout();
        Helpers::redirect("home");
    }
}

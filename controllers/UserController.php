<?php

class UserController
{
    /**
     * Displays the connection form
     * @throws Exception
     */
    public function showConnexionForm() : void
    {
        $view = new View('Connexion');
        $view->render("connectionForm");
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

    /**
     * Displays personal account view
     * @throws Exception
     */
    public function showAccount() : void
    {
        Helpers::checkIfUserIsConnected();
        $id = Helpers::request("id", null);

        $userManager = ManagerFactory::getUserManager();
        var_dump($_SESSION['user']);

        $user = $userManager->findUserById($_SESSION['user']['id']);

        var_dump($user);

        $view = new View('Mon compte');
        $view->render("myAccount", ["user" => $user]);
    }

    /**
     * Registers a new user
     * @throws Exception
     */
    public function registerUser() : void
    {
        $login = Helpers::request("login");
        $email = Helpers::request("email");
        $password = Helpers::request("password");
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Checks if fields are empty
        if (empty($login) || empty($email) || empty($password)) {
            throw new Exception("Tous les champs sont obligatoires");
        }

        $user = new User([
            "login" => $login,
            "email" => $email,
            "password" => $hashedPassword
        ]);

        $userManager = ManagerFactory::getUserManager();

        // Checks if login or email is already used
        if ($userManager->emailOrLoginExists($email, $login)) {
            throw new Exception("Ce login ou cet email est déjà utilisé");
        }

        // Inserts new user
        if ($userManager->addUser($user)) {
            Helpers::redirect("connectionForm");
            exit;
        } else {
            throw new Exception("Erreur lors de l’inscription.");
        }
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    public function loginUser() : void
    {
        $email = Helpers::request("email");
        $password = Helpers::request("password");

        if (empty($email) || empty($password)) {
            throw new Exception("Tous les champs sont obligatoires");
        }

        $userManager = ManagerFactory::getUserManager();

        // Search user by email
        $user = $userManager->findByEmail($email);

        if (!$user || !password_verify($password, $user->getPassword())) {
            throw new Exception("Les identifiants sont incorrects");
        }

        // Login successful, user is stored in session
        Helpers::startSession();
        $_SESSION['user'] = [
            'id' => $user->getId(),
            'login' => $user->getLogin(),
            'email' => $user->getEmail()
        ];

        Helpers::redirect("account");
    }

    /**
     * @return void
     */
    public function logoutUser() : void
    {
        Helpers::startSession();

        // Deletes session data
        session_unset();
        session_destroy();
        $_SESSION = [];

        // Redirects to the homepage
        Helpers::redirect("home");
    }
}
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

        $db = DBManager::getInstance()->getConnection();
        $userManager = new UserManager($db);

        // Checks if login or email is already used
        if ($userManager->emailOrLoginExists($email, $login)) {
            throw new Exception("Ce login ou cet email est déjà utilisé");
        }

        // Inserts new user
        if ($userManager->addUser($user)) {
            header('Location: index.php?route=connexion');
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

        $db = DBManager::getInstance()->getConnection();
        $userManager = new UserManager($db);

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
    }
}
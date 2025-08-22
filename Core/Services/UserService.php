<?php

/**
 * Manages authentication (login/logout/register/update)
 */
class UserService
{
    /**
     * Logs a user in by verifying email and password
     * @param string $email
     * @param string $password
     * @return array|null
     * @throws Exception
     */
    public static function login(string $email, string $password): ?array
    {
        $userManager = ManagerFactory::getUserManager();

        // Search user by email
        $user = $userManager->findByEmail($email);

        // Check if user exists and password is correct
        if (!$user || !password_verify($password, $user->getPassword())) {
            throw new Exception("Les identifiants sont incorrects");
        }

        // Login successful, user is stored in session
        Helpers::startSession();
        $_SESSION['user'] = [
            'id' => $user->getId(),
            'login' => $user->getLogin(),
            'email' => $user->getEmail(),
        ];

        return $_SESSION['user'];
    }

    /**
     * Logs out the current user
     * @return void
     */
    public static function logout(): void
    {
        Helpers::startSession();

        // Deletes session data and destroy the session
        session_unset();
        session_destroy();
        $_SESSION = [];
    }

    /**
     * Registers a new user
     * @throws Exception
     */
    public static function register(string $login, string $email, string $password): void
    {
        $userManager = ManagerFactory::getUserManager();

        // Check if all fields are completed
        if (empty($login) || empty($email) || empty($password)) {
            throw new Exception("Tous les champs sont obligatoires");
        }

        // Check if login or email is already used
        if ($userManager->emailOrLoginExists($login, $email)) {
            throw new Exception("Ce login ou cet email est déjà utilisé");
        }

        // Create a new User object with hashed password
        $user = new User([
            "login" => $login,
            "email" => $email,
            "password" => password_hash($password, PASSWORD_DEFAULT),
        ]);

        // Check email validity
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            throw new Exception("L'adresse email n'est pas valide");
        }

        // Inserts new user into database
        if (!$userManager->addUser($user)) {
            throw new Exception("Erreur lors de l’inscription.");
        }
    }

    /**
     * Updates a user
     * @param array $data
     * @return void
     * @throws Exception
     */
    public static function updateProfile(array $data): void
    {
        $login = Helpers::sanitize($data['login'] ?? '');
        $email = Helpers::sanitize($data['email'] ?? '');
        $password = $data['password'] ?? '';

        // Check if login or email is empty
        if (empty($login) || empty($email)) {
            throw new Exception("Le login et l'email sont obligatoires");
        }

        $userManager = ManagerFactory::getUserManager();
        $userId = Helpers::getCurrentUserId();
        $user = $userManager->findUserById($userId);

        if (!$user) {
            throw new Exception("Cet utilisateur n'existe pas.");
        }

        // Check if login or email is already used
        if ($userManager->emailOrLoginExists($login, $email, $user->getId())) {
            throw new Exception("Ce login ou cet email est déjà utilisé");
        }

        // Check email format validity
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("L'adresse email n'est pas valide");
        }

        // Update user data
        $user->setLogin($login);
        $user->setEmail($email);

        // If password is changed, hash and update it
        if (!empty($password)) {
            $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
        }

        try {
            // Update user in database
            $userManager->updateUser($user);

            // Update sessions data with new login/email
            $_SESSION['user']['login'] = $user->getLogin();
            $_SESSION['user']['email'] = $user->getEmail();
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la mise à jour : " . $e->getMessage());
        }
    }

    /**
     * Retrieve account information for a given user
     * @param int $userId
     * @return array
     * @throws Exception
     */
    public static function getAccountData(int $userId): array
    {
        $userManager = ManagerFactory::getUserManager();
        $bookManager = ManagerFactory::getBookManager();

        $user = $userManager->findUserById($userId);

        if(!$user) {
            throw new Exception("Cet utilisateur n'existe pas.", 404);
        }

        // Calculate years since registration
        $registeredYears = date('Y') - $user->getRegisterDate()->format('Y');
        $registeredSince = ($registeredYears <= 1) ? "1 an" : "$registeredYears ans";

        return [
            'user' => $user,
            'id' => $user->getId(),
            'registeredSince' => $registeredSince,
            'numberOfBooks' => $bookManager->findNumberOfBooks($userId),
            'userBooks' => $bookManager->findBooksByUserId($userId)
        ];
    }

    /**
     * Retrieve available books for a given user
     * @param int $userId
     * @return array
     */
    public static function getUserAvailableBooks(int $userId): array
    {
        $bookManager = ManagerFactory::getBookManager();

        return [
            'availableBooks' => $bookManager->findAvailableBooksByUserId($userId)
        ];
    }

    /**
     * Extacts form data from the account update form
     * @return array
     */
    public static function extractAccountFormData(): array
    {
        return [
            'login' => Helpers::getParameter('login', 'account', 'post'),
            'email' => Helpers::getParameter('email', 'account', 'post'),
            'password' => Helpers::getParameter('password', 'account', 'post'),
        ];
    }

    /**
     * Prepares data for the account view
     * @param int $userId
     * @param string|null $error
     * @param array|null $formData
     * @return array
     */
    public static function prepareAccountViewData(int $userId, ?string $error = null, ?array $formData = null): array
    {
        $accountData = self::getAccountData($userId);

        // If no data provided, fill with current session values
        if ($formData === null) {
            $formData = [
                'login' => $_SESSION['user']['login'],
                'email' => $_SESSION['user']['email'],
                'password' => ''
            ];
        }

        return array_merge($accountData, [
            'error' => $error,
            'formData' => $formData,
            'action' => Helpers::getParameter('action', 'account', 'post')
        ]);
    }
}

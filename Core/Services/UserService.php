<?php

/**
 * Manages authentication (login/logout/register/update)
 */
class UserService
{
    /**
     *
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
     *
     * @return void
     */
    public static function logout(): void
    {
        Helpers::startSession();

        // Deletes session data
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

        if (empty($login) || empty($email) || empty($password)) {
            throw new Exception("Tous les champs sont obligatoires");
        }

        // Checks if login or email is already used
        if ($userManager->emailOrLoginExists($login, $email)) {
            throw new Exception("Ce login ou cet email est déjà utilisé");
        }

        $user = new User([
            "login" => $login,
            "email" => $email,
            "password" => password_hash($password, PASSWORD_DEFAULT),
        ]);

        // Inserts new user
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

        if (empty($login) || empty($email)) {
            throw new Exception("Le login et l'email sont obligatoires");
        }

        $userManager = ManagerFactory::getUserManager();
        $userId = Helpers::getCurrentUserId();
        $user = $userManager->findUserById($userId);

        if (!$user) {
            throw new Exception("Cet utilisateur n'existe pas.");
        }

        if ($userManager->emailOrLoginExists($login, $email, $user->getId())) {
            throw new Exception("Ce login ou cet email est déjà utilisé");
        }

        $user->setLogin($login);
        $user->setEmail($email);

        if (!empty($password)) {
            $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
        }

        try {
            $userManager->updateUser($user);
            $_SESSION['user']['login'] = $user->getLogin();
            $_SESSION['user']['email'] = $user->getEmail();
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la mise à jour : " . $e->getMessage());
        }
    }

    /**
     * @param int $userId
     * @return array
     */
    public static function getAccountData(int $userId): array
    {
        $userManager = ManagerFactory::getUserManager();
        $bookManager = ManagerFactory::getBookManager();

        $user = $userManager->findUserById($userId);

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
     * @param int $userId
     * @param string|null $error
     * @param array|null $formData
     * @return array
     */
    public static function prepareAccountViewData(int $userId, ?string $error = null, ?array $formData = null): array
    {
        $accountData = self::getAccountData($userId);

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

<?php

/**
 * UserManager class that handles all database operations related to the User entity
 * (creating, updating or deleting users, checking for existing emails or logins)
 */
class UserManager extends AbstractEntityManager
{
    /**
     * Inserts a new user into the database
     * @param User $user
     * @return bool
     */
    public function addUser(User $user) : bool
    {
        $sql = $this->db->prepare("INSERT INTO user (login, email, password, register_date)
                                         VALUES(:login, :email, :password, NOW())");
        return $sql->execute([
            "login" => $user->getLogin(),
            "email" => $user->getEmail(),
            "password" => $user->getPassword(),
        ]);
    }

    public function updateUser(User $user) : bool
    {

    }

    public function deleteUser(User $user) : bool
    {

    }

    /**
     * Checks if a login or email is already used
     * @param string $login
     * @param string $email
     * @return bool
     */
    public function emailOrLoginExists(string $login, string $email) : bool
    {
        $sql = $this->db->prepare("SELECT COUNT(*) as total FROM user WHERE email = :email OR login = :login");
        $sql->execute([
            'email' => $email,
            'login' => $login,
        ]);

        $result = $sql->fetch();

        return $result['total'] > 0;
    }

    public function findByEmail(string $email) : ?User
    {
        $sql = $this->db->prepare("SELECT * FROM user WHERE email = :email");
        $sql->execute([
            'email' => $email,
        ]);

        $data = $sql->fetch();

        if ($data) {
            return new User($data);
        }

        return null;
    }
}

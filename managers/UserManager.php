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
    public function addUser(User $user): bool
    {
        $sql = "INSERT INTO user (login, email, password, register_date)
                VALUES(:login, :email, :password, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            "login" => $user->getLogin(),
            "email" => $user->getEmail(),
            "password" => $user->getPassword(),
        ]);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function updateUser(User $user): bool
    {
        if(!empty($user->getPassword())) {
            $sql = "UPDATE user SET login = :login, email = :email, password = :password WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                "login" => $user->getLogin(),
                "email" => $user->getEmail(),
                "password" => $user->getPassword(),
                "id" => $user->getId()
            ]);
        } else {
            $stmt = $this->db->prepare("UPDATE user SET login = :login, email = :email WHERE id = :id");
            return $stmt->execute([
                "login" => $user->getLogin(),
                "email" => $user->getEmail(),
                "id" => $user->getId()
            ]);
        }
    }

    /**
     * @param User $user
     * @return bool
     */
    public function deleteUser(User $user): bool
    {

    }

    /**
     * Checks if a login or email is already used
     * @param string $login
     * @param string $email
     * @param int|null $excludeUserId
     * @return bool
     */
    public function emailOrLoginExists(string $login, string $email, ?int $excludeUserId = null): bool
    {
        $sql = "SELECT COUNT(*) as total FROM user WHERE (email = :email OR login = :login)";

        if ($excludeUserId !== null) {
            $sql .= " AND id != :excludeUserId";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":login", $login);

        if ($excludeUserId !== null) {
            $stmt->bindValue(":excludeUserId", $excludeUserId, PDO::PARAM_INT);
        }

        $stmt->execute();
        $result = $stmt->fetch();

        return $result['total'] > 0;
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->execute([
            'email' => $email,
        ]);

        $data = $stmt->fetch();

        if ($data) {
            return new User($data);
        }

        return null;
    }

    /**
     * @param int $id
     * @return User|null
     */
    public function findUserById(int $id): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE id = :id");
        $stmt->execute([
            'id' => $id,
        ]);

        $data = $stmt->fetch();

        if ($data) {
            return new User($data);
        }

        return null;
    }
}

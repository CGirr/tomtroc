<?php

class User extends AbstractEntity
{
    /**
     * @var string $login
     */
    private string $login;

    /**
     * @var string $password
     */
    private string $password;

    /**
     * @var string $email
     */
    private string $email;

    /**
     * @var DateTime $registerDate
     */
    private DateTime $registerDate;

    /**
     * @var string $profilePicture
     */
    private string $profilePicture;

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return DateTime
     */
    public function getRegisterDate(): DateTime
    {
        return $this->registerDate;
    }

    /**
     * @param DateTime|string $registerDate
     */
    public function setRegisterDate(DateTime|string $registerDate): void
    {
        if (is_string($registerDate)) {
            $registerDate = DateTime::createFromFormat('Y-m-d', $registerDate);
        }
        $this->registerDate = $registerDate;
    }

    /**
     * @return string
     */
    public function getProfilePicture(): string
    {
        return $this->profilePicture;
    }

    /**
     * @param string $profilePicture
     */
    public function setProfilePicture(string $profilePicture): void
    {
        $this->profilePicture = $profilePicture;
    }
}
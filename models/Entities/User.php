<?php

class User extends AbstractEntity
{
    private string $login;
    private string $password;
    private string $email;
    private DateTime $registerDate;

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getRegisterDate(): DateTime
    {
        return $this->registerDate;
    }

    public function setRegisterDate(string|DateTime $registerDate): void
    {
        if (is_string($registerDate)) {
            $registerDate = DateTime::createFromFormat('Y-m-d H:i:s', $registerDate);
        }
        $this->registerDate = $registerDate;
    }
}
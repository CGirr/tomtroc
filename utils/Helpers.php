<?php

/**
 * Utility class containing static helper functions commonly used in the application (redirection, sanitization...)
 */

class Helpers {

    /**
     * @param string $action
     * @param array $params
     * @return void
     */
    public static function redirect(string $action, array $params = []) : void
    {
        $url = "index.php?action=$action";
        foreach ($params as $param => $paramValue) {
            $url .= "&$param=$paramValue";
        }
        header("Location: $url");
        exit();
    }

    /**
     * @param string $data
     * @return string
     */
    public static function sanitize(string $data) : string
    {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }


    /**
     * @param string $url
     * @param string $fallback
     * @return string
     */
    public static function sanitizeUrl(string $url) : string
    {
        return filter_var(trim($url), FILTER_SANITIZE_URL);
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @param string $method
     * @return mixed
     */
    public static function request(mixed $key, mixed $default = null, string $method = 'both') : mixed
    {
        switch(strtolower($method)) {
            case 'get':
                $value = $_GET[$key] ?? $default;
                break;
            case 'post' :
                $value = $_POST[$key] ?? $default;
                break;
            case 'both' :
                if (isset($_GET[$key])) {
                    $value = $_GET[$key];
                } elseif (isset($_POST[$key])) {
                    $value = $_POST[$key];
                } else {
                    $value = $default;
                }
                break;
            default :
                return $default;
        }

        return is_string($value) ? htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8') : $value;
    }

    /**
     * @return void
     */
    public static function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * @return bool
     */
    public static function isUserLoggedIn(): bool
    {
        return isset($_SESSION['user']);
    }

    /**
     * @return void
     */
    public static function checkIfUserIsConnected(): void
    {
        if(!isset($_SESSION['user'])) {
            self::redirect("connectionForm");
        }
    }
}
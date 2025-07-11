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
        return htmlspecialchars(trim($data, ENT_QUOTES, 'UTF-8'));
    }

    public static function request(string $key, mixed $default = null, string $method = 'both') : mixed
    {
        $value = null;

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
}
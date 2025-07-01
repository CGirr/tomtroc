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
    public static function sanitize(string $data) : string {
        return htmlspecialchars(trim($data, ENT_QUOTES, 'UTF-8'));
    }
}
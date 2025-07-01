<?php

spl_autoload_register(function ($class)
{
    if (file_exists('helpers/' . $class .'.php')) {
        require 'helpers/' . $class .'.php';
    }

    if (file_exists('controllers/' . $class .'.php')) {
        require_once 'controllers/' . $class .'.php';
    }

    if (file_exists('models/Entities' . $class .'.php')) {
        require_once 'models/Entities' . $class .'.php';
    }

    if (file_exists('models/Managers' . $class .'.php')) {
        require_once 'models/Managers' . $class .'.php';
    }

    if (file_exists('views/' . $class .'.php')) {
        require_once 'views/' . $class .'.php';
    }
});

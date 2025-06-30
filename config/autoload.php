<?php

spl_autoload_register(function ($class)
{
    if (file_exists('controllers/' . $class .'.php')) {
        require_once 'controllers/' . $class .'.php';
    }

    if (file_exists('src/model/' . $class .'.php')) {
        require_once 'src/model/' . $class .'.php';
    }

    if (file_exists('views/' . $class .'.php')) {
        require_once 'views/' . $class .'.php';
    }
});

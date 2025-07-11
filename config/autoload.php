<?php

spl_autoload_register(function ($class)
{
    if (file_exists('utils/' . $class .'.php')) {
        require 'utils/' . $class .'.php';
    }

    if (file_exists('controllers/' . $class .'.php')) {
        require 'controllers/' . $class .'.php';
    }

    if (file_exists('models/Entities' . $class .'.php')) {
        require 'models/Entities' . $class .'.php';
    }

    if (file_exists('models/Managers' . $class .'.php')) {
        require 'models/Managers' . $class .'.php';
    }

    if (file_exists('views/' . $class .'.php')) {
        require 'views/' . $class .'.php';
    }
});

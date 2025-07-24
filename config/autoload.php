<?php

spl_autoload_register(function ($class)
{
    if (file_exists('utils/' . $class .'.php')) {
        require 'utils/' . $class .'.php';
    }

    if (file_exists('controllers/' . $class .'.php')) {
        require 'controllers/' . $class .'.php';
    }

    if (file_exists('models/' . $class .'.php')) {
        require 'models/' . $class .'.php';
    }

    if (file_exists('managers/' . $class .'.php')) {
        require 'managers/' . $class .'.php';
    }

    if (file_exists('views/' . $class .'.php')) {
        require 'views/' . $class .'.php';
    }
});

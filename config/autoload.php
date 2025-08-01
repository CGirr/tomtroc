<?php

spl_autoload_register(function ($class)
{
    if (file_exists(__DIR__ . '/../utils/' . $class .'.php')) {
        require __DIR__ . '/../utils/' . $class .'.php';
    }

    if (file_exists(__DIR__ . '/../controllers/' . $class .'.php')) {
        require __DIR__ . '/../controllers/' . $class .'.php';
    }

    if (file_exists(__DIR__ . '/../models/' . $class .'.php')) {
        require __DIR__ . '/../models/' . $class .'.php';
    }

    if (file_exists(__DIR__ . '/../managers/' . $class .'.php')) {
        require __DIR__ . '/../managers/' . $class .'.php';
    }

    if (file_exists(__DIR__ . '/../core/' . $class .'.php')) {
        require __DIR__ . '/../core/' . $class .'.php';
    }

    if (file_exists(__DIR__ . '/../core/services/' . $class .'.php')) {
        require __DIR__ . '/../core/services/' . $class .'.php';
    }
});

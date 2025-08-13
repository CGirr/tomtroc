<?php

spl_autoload_register(function ($class)
{
    if (file_exists(__DIR__ . '/../Utils/' . $class .'.php')) {
        require __DIR__ . '/../Utils/' . $class .'.php';
    }

    if (file_exists(__DIR__ . '/../Controllers/' . $class .'.php')) {
        require __DIR__ . '/../Controllers/' . $class .'.php';
    }

    if (file_exists(__DIR__ . '/../Entities/' . $class .'.php')) {
        require __DIR__ . '/../Entities/' . $class .'.php';
    }

    if (file_exists(__DIR__ . '/../Managers/' . $class .'.php')) {
        require __DIR__ . '/../Managers/' . $class .'.php';
    }

    if (file_exists(__DIR__ . '/../Core/' . $class .'.php')) {
        require __DIR__ . '/../Core/' . $class .'.php';
    }

    if (file_exists(__DIR__ . '/../Core/Services/' . $class .'.php')) {
        require __DIR__ . '/../Core/Services/' . $class .'.php';
    }

    if (file_exists(__DIR__ . '/../Models/' . $class .'.php')) {
        require __DIR__ . '/../Models/' . $class .'.php';
    }
});

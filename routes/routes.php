<?php

include(__DIR__ .  '/./web.php');

function route($name)
{
    global $routes;

    if (isset($routes[$name])) {
        return $routes[$name]['url'];
    }

    return '/tauheed-academy-project/';
}
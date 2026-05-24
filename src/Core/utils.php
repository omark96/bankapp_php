<?php

use Core\Response;
use Core\Exceptions\HttpException;

function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
}

function base_path(string $path)
{
    return BASE_PATH . $path;
}

function view(string $path, array $attributes = [], string $layout = 'default')
{
    extract($attributes);

    ob_start();
    require base_path("views/$path.view.php");

    $slot = ob_get_clean();

    require base_path("views/layouts/$layout.php");
}

function component(string $path, array $attributes = [])
{
    extract($attributes);
    require base_path("views/components/$path.view.php");
}

function abort($code = Response::NOT_FOUND)
{
    http_response_code($code);
    throw new HttpException('HTTP Error', $code);
}

function redirect($path)
{
    header("location: $path");
    die();
}

function authorize($condition, $status = Response::FORBIDDEN)
{
    if (!$condition) {
        abort($status);
    }
}
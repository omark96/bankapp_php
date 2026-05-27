<?php

use Core\Response;
use Core\Exceptions\HttpException;
use Core\Session;

function dd($value): void
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
}

function base_path(string $path): string
{
    return BASE_PATH . $path;
}

function view(string $path, array $attributes = [], ?string $layout = 'default'): void
{
    extract($attributes);
    if ($layout) {
        ob_start();
        require base_path("views/$path.view.php");

        $slot = ob_get_clean();
        require base_path("views/layouts/$layout.php");
    } else {
        require base_path("views/$path.view.php");
    }
}

function component(string $path, array $attributes = []): void
{
    extract($attributes);
    require base_path("views/components/$path.view.php");
}

function abort($code = Response::NOT_FOUND)
{
    http_response_code($code);
    throw new HttpException('HTTP Error', $code);
}

function redirect($path): void
{
    header("location: $path");
    die();
}

function authorize($condition, $status = Response::FORBIDDEN): void
{
    if (!$condition) {
        abort($status);
    }
}

function currentPath(): string
{
    return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
}

function e($string): string
{
    return htmlspecialchars($string);
}

function csrf_token(): string
{
    if (!Session::has('csrf_token')) {
        $token = bin2hex(random_bytes(32));
        Session::set('csrf_token', $token);
        header('HX-Trigger: {"updateCsrf": "' . $token . '"}');
    }
    return Session::get('csrf_token');
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="'
        . htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8')
        . '">';
}

function csrf_verify(): void
{
    $token = $_POST['csrf_token'] ?? '';
    if (!hash_equals(csrf_token(), $token)) {
        abort(Response::FORBIDDEN);
    }
    Session::unset('csrf_token');
}
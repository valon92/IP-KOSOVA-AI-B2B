<?php

/**
 * Vercel serverless entry — delegates to Laravel's public front controller.
 * @see https://github.com/juicyfx/vercel-examples/tree/master/php-laravel
 */

// Vercel routes everything through /api/index.php; align path info with Laravel routes.
if (isset($_SERVER['SCRIPT_NAME']) && str_starts_with($_SERVER['SCRIPT_NAME'], '/api/')) {
    $_SERVER['SCRIPT_NAME'] = '/index.php';
    $_SERVER['SCRIPT_FILENAME'] = __DIR__.'/../public/index.php';
}

require __DIR__.'/../public/index.php';

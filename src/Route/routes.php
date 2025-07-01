<?php

/**
 * @copyright  Copyright (c) 2025 Code Chip (https://codechip.com.br)
 * @author     Will <willvix@outlook.com>
 * @Link       https://github.com/code-chip
 */

declare(strict_types=1);

use App\Route\Router;
use App\Controller\AuthController;
use App\Controller\HomeController;

$router = new Router();

$router->register('GET', '/', fn() => (new AuthController())->showLogin());
$router->register('POST', '/login', fn($body) => (new AuthController())->handleLogin($body));

$router->register('GET', '/home', fn() => (new HomeController())->showHome());

<?php

/**
 * @copyright  Copyright (c) 2025 Code Chip (https://codechip.com.br)
 * @author     Will <willvix@outlook.com>
 * @Link       https://github.com/code-chip
 */

declare(strict_types=1);

namespace App\Controller;

use App\Service\AuthService;

class AuthController
{
    private AuthService $service;

    public function __construct(AuthService $service) {
        $this->service = $service;
    }

    public function showLogin()
    {
        require '../src/View/Login.php';
    }

    public function handleLogin(array $input)
    {
        if ($this->service->checkLogin($input)) {
            $_SESSION['authenticated'] = true;
            header('Location: /home');
            exit;
        }

        $_SESSION['authenticated'] = false;
        header('Location: /?error=1');
        exit;
    }
}

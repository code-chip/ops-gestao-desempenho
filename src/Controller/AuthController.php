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

    public function __construct() {
        $this->service = new AuthService;;
    }

    public function showLogin()
    {
        require '../src/View/Login.php';
    }

    public function handleLogin()
    {
        $input = [
            'user' => $_POST['usuario'],
            'password' => $_POST['senha']
        ];

        $this->service->checkLogin($input);

        if ($this->service->checkLogin($input)) {
            $_SESSION['autenticado'] = true;
            header('Location: /home');
        } else {
            $_SESSION['nao_autenticado'] = true;
            header('Location: /');
            exit;
        }
    }
}

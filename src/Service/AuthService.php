<?php

/**
 * @copyright  Copyright (c) 2025 Code Chip (https://codechip.com.br)
 * @author     Will <willvix@outlook.com>
 * @Link       https://github.com/code-chip
 */

declare(strict_types=1);

namespace App\Service;

use App\Repository\AuthRepository;

class AuthService
{
    private AuthRepository $repo;

    public function __construct()
    {
        $this->repo = new AuthRepository();
    }

    public function checkLogin($input): bool
    {
        $user = $this->repo->checkLogin($input);

        $_SESSION["nameUser"] = $user['NOME'];
        $_SESSION['userId'] = $user['ID'];        

        return true;
    }
}

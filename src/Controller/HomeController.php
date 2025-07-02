<?php

/**
 * @copyright  Copyright (c) 2025 Code Chip (https://codechip.com.br)
 * @author     Will <willvix@outlook.com>
 * @Link       https://github.com/code-chip
 */

declare(strict_types=1);

namespace App\Controller;

class HomeController
{
    public function showHome()
    {
        isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true ? require '../src/View/Home.php' : header('Location: /');
    }
}
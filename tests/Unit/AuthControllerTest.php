<?php

/**
 * @copyright  Copyright (c) 2025 Code Chip (https://codechip.com.br)
 * @author     Will <willvix@outlook.com>
 * @Link       https://github.com/code-chip
 */

declare(strict_types=1);

namespace App\s\Unit;

use App\Controller\AuthController;
use App\Service\AuthService;
use PHPUnit\Framework\TestCase;

class AuthControllerTest extends TestCase
{
    private $serviceMock;
    private AuthController $controller;

    protected function setUp(): void
    {
        $this->serviceMock = $this->createMock(AuthService::class);
        $this->controller = new AuthController($this->serviceMock);

        if (!isset($_SESSION)) {
            $_SESSION = [];
        }
    }

    protected function tearDown(): void
    {
        $_SESSION = [];
        if (function_exists('xdebug_get_headers')) {
            header_remove();
        }
    }

    public function testHandleLoginWithValidCredentials(): void
    {
        $this->serviceMock
            ->expects($this->once())
            ->method('checkLogin')
            ->willReturn(true);
        
        $input = ['user' => 'integration.test', 'password' => 'test@2025'];

        // Captura a saída do header() e previne o exit
        $this->expectOutputRegex('/.*/'); // evitar erro por output vazio

        try {
            $this->controller->handleLogin($input);
        } catch (\Throwable $e) {
            // Ignora o exit
        }

        $this->assertTrue($_SESSION['authenticated']);
    }

    public function testHandleLoginWithInvalidCredentials()
    {
        $this->serviceMock
            ->expects($this->once())
            ->method('checkLogin')
            ->willReturn(false);

        $input = ['user' => 'invalidUser', 'password' => 'invalidPass'];

        $this->expectOutputRegex('/.*/');

        try {
            $this->controller->handleLogin($input);
        } catch (\Throwable $e) {
            // Ignora o exit
        }

        $this->assertFalse($_SESSION['authenticated']);
    }
}

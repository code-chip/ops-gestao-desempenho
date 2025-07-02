<?php

/**
 * @copyright  Copyright (c) 2025 Code Chip (https://codechip.com.br)
 * @author     Will <willvix@outlook.com>
 * @Link       https://github.com/code-chip
 */

declare(strict_types=1);

namespace App\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Tests\Traits\HttpRequestTrait;

class AuthControllerTest extends TestCase
{
    use HttpRequestTrait;
    public function testRouteDefault()
    {
        $response = $this->httpRequest('GET', '/');

        $this->assertEquals(200, $response['status']);
        $this->assertStringContainsString('<title>Gestão de Desempenho - Login</title>', $response['body']);
        $this->assertStringContainsString('<form action="/login" method="POST">', $response['body']);
        $this->assertStringContainsString('<input name="user"', $response['body']);
        $this->assertStringContainsString('<input name="password"', $response['body']);
        $this->assertStringContainsString('type="password"', $response['body']);

        ob_start();
        require __DIR__ . '/../../src/View/Login.php';
        $expectHtml = ob_get_clean();
        $this->assertEquals(trim($expectHtml), trim($response['body']));
    }

    public function testAuthenticationWithInvalidCredentials()
    {
        $form = [
            'user' => 'existedUser',
            'password' => 'myPassword'
        ];

        $response = $this->httpRequest('POST', '/login', $form);
        $this->assertEquals(302, $response['status']);
        $this->assertArrayHasKey('headers', $response);
        $this->assertArrayHasKey('Location', $response['headers']);
        $this->assertEquals('/?error=1', $response['headers']['Location']);
    }

    public function testAuthenticationWithValidCredentials()
    {
        $form = [
            'user' => 'integration.test',
            'password' => 'test@2025'
        ];

        $response = $this->httpRequest('POST', '/login', $form);
        $this->assertEquals(302, $response['status']);
        $this->assertArrayHasKey('headers', $response);
        $this->assertArrayHasKey('Location', $response['headers']);
        $this->assertEquals('/home', $response['headers']['Location']);
    }
}
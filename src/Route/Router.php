<?php

/**
 * @copyright  Copyright (c) 2025 Code Chip (https://codechip.com.br)
 * @author     Will <willvix@outlook.com>
 * @Link       https://github.com/code-chip
 */

declare(strict_types=1);

namespace App\Route;

class Router
{
    private array $routes = [];
    private string $path = '';
    private string $method = '';
    private array $body = [];

    public function register(string $method, string $route, callable $handler): void
    {
        $this->routes[strtoupper($method)][$route] = $handler;
    }

    public function dispatch(string $uri, string $method): void
    {
        //header('Content-Type: application/json');
        $this->method = strtoupper($method);
        $this->body = json_decode(file_get_contents('php://input'), true) ?? [];

        $parsedUrl = parse_url($uri);
        $this->path = $parsedUrl['path'] ?? '/';
        $this->path = rtrim($this->path, '/');
        if ($this->path === '') {
            $this->path = '/';
        }

        $routes = $this->routes[$this->method] ?? [];

        if (isset($routes[$this->path])) {
            call_user_func($routes[$this->path], $this->body);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Route not found']);
        }
        
    }
}

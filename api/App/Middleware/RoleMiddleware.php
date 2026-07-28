<?php

namespace App\Middleware;

use Core\ApiResponse;

class RoleMiddleware
{
    private string $requiredRole;

    public function __construct(string $requiredRole)
    {
        $this->requiredRole = $requiredRole;
    }
    /**
     * Handle role middleware
     * @param callable $next Next middleware/controller
     * @param array $payload Decoded JWT payload
     * @return mixed
     */
    public function __invoke(callable $next, array $payload)
    {
        if (!isset($payload['role'])) {
            ApiResponse::error("Rôle non défini dans le token", [], 403);
            return;
        }

        if ($payload['role'] !== $this->requiredRole) {
            ApiResponse::error("Accès refusé : rôle insuffisant", [], 403);
            return;
        }

        $next($payload);
    }
}

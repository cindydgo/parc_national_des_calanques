<?php

namespace App\Middleware;

//use App\Auth\RolesPermissions;
use Core\ApiResponse;

class PermissionMiddleware
{
    private string $requiredPermission;

    public function __construct(string $requiredPermission)
    {
        $this->requiredPermission = $requiredPermission;
    }

    public function __invoke(callable $next, array $payload)
    {
        if (!isset($payload['role'])) {
            ApiResponse::error("Rôle non défini dans le token", [], 403);
            return;
        }

        /* if (!RolesPermissions::hasPermission($payload['role'], $this->requiredPermission)) {
            ApiResponse::error("Accès refusé : permission insuffisante", [], 403);
            return;
        } */
        
        $next($payload);
    }
}


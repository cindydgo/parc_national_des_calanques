<?php

namespace App\Middleware;

use Utils\Auth;
use Core\ApiResponse;

class AuthMiddleware
{
    private Auth $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle authentication middleware
     * @param callable $next Next middleware/controller
     * @return mixed
     */
    public function __invoke(callable $next)
    {
        $jwtToken = $_COOKIE['jwt_token'] ?? null;

        $payload = $this->auth->checkAuth($jwtToken);

        if ($payload === null) {
            ApiResponse::error("Token invalide ou expiré", [], 401);
            return;
        }

        return $next($payload);
    }
}

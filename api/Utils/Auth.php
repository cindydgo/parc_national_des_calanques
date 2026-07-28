<?php
namespace Utils;

/**
 * Authentication utility class
 */
class Auth
{
    private ?JWT $jwt = null;
    private string $secret = '';

    public function __construct(JWT $jwt, string $secret)
    {
        $this->jwt = $jwt;
        $this->secret = $secret;
    }

    /**
     * Check authentication
     * @param string $jwtToken JWT token
     * @return array|null Payload if valid, otherwise null
     */
    public function checkAuth(string $jwtToken): ?array
    {
        if (!$this->jwt->validateToken($jwtToken, $this->secret)) {
            return null;
        }

        return $this->jwt->getPayload($jwtToken);
    }
}
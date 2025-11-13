<?php
namespace Utils;

class Auth
{
    /**
     * CheckAuth testable
     * @param string $jwtToken JWT token
     * @param string $secret Secret key
     * @return array|null Payload if valid, otherwise null
     */
    public function checkAuth(string $jwtToken, string $secret): ?array
    {
        $jwt = new JWT();

        if (!$jwt->validateToken($jwtToken, $secret)) {
            return null;
        }

        $payload = $jwt->getPayload($jwtToken);

        return $payload;
    }
}
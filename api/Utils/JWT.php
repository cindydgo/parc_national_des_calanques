<?php
namespace Utils;

class JWT
{
    /**
     * Encode base64 URL-safe
     * @param string $data Data to encode
     * @return string
     */
    private function base64UrlEncode($data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * Decode base64 URL-safe
     * @param string $data Data to decode
     * @return string
     */
    private function base64UrlDecode($data): string
    {
        $base64 = strtr($data, '-_', '+/');
        $base64Padded = str_pad($base64, strlen($base64) % 4, '=', STR_PAD_RIGHT);
        return base64_decode($base64Padded);
    }

    /**
     *  Generate JWT Token
     * @param array $header Header of the token
     * @param array $payload Payload of the token
     * @param string $secret Secret key
     * @param int $validity Validity duration (in seconds)
     * @return string
     */
    public function generateToken(array $header, array $payload, string $secret, int $validity = 3600): string
    {
        if ($validity > 0) {
            $now = time();
            $payload['iat'] = $now;
            $payload['exp'] = $now + $validity;
        }

        $base64Header = $this->base64UrlEncode(json_encode($header));
        $base64Payload = $this->base64UrlEncode(json_encode($payload));

        $signature = hash_hmac('sha256', "$base64Header.$base64Payload", $secret, true);
        $base64Signature = $this->base64UrlEncode($signature);

        return "$base64Header.$base64Payload.$base64Signature";
    }

    /**
     * Get Payload from JWT Token
     * @param string $token Token to decode
     * @return array|null
     */
    public function getPayload(string $token): ?array
    {
        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return null;
        }
        $payload = $this->base64UrlDecode($parts[1]);
        return json_decode($payload, true);
    }
    
    /**
     * Validate JWT Token
     * @param string $token Token to validate
     * @param string $secret Secret key
     * @return bool
     */
    public function validateToken(string $token, string $secret): bool
    {
        list($base64UrlHeader, $base64UrlPayload, $base64UrlSignature) = explode('.', $token);

        $signature = $this->base64UrlDecode($base64UrlSignature);
        $expectedSignature = hash_hmac('sha256', "$base64UrlHeader.$base64UrlPayload", $secret, true);

        if (!hash_equals($signature, $expectedSignature)) return false;

        /* $payload = json_decode($this->base64UrlDecode($base64UrlPayload), true);
        if (isset($payload['exp']) && time() > $payload['exp']) return false; */

        return true;
    }
}
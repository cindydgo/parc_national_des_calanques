<?php

namespace Tests\Utils;

use PHPUnit\Framework\TestCase;
use Utils\JWT;

class JWTTest extends TestCase
{
    private JWT $jwt;
    private string $secret;

    protected function setUp(): void
    {
        $this->jwt = new JWT();
        $this->secret = 'my_secret_key';
    }

    public function testGenerateTokenReturnsString(): void
    {
        $token = $this->jwt->generateToken(
            ['alg' => 'HS256', 'typ' => 'JWT'],
            [
                'id' => 1,
                'username' => 'admin',
                'role' => 1
            ],
            $this->secret
        );

        $this->assertIsString($token);
        $this->assertNotEmpty($token);
    }


    public function testGeneratedTokenHasThreeParts(): void
    {
        $token = $this->jwt->generateToken(
            ['alg' => 'HS256', 'typ' => 'JWT'],
            ['id' => 1],
            $this->secret
        );

        $this->assertCount(3, explode('.', $token));
    }


    public function testGetPayloadReturnsCorrectData(): void
    {
        $payload = [
            'id' => 15,
            'username' => 'john',
            'role' => 2
        ];

        $token = $this->jwt->generateToken(
            ['alg' => 'HS256', 'typ' => 'JWT'],
            $payload,
            $this->secret
        );

        $decoded = $this->jwt->getPayload($token);

        $this->assertEquals(15, $decoded['id']);
        $this->assertEquals('john', $decoded['username']);
        $this->assertEquals(2, $decoded['role']);

        $this->assertArrayHasKey('iat', $decoded);
        $this->assertArrayHasKey('exp', $decoded);
    }


    public function testValidateTokenReturnsTrueForValidToken(): void
    {
        $token = $this->jwt->generateToken(
            ['alg' => 'HS256', 'typ' => 'JWT'],
            ['id' => 1],
            $this->secret
        );

        $this->assertTrue(
            $this->jwt->validateToken($token, $this->secret)
        );
    }


    public function testValidateTokenReturnsFalseForInvalidSecret(): void
    {
        $token = $this->jwt->generateToken(
            ['alg' => 'HS256', 'typ' => 'JWT'],
            ['id' => 1],
            $this->secret
        );

        $this->assertFalse(
            $this->jwt->validateToken($token, 'wrong_secret')
        );
    }


    public function testGetPayloadReturnsNullForMalformedToken(): void
    {
        $payload = $this->jwt->getPayload('invalid.token');

        $this->assertNull($payload);
    }


    public function testGeneratedTokensAreDifferent(): void
    {
        $token1 = $this->jwt->generateToken(
            ['alg' => 'HS256', 'typ' => 'JWT'],
            ['id' => 1],
            $this->secret
        );

        sleep(1);

        $token2 = $this->jwt->generateToken(
            ['alg' => 'HS256', 'typ' => 'JWT'],
            ['id' => 1],
            $this->secret
        );

        $this->assertNotEquals($token1, $token2);
    }


    public function testPayloadContainsIAtAndExp(): void
    {
        $token = $this->jwt->generateToken(
            ['alg' => 'HS256', 'typ' => 'JWT'],
            ['id' => 8],
            $this->secret
        );

        $payload = $this->jwt->getPayload($token);

        $this->assertArrayHasKey('iat', $payload);
        $this->assertArrayHasKey('exp', $payload);

        $this->assertGreaterThan(
            $payload['iat'],
            $payload['exp']
        );
    }
}
<?php

namespace Tests\Utils;

use PHPUnit\Framework\TestCase;
use Utils\Auth;
use Utils\JWT;

class AuthTest extends TestCase
{
    private string $secret;

    protected function setUp(): void
    {
        $this->secret = 'my_secret_key';
    }

    public function testCheckAuthReturnsPayloadWhenTokenIsValid(): void
    {
        $token = 'valid.jwt.token';

        $expectedPayload = [
            'id' => 1,
            'username' => 'admin',
            'role' => 1
        ];

        $jwtMock = $this->createMock(JWT::class);

        $jwtMock->expects($this->once())
            ->method('validateToken')
            ->with($token, $this->secret)
            ->willReturn(true);

        $jwtMock->expects($this->once())
            ->method('getPayload')
            ->with($token)
            ->willReturn($expectedPayload);

        $auth = new Auth($jwtMock, $this->secret);

        $result = $auth->checkAuth($token);

        $this->assertEquals($expectedPayload, $result);
    }


    public function testCheckAuthReturnsNullWhenTokenIsInvalid(): void
    {
        $token = 'invalid.jwt.token';

        $jwtMock = $this->createMock(JWT::class);

        $jwtMock->expects($this->once())
            ->method('validateToken')
            ->with($token, $this->secret)
            ->willReturn(false);

        $jwtMock->expects($this->never())
            ->method('getPayload');

        $auth = new Auth($jwtMock, $this->secret);

        $result = $auth->checkAuth($token);

        $this->assertNull($result);
    }


    public function testCheckAuthUsesCorrectSecret(): void
    {
        $token = 'token.example.value';

        $jwtMock = $this->createMock(JWT::class);

        $jwtMock->expects($this->once())
            ->method('validateToken')
            ->with(
                $token,
                'my_secret_key'
            )
            ->willReturn(true);

        $jwtMock->method('getPayload')
            ->willReturn([
                'id' => 10
            ]);

        $auth = new Auth($jwtMock, $this->secret);

        $result = $auth->checkAuth($token);

        $this->assertArrayHasKey('id', $result);
        $this->assertEquals(10, $result['id']);
    }


    public function testCheckAuthDoesNotGetPayloadWhenValidationFails(): void
    {
        $jwtMock = $this->createMock(JWT::class);

        $jwtMock->expects($this->once())
            ->method('validateToken')
            ->willReturn(false);

        $jwtMock->expects($this->never())
            ->method('getPayload');

        $auth = new Auth($jwtMock, $this->secret);

        $result = $auth->checkAuth('bad.token');

        $this->assertNull($result);
    }
}
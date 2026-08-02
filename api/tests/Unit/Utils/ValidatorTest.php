<?php

namespace Tests\Utils;

use PHPUnit\Framework\TestCase;
use Utils\Validator;

class ValidatorTest extends TestCase
{
    public function testValidEmailReturnsTrue(): void
    {
        $this->assertTrue(
            Validator::isValidEmail('john.doe@example.com')
        );
    }


    public function testInvalidEmailReturnsFalse(): void
    {
        $this->assertFalse(
            Validator::isValidEmail('john.doe')
        );
    }


    public function testEmptyEmailReturnsFalse(): void
    {
        $this->assertFalse(
            Validator::isValidEmail('')
        );
    }


    public function testValidUsernameReturnsTrue(): void
    {
        $this->assertTrue(
            Validator::isValidUsername('john_doe')
        );
    }


    public function testUsernameTooShortReturnsFalse(): void
    {
        $this->assertFalse(
            Validator::isValidUsername('ab')
        );
    }


    public function testUsernameTooLongReturnsFalse(): void
    {
        $this->assertFalse(
            Validator::isValidUsername('abcdefghijklmnopqrstuvwxyz')
        );
    }


    public function testUsernameWithSpecialCharsReturnsFalse(): void
    {
        $this->assertFalse(
            Validator::isValidUsername('john@doe')
        );
    }


    public function testUsernameWithSpaceReturnsFalse(): void
    {
        $this->assertFalse(
            Validator::isValidUsername('john doe')
        );
    }


    public function testValidPasswordReturnsTrue(): void
    {
        $this->assertTrue(
            Validator::isValidPassword('Password123')
        );
    }


    public function testPwdWithoutUppercaseReturnsFalse(): void
    {
        $this->assertFalse(
            Validator::isValidPassword('password123')
        );
    }


    public function testPwdWithoutLowercaseReturnsFalse(): void
    {
        $this->assertFalse(
            Validator::isValidPassword('PASSWORD123')
        );
    }


    public function testPwdWithoutNumberReturnsFalse(): void
    {
        $this->assertFalse(
            Validator::isValidPassword('Password')
        );
    }


    public function testPwdTooShortReturnsFalse(): void
    {
        $this->assertFalse(
            Validator::isValidPassword('Pass1')
        );
    }


    public function testEmptyPwdReturnsFalse(): void
    {
        $this->assertFalse(
            Validator::isValidPassword('')
        );
    }
}

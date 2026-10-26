<?php
require_once __DIR__ . '/TestUserRepository.php';

use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    private TestUserRepository $repository;

    private const ROLE_ID = 1;

    protected function setUp(): void
    {
        $this->repository = new TestUserRepository();
        $this->repository->clearTable();
    }

    private function makeUser(string $username, ?string $email = null): int
    {
        $email ??= preg_replace('/\s+/', '', strtolower($username)) . '@test.com';

        return $this->repository->createUser([
            'username' => $username,
            'email'    => $email,
            'password' => password_hash('secret', PASSWORD_DEFAULT),
            'role_id'  => self::ROLE_ID,
        ]);
    }

    public function testCreateUser(): void
    {
        $id = $this->makeUser('Jean');

        $this->assertIsInt($id);
        $this->assertGreaterThan(0, $id);

        $user = $this->repository->getUser($id);

        $this->assertNotNull($user);
        $this->assertSame('Jean', $user['username']);
    }

    public function testReadOneUser(): void
    {
        $id = $this->makeUser('Alice', 'alice@test.com');

        $user = $this->repository->getUser($id);

        $this->assertNotNull($user);
        $this->assertSame('Alice', $user['username']);
        $this->assertSame('alice@test.com', $user['email']);
    }

    public function testReadUnknownUser(): void
    {
        $this->assertNull($this->repository->getUser(999999));
    }

    public function testUpdateUser(): void
    {
        $id = $this->makeUser('Bob');

        $result = $this->repository->updateUser($id, [
            'username' => 'Robert',
        ]);

        $this->assertTrue($result);

        $user = $this->repository->getUser($id);

        $this->assertNotNull($user);
        $this->assertSame('Robert', $user['username']);
    }

    public function testDeleteUser(): void
    {
        $id = $this->makeUser('Marc');

        $this->assertNotNull($this->repository->getUser($id));

        $result = $this->repository->deleteUser($id);

        $this->assertTrue($result);
        $this->assertNull($this->repository->getUser($id));
    }

    public function testWhereFilter(): void
    {
        $this->makeUser('Paul');
        $this->makeUser('Julie');

        $users = $this->repository->getUsers([
            'username' => 'Julie',
        ]);

        $this->assertCount(1, $users);
        $this->assertSame('Julie', $users[0]['username']);
    }

    public function testOrderBy(): void
    {
        $this->makeUser('Zoe');
        $this->makeUser('Alice');

        $users = $this->repository->getUsers([
            'order_by'  => 'username',
            'order_dir' => 'ASC',
        ]);

        $this->assertSame('Alice', $users[0]['username']);
        $this->assertSame('Zoe', $users[1]['username']);
    }

    public function testLimit(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $this->makeUser("User$i");
        }

        $users = $this->repository->getUsers([
            'limit' => 2,
        ]);

        $this->assertCount(2, $users);
    }
}

<?php
require_once __DIR__ . '/TestUserRepository.php';

use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    private TestUserRepository $repository;


    protected function setUp(): void
    {
        $this->repository = new TestUserRepository();

        $this->repository->clearTable();
    }


    private function userData(string $username, string $email): array
    {
        return [
            'username' => $username,
            'password' => password_hash('secret', PASSWORD_DEFAULT),
            'email' => $email,
            'role_id' => 1
        ];
    }


    public function testCreateUser(): void
    {
        $id = $this->repository->createUser($this->userData('Jean', 'jean@test.com'));

        $this->assertIsInt($id);
        $this->assertGreaterThan(0, $id);

        $user = $this->repository->getUser($id);

        $this->assertNotNull($user);
        $this->assertSame('Jean', $user['username']);
    }


    public function testReadOneUser(): void
    {
        $id = $this->repository->createUser($this->userData('Alice', 'alice@test.com'));

        $user = $this->repository->getUser($id);

        $this->assertNotNull($user);
        $this->assertSame('Alice', $user['username']);
        $this->assertSame('alice@test.com', $user['email']);
    }


    public function testReadUnknownUser(): void
    {
        $user = $this->repository->getUser(999);

        $this->assertNull($user);
    }


    public function testUpdateUser(): void
    {
        $id = $this->repository->createUser($this->userData('Bob', 'bob@test.com'));

        $result = $this->repository->updateUser($id, [
            'username' => 'Robert'
        ]);

        $this->assertTrue($result);

        $user = $this->repository->getUser($id);

        $this->assertSame(
            'Robert',
            $user['username']
        );
    }


    public function testDeleteUser(): void
    {
        $id = $this->repository->createUser($this->userData('Marc', 'marc@test.com'));

        $this->assertNotNull($this->repository->getUser($id));

        $result = $this->repository->deleteUser($id);

        $this->assertTrue($result);

        $user = $this->repository->getUser($id);

        $this->assertNull($user);
    }


    public function testWhereFilter(): void
    {
        $this->repository->createUser($this->userData('Paul', 'paul@test.com'));

        $this->repository->createUser($this->userData('Julie', 'julie@test.com'));


        $users = $this->repository->getUsers([
            'username' => 'Julie'
        ]);


        $this->assertCount(1, $users);
        $this->assertSame(
            'Julie',
            $users[0]['username']
        );
    }


    public function testOrderBy(): void
    {
        $this->repository->createUser($this->userData('Zoe', 'zoe@test.com'));

        $this->repository->createUser($this->userData('Alice', 'alice@test.com'));


        $users = $this->repository->getUsers([
            'order_by' => 'username',
            'order_dir' => 'ASC'
        ]);


        $this->assertSame(
            'Alice',
            $users[0]['username']
        );
    }


    public function testLimit(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $this->repository->createUser($this->userData("User $i", "user$i@test.com"));
        }


        $users = $this->repository->getUsers([
            'limit' => 2
        ]);

        $this->assertCount(2, $users);
    }


    public function testRejectsInvalidColumnName(): void
    {
        $this->expectException(Exception::class);

        $this->repository->getUsers([
            'order_by' => 'id; DROP TABLE users'
        ]);
    }
}

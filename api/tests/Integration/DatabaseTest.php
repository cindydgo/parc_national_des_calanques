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


    public function testCreateUser(): void
    {
        $id = $this->repository->createUser([
            'username' => 'Jean',
            'email' => 'jean@test.com'
        ]);

        $this->assertIsInt($id);
        $this->assertGreaterThan(0, $id);

        $user = $this->repository->getUser($id);

        $this->assertNotNull($user);
        $this->assertSame('Jean', $user['username']);
    }


    public function testReadOneUser(): void
    {
        $id = $this->repository->createUser([
            'username' => 'Alice',
            'email' => 'alice@test.com'
        ]);

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
        $id = $this->repository->createUser([
            'username' => 'Bob',
            'email' => 'bob@test.com'
        ]);

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
        $this->repository->createUser([
            'username' => 'Marc',
            'email' => 'marc@test.com'
        ]);


        $result = $this->repository->deleteUser(1);

        $this->assertTrue($result);

        $user = $this->repository->getUser(1);

        $this->assertNull($user);
    }


    public function testWhereFilter(): void
    {
        $this->repository->createUser([
            'username' => 'Paul',
            'email' => 'paul@test.com'
        ]);

        $this->repository->createUser([
            'username' => 'Julie',
            'email' => 'julie@test.com'
        ]);


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
        $this->repository->createUser([
            'username' => 'Zoe',
            'email' => 'zoe@test.com'
        ]);

        $this->repository->createUser([
            'username' => 'Alice',
            'email' => 'alice@test.com'
        ]);


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
            $this->repository->createUser([
                'username' => "User $i",
                'email' => "user$i@test.com"
            ]);
        }


        $users = $this->repository->getUsers([
            'limit' => 2
        ]);

        $this->assertCount(2, $users);
    }
}
